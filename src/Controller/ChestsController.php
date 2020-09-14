<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Chests Controller
 *
 * @property \App\Model\Table\ChestsTable $Chests
 *
 * @method \App\Model\Entity\Chest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Currencies']
        ];
        $chests = $this->paginate($this->Chests);

        $this->set(compact('chests'));
    }

    /**
     * View method
     *
     * @param string|null $id Chest id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chest = $this->Chests->get($id, [
            'contain' => ['Currencies', 'Notes']
        ]);

        $this->set('chest', $chest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chest = $this->Chests->newEntity();
        if ($this->request->is('post')) {
            $chest = $this->Chests->patchEntity($chest, $this->request->getData());
            if ($this->Chests->save($chest)) {
                $this->Flash->success(__('The chest has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chest could not be saved. Please, try again.'));
        }
        $currencies = $this->Chests->Currencies->find('list', ['limit' => 200]);
        $notes = $this->Chests->Notes->find('list', ['limit' => 200]);
        $this->set(compact('chest', 'currencies', 'notes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Chest id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chest = $this->Chests->get($id, [
            'contain' => ['Notes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chest = $this->Chests->patchEntity($chest, $this->request->getData());
            if ($this->Chests->save($chest)) {
                $this->Flash->success(__('The chest has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The chest could not be saved. Please, try again.'));
        }
        $currencies = $this->Chests->Currencies->find('list', ['limit' => 200]);
        $notes = $this->Chests->Notes->find('list', ['limit' => 200]);
        $this->set(compact('chest', 'currencies', 'notes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Chest id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chest = $this->Chests->get($id);
        if ($this->Chests->delete($chest)) {
            $this->Flash->success(__('The chest has been deleted.'));
        } else {
            $this->Flash->error(__('The chest could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
