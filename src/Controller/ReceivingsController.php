<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Receivings Controller
 *
 * @property \App\Model\Table\ReceivingsTable $Receivings
 *
 * @method \App\Model\Entity\Receiving[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReceivingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $receivings = $this->Receivings->find("all", array("conditions" => array("Receivings.created >=" => $from, "Receivings.created <=" => $to), "order" => array('Receivings.id ASC')))->contain(['Users', 'Trucks', 'Items', 'Suppliers' => ['Items']]);

            $types = $this->Receivings->types;
        $this->set(compact('receivings', "items", "types"));
    }

    /**
     * View method
     *
     * @param string|null $id Receiving id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receiving = $this->Receivings->get($id, [
            'contain' => ['Users', 'Trucks', 'Suppliers']
        ]);

        $this->set('receiving', $receiving);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $receiving = $this->Receivings->newEntity();
        if ($this->request->is('post')) {
            // debug($this->request->data); 
            // die();
            $receiving = $this->Receivings->patchEntity($receiving, $this->request->getData());
            $receiving->user_id = $this->Auth->user()['id'];
            $receiving->receiving_number = $this->Receivings->find("all")->count() + 1 + 250000;
            $receiving->status = 1;
            $receiving->item_id = $this->request->getData()['item']; 
            // debug($receiving); 
            // die();
            if ($ident = $this->Receivings->save($receiving)) {
                $this->Flash->success(__('Réception sauvegardée'));
                return $this->redirect(['action' => 'add']);
            }else{
                $this->Flash->error(__('Impossible de sauvegarder la reception. Contactez votre administrateur'));
            }
            
        }
        $prices = $this->Receivings->Suppliers->Items->find("list", ['keyField' => 'id', 'valueField' => 'price']);
        $suppliers = $this->Receivings->Suppliers->find('list');
        $items = $this->Receivings->Suppliers->Items->find("list");
        $this->set(compact('receiving', 'users', 'trucks', 'suppliers', "items", 'prices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Receiving id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receiving = $this->Receivings->get($id, [
            'contain' => ['Users', 'Trucks', 'Suppliers', 'Items']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // debug($this->request->data); die();
            $receiving = $this->Receivings->patchEntity($receiving, $this->request->getData());
            if($receiving->status == 1){
                $receiving->status = 2;
            }
            if ($this->Receivings->save($receiving)) {
                $this->Flash->success(__('The receiving has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receiving could not be saved. Please, try again.'));
        }
        $suppliers = $this->Receivings->Suppliers->find('list', array("order" => array("name ASC")));
        $items = $this->Receivings->Suppliers->Items->find("list")->toArray();
        $prices = $this->Receivings->Suppliers->Items->find("list", ['keyField' => 'id', 'valueField' => 'price']);
        $types = $this->Receivings->types;
        $this->set(compact('receiving', 'users', 'trucks', 'suppliers', "items", "types", 'prices'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Receiving id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receiving = $this->Receivings->get($id);
        if ($this->Receivings->delete($receiving)) {
            $this->Flash->success(__('The receiving has been deleted.'));
        } else {
            $this->Flash->error(__('The receiving could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
