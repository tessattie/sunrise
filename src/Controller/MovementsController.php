<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Movements Controller
 *
 * @property \App\Model\Table\MovementsTable $Movements
 *
 * @method \App\Model\Entity\Movement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MovementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";

        $condition = "Movements.created >= '". $from . "' AND Movements.created <= '" . $to . "' ";
        if ($this->request->is(['patch', 'post', 'put'])){
            if(!empty($this->request->getData()['currency_id'])){
                $condition  .= " AND Movements.currency_id = ".$this->request->getData()['currency_id'];
            }
            if(!empty($this->request->getData()['user_id'])){
                $condition .= " AND Movements.user_id = ".$this->request->getData()['user_id'];
            }
            if(!empty($this->request->getData()['type'])){
                $condition  .= " AND Movements.type = '".$this->request->getData()['type']."' ";
            } 
        }
        $movements = $this->Movements->find('all', array('order' => array('Movements.created DESC'), 'conditions' => array($condition)))->contain(['Users', 'Methods', 'Currencies']);
        // debug($movements->sql()); die();
        $users = $this->Movements->Users->find('list', [ "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($u) {
                return $u->get('name');
            }
        ]);  


        $currencies = $this->Movements->Currencies->find('list'); 
        $types = array("" => "TOUS", "debit" => "DEBIT", "credit" => "CREDIT");
        $this->set(compact('movements', 'users', "currencies", "types"));
    }

    /**
     * View method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $movement = $this->Movements->get($id, [
            'contain' => ['Users', 'Methods', 'Currencies', 'NotesChests']
        ]);

        $this->set('movement', $movement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $movement = $this->Movements->newEntity();
        if ($this->request->is('post')) {
            $movement = $this->Movements->patchEntity($movement, $this->request->getData());
            if ($this->Movements->save($movement)) {
                $this->Flash->success(__('The movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The movement could not be saved. Please, try again.'));
        }
        $users = $this->Movements->Users->find('list', ['limit' => 200]);
        $methods = $this->Movements->Methods->find('list', ['limit' => 200]);
        $currencies = $this->Movements->Currencies->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'users', 'methods', 'currencies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $movement = $this->Movements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $movement = $this->Movements->patchEntity($movement, $this->request->getData());
            if ($this->Movements->save($movement)) {
                $this->Flash->success(__('The movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The movement could not be saved. Please, try again.'));
        }
        $users = $this->Movements->Users->find('list', ['limit' => 200]);
        $methods = $this->Movements->Methods->find('list', ['limit' => 200]);
        $currencies = $this->Movements->Currencies->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'users', 'methods', 'currencies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $movement = $this->Movements->get($id);
        if ($this->Movements->delete($movement)) {
            $this->Flash->success(__('The movement has been deleted.'));
        } else {
            $this->Flash->error(__('The movement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
