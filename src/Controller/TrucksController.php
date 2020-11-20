<?php
namespace App\Controller;

use App\Controller\AppController;
use thiagoalessio\TesseractOCR\TesseractOCR;


/**
 * Trucks Controller
 *
 * @property \App\Model\Table\TrucksTable $Trucks
 *
 * @method \App\Model\Entity\Truck[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrucksController extends AppController
{


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        ini_set('memory_limit', '1024M');
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $trucks = $this->Trucks->find('all', array('order' => array("immatriculation ASC"), 'conditions' => array('Trucks.status' => 1)))->contain(['Users', 'Sales' => ['conditions' => ['Sales.created >=' => $from, 'Sales.created <=' => $to]]]);

        $this->set(compact('trucks'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function nosales()
    {
        ini_set('memory_limit', '1024M');
        $trucks = $this->Trucks->find('all', array('order' => array("immatriculation ASC")))->contain(['Users', 'Sales'])->limit(200);

        $this->set(compact('trucks'));
    }

    public function alter(){
        $trucks = $this->Trucks->find('all'); 
        $barcode = 827496;
        foreach($trucks as $truck){
            $truck->barcode = $barcode; 
            $this->Trucks->save($truck);
            $barcode++;
        }
        die('DONE WITH TRUCK BARCODE CREATION');
    }

    public function duplicate(){
        $trucks = $this->Trucks->find("all");
        foreach($trucks as $truck){
            $compare = $this->Trucks->find("all", array("conditions" => array("immatriculation" => $truck->immatriculation)));
            if($compare->count() > 1){
                foreach($compare as $c){
                    if(count($c->sales) == 0){
                        $this->Trucks->delete($c);
                    }
                }
            }
        }
        die("DONE DELETING DUPLICATES");
    }

    /**
     * View method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $truck = $this->Trucks->get($id, [
            'contain' => ['Users', 'Sales' => ["Trucks", "Customers", "ProductsSales" => ['Products'], 'conditions' => ['Sales.created >=' => $from, 'Sales.created <=' => $to], 'Users']]
        ]);
        $this->set('truck', $truck);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $truck = $this->Trucks->newEntity();
        if ($this->request->is('post')) {
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());
            $featured_image = false;
            

            $truck->user_id = $this->Auth->user()['id']; 

            // debug($truck); die();
            if ($ident = $this->Trucks->save($truck)) {
               
                $this->Flash->success(__('Le paquet a bien été sauvegardée'));
                $tr = $this->Trucks->get($ident['id']);

                if(!empty($this->request->data['photo']['tmp_name'])){
                    $featured_image = $this->checkfile($this->request->data['photo'], $tr->id, 'trucks');
                }
                if($featured_image != false){
                    $tr->photo = $featured_image;
                }
                $this->Trucks->save($tr);

                return $this->redirect(['action' => 'add']);
            }else{
                debug("unable to save"); die();
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder le paquet. Réessayez plus-tard'));
        }
        $users = $this->Trucks->Users->find('list', ['limit' => 200]);
        $this->set(compact('truck', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $truck = $this->Trucks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $old_photo = $truck->photo;
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());

            $featured_image = false;
            if(!empty($this->request->data['photo']['tmp_name'])){
                $featured_image = $this->checkfile($this->request->data['photo'], $truck->immatriculation, 'trucks');
            }

            if($featured_image != false){
                $truck->photo = $featured_image;
            }else{
                $truck->photo = $old_photo;
            }

            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $users = $this->Trucks->Users->find('list', ['limit' => 200]);
        $this->set(compact('truck', 'users'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function save()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            // debug($this->request->getData())
            $truck = $this->getTruck($this->request->getData()['immatriculation']);
            if($truck == false){
                $this->Flash->error(__('Nous n\'avons pas trouvé un paquet avec ce nom.'));
            }else{
                $this->loadModel('SuppliersTrucks'); 
                $sp = $this->SuppliersTrucks->newEntity();
                $sp->truck_id = $truck->id; 
                $sp->item_id = $this->request->getData()['item_id'];
                $sp->code = $this->request->getData()['barcode'];
                $sp->supplier_id = $this->request->getData()['supplier_id'];
                $this->SuppliersTrucks->save($sp);
            }
            return $this->redirect(['controller' => 'Suppliers', 'action' => 'edit', $this->request->getData()['supplier_id']]);
        }

        die();
    }

    private function getTruck($immatriculation){
        $truck = false; 
        $trucks = $this->Trucks->find('all', array('conditions' => array('immatriculation' => $immatriculation)));
        foreach($trucks as $t){
            $truck = $t;
        }
        return $truck;
    }

    /**
     * Delete method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $truck = $this->Trucks->get($id);
        if ($this->Trucks->delete($truck)) {
            $this->Flash->success(__('Paquet Supprimé'));
        } else {
            $this->Flash->error(__('Impossible de supprimer ce paquet.'));
        }
        return $this->redirect(['action' => 'nosales']);
    }

    public function find(){
        if($this->request->is("ajax")){
            $truck_id = false;
            $this->loadModel('SuppliersTrucks');
            $tis = $this->SuppliersTrucks->find('all', array('code' => $this->request->getData()['truck']));
            foreach($tis as $t){
                $truck_id = $t->truck_id;
            }
            if($truck_id != false){
                $truck = $this->Trucks->get($truck_id, ['contain' => ['SuppliersTrucks' => ['Suppliers', 'Items'], 'Suppliers' => ["Items"]]]);
            }
            // $truck = $this->Trucks->find('all', array('conditions' => array("immatriculation" => $this->request->getData()['truck'])))->contain(['Suppliers']);
            if(empty($truck)){
                echo json_encode("false");
            }else{
               echo json_encode($truck->toArray()); 
            }
            
        }
        die();
    }

}
