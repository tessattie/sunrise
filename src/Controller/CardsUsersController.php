<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CardsUsers Controller
 *
 * @property \App\Model\Table\CardsUsersTable $CardsUsers
 *
 * @method \App\Model\Entity\CardsUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CardsUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Cards']
        ];
        $cardsUsers = $this->paginate($this->CardsUsers);

        $this->set(compact('cardsUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Cards User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cardsUser = $this->CardsUsers->get($id, [
            'contain' => ['Users', 'Cards']
        ]);

        $this->set('cardsUser', $cardsUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cardsUser = $this->CardsUsers->newEntity();
        if ($this->request->is('post')) {
            $cardsUser = $this->CardsUsers->patchEntity($cardsUser, $this->request->getData());
            if ($this->CardsUsers->save($cardsUser)) {
                $this->Flash->success(__('The cards user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cards user could not be saved. Please, try again.'));
        }
        $users = $this->CardsUsers->Users->find('list', ['limit' => 200]);
        $cards = $this->CardsUsers->Cards->find('list', ['limit' => 200]);
        $this->set(compact('cardsUser', 'users', 'cards'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cards User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cardsUser = $this->CardsUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cardsUser = $this->CardsUsers->patchEntity($cardsUser, $this->request->getData());
            if ($this->CardsUsers->save($cardsUser)) {
                $this->Flash->success(__('The cards user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cards user could not be saved. Please, try again.'));
        }
        $users = $this->CardsUsers->Users->find('list', ['limit' => 200]);
        $cards = $this->CardsUsers->Cards->find('list', ['limit' => 200]);
        $this->set(compact('cardsUser', 'users', 'cards'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cards User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cardsUser = $this->CardsUsers->get($id);
        if ($this->CardsUsers->delete($cardsUser)) {
            $this->Flash->success(__('The cards user has been deleted.'));
        } else {
            $this->Flash->error(__('The cards user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
