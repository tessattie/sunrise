<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotesMovements Controller
 *
 * @property \App\Model\Table\NotesMovementsTable $NotesMovements
 *
 * @method \App\Model\Entity\NotesMovement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotesMovementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Notes', 'Movements']
        ];
        $notesMovements = $this->paginate($this->NotesMovements);

        $this->set(compact('notesMovements'));
    }

    /**
     * View method
     *
     * @param string|null $id Notes Movement id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notesMovement = $this->NotesMovements->get($id, [
            'contain' => ['Notes', 'Movements']
        ]);

        $this->set('notesMovement', $notesMovement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notesMovement = $this->NotesMovements->newEntity();
        if ($this->request->is('post')) {
            $notesMovement = $this->NotesMovements->patchEntity($notesMovement, $this->request->getData());
            if ($this->NotesMovements->save($notesMovement)) {
                $this->Flash->success(__('The notes movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes movement could not be saved. Please, try again.'));
        }
        $notes = $this->NotesMovements->Notes->find('list', ['limit' => 200]);
        $movements = $this->NotesMovements->Movements->find('list', ['limit' => 200]);
        $this->set(compact('notesMovement', 'notes', 'movements'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notes Movement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notesMovement = $this->NotesMovements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notesMovement = $this->NotesMovements->patchEntity($notesMovement, $this->request->getData());
            if ($this->NotesMovements->save($notesMovement)) {
                $this->Flash->success(__('The notes movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes movement could not be saved. Please, try again.'));
        }
        $notes = $this->NotesMovements->Notes->find('list', ['limit' => 200]);
        $movements = $this->NotesMovements->Movements->find('list', ['limit' => 200]);
        $this->set(compact('notesMovement', 'notes', 'movements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notes Movement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notesMovement = $this->NotesMovements->get($id);
        if ($this->NotesMovements->delete($notesMovement)) {
            $this->Flash->success(__('The notes movement has been deleted.'));
        } else {
            $this->Flash->error(__('The notes movement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
