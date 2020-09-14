<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Requisitions Controller
 *
 * @property \App\Model\Table\RequisitionsTable $Requisitions
 *
 * @method \App\Model\Entity\Requisition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequisitionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $requisitions = $this->Requisitions->find("all", array("order" => array("Requisitions.created DESC")))->contain(["Customers", "Users"]);

        $this->set(compact('requisitions'));
    }

    /**
     * View method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requisition = $this->Requisitions->get($id, [
            'contain' => ['Customers', 'Users', 'Products', 'Sales']
        ]);

        $this->set('requisition', $requisition);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requisition = $this->Requisitions->newEntity();
        if ($this->request->is('post')) {
            $requisition = $this->Requisitions->patchEntity($requisition, $this->request->getData());

            $photo = false;

            if(!empty($this->request->getData()['photo']['tmp_name'])){
                $photo = $this->checkfile($this->request->getData()['photo'], $requisition->uid, 'requisitions');
            }
            if($photo != false){
                $requisition->photo = $photo;
            }else{
                $requisition->photo = NULL;
            }

            $requisition->user_id = $this->Auth->user()['id'];
            if ($newReq = $this->Requisitions->save($requisition)) {
                $i=0;
                foreach($this->request->getData()['quantity'] as $quantity){
                    if(!empty($quantity)){
                        $rp = $this->Requisitions->RequisitionsProducts->newEntity();
                        $rp->product_id = $this->request->getData()['product_id'][$i];
                        $rp->requisition_id = $newReq['id'];
                        $rp->quantity = $quantity;
                        $this->Requisitions->RequisitionsProducts->save($rp);
                    }
                    
                    $i++;
                }
                $this->Flash->success(__("Réquisition bien sauvegardée"));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Nous n'avons pas pu sauvegarder cette réquisition. Réessayez plus tard ou appelez votre administrateur."));
        }
        $customers = $this->Requisitions->Customers->find('list', ['conditions' => ['id <>' => 1]]);
        $products = $this->Requisitions->Products->find('list', ['order' => ['name ASC']]);
        $this->set(compact('requisition', 'customers', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requisition = $this->Requisitions->get($id, [
            'contain' => ['Products', 'Sales']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $old_photo = $requisition->photo;
            // debug($this->request->data); die();
            $requisition = $this->Requisitions->patchEntity($requisition, $this->request->getData());

            $photo = false;
            if(!empty($this->request->getData()['photo']['tmp_name'])){
                $photo = $this->checkfile($this->request->getData()['photo'], $requisition->uid, 'requisitions');
            }

            if($photo != false){
                $requisition->photo = $photo;
            }else{
                $requisition->photo = $old_photo;
            }

            if ($newReq = $this->Requisitions->save($requisition)) {
                $products = $this->Requisitions->RequisitionsProducts->find("all", array('conditions' => array('requisition_id' => $newReq['id'])));
                foreach($products as $product){
                    $this->Requisitions->RequisitionsProducts->delete($product);
                }   
                $i=0;
                foreach($this->request->getData()['quantity'] as $quantity){
                    if(!empty($quantity)){
                        $rp = $this->Requisitions->RequisitionsProducts->newEntity();
                        $rp->product_id = $this->request->getData()['product_id'][$i];
                        $rp->requisition_id = $newReq['id'];
                        $rp->quantity = $quantity;
                        $rp->used = $this->request->getData()['used'][$i];
                        $this->Requisitions->RequisitionsProducts->save($rp);
                    }
                    $i++;
                }
                $this->Flash->success(__('Mise à jour effectuée.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de faire la mise à jour. Réessayez ou contactez votre administrateur'));
        }
        $customers = $this->Requisitions->Customers->find('list', ['conditions' => ['id <>' => 1]]);
        $products = $this->Requisitions->Products->find('list', ['limit' => 200]);
        $sales = $this->Requisitions->Sales->find('list', ['limit' => 200]);
        $this->set(compact('requisition', 'customers', 'products', 'sales'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $requisition = $this->Requisitions->get($id);
        if ($this->Requisitions->delete($requisition)) {
            $this->Flash->success(__('Réquisition Supprimée'));
        } else {
            $this->Flash->error(__('Impossible de supprimer cette réquisition'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
