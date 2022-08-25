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
        $this->paginate = [
            'contain' => ['Users', 'Methods', 'Currencies']
        ];
        $movements = $this->paginate($this->Movements);

        $this->set(compact('movements'));
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
