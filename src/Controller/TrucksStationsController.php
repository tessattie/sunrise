<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TrucksStations Controller
 *
 * @property \App\Model\Table\TrucksStationsTable $TrucksStations
 *
 * @method \App\Model\Entity\TrucksStation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrucksStationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Stations', 'Trucks', 'Users']
        ];
        $trucksStations = $this->paginate($this->TrucksStations);

        $this->set(compact('trucksStations'));
    }

    /**
     * View method
     *
     * @param string|null $id Trucks Station id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $trucksStation = $this->TrucksStations->get($id, [
            'contain' => ['Stations', 'Trucks', 'Users']
        ]);

        $this->set('trucksStation', $trucksStation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $trucksStation = $this->TrucksStations->newEntity();
        if ($this->request->is('post')) {
            $trucksStation = $this->TrucksStations->patchEntity($trucksStation, $this->request->getData());
            if ($this->TrucksStations->save($trucksStation)) {
                $this->Flash->success(__('The trucks station has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The trucks station could not be saved. Please, try again.'));
        }
        $stations = $this->TrucksStations->Stations->find('list', ['limit' => 200]);
        $trucks = $this->TrucksStations->Trucks->find('list', ['limit' => 200]);
        $users = $this->TrucksStations->Users->find('list', ['limit' => 200]);
        $this->set(compact('trucksStation', 'stations', 'trucks', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Trucks Station id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $trucksStation = $this->TrucksStations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $trucksStation = $this->TrucksStations->patchEntity($trucksStation, $this->request->getData());
            if ($this->TrucksStations->save($trucksStation)) {
                $this->Flash->success(__('The trucks station has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The trucks station could not be saved. Please, try again.'));
        }
        $stations = $this->TrucksStations->Stations->find('list', ['limit' => 200]);
        $trucks = $this->TrucksStations->Trucks->find('list', ['limit' => 200]);
        $users = $this->TrucksStations->Users->find('list', ['limit' => 200]);
        $this->set(compact('trucksStation', 'stations', 'trucks', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Trucks Station id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $trucksStation = $this->TrucksStations->get($id);
        if ($this->TrucksStations->delete($trucksStation)) {
            $this->Flash->success(__('The trucks station has been deleted.'));
        } else {
            $this->Flash->error(__('The trucks station could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
