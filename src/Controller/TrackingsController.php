<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Trackings Controller
 *
 * @property \App\Model\Table\TrackingsTable $Trackings
 *
 * @method \App\Model\Entity\Tracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductsSales', 'Flights', 'Movements', 'Users', 'Stations']
        ];
        $trackings = $this->paginate($this->Trackings);

        $this->set(compact('trackings'));
    }

    /**
     * View method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tracking = $this->Trackings->get($id, [
            'contain' => ['ProductsSales', 'Flights', 'Movements', 'Users', 'Stations']
        ]);

        $this->set('tracking', $tracking);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tracking = $this->Trackings->newEntity();
        if ($this->request->is('post')) {
            $tracking = $this->Trackings->patchEntity($tracking, $this->request->getData());
            if ($this->Trackings->save($tracking)) {
                $this->Flash->success(__('The tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tracking could not be saved. Please, try again.'));
        }
        $productsSales = $this->Trackings->ProductsSales->find('list', ['limit' => 200]);
        $flights = $this->Trackings->Flights->find('list', ['limit' => 200]);
        $movements = $this->Trackings->Movements->find('list', ['limit' => 200]);
        $users = $this->Trackings->Users->find('list', ['limit' => 200]);
        $stations = $this->Trackings->Stations->find('list', ['limit' => 200]);
        $this->set(compact('tracking', 'productsSales', 'flights', 'movements', 'users', 'stations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tracking = $this->Trackings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tracking = $this->Trackings->patchEntity($tracking, $this->request->getData());
            if ($this->Trackings->save($tracking)) {
                $this->Flash->success(__('The tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tracking could not be saved. Please, try again.'));
        }
        $productsSales = $this->Trackings->ProductsSales->find('list', ['limit' => 200]);
        $flights = $this->Trackings->Flights->find('list', ['limit' => 200]);
        $movements = $this->Trackings->Movements->find('list', ['limit' => 200]);
        $users = $this->Trackings->Users->find('list', ['limit' => 200]);
        $stations = $this->Trackings->Stations->find('list', ['limit' => 200]);
        $this->set(compact('tracking', 'productsSales', 'flights', 'movements', 'users', 'stations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tracking = $this->Trackings->get($id);
        if ($this->Trackings->delete($tracking)) {
            $this->Flash->success(__('The tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
