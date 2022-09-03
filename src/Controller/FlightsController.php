<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Flights Controller
 *
 * @property \App\Model\Table\FlightsTable $Flights
 *
 * @method \App\Model\Entity\Flight[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FlightsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $flights = $this->Flights->find("all")->contain(['Stations']);

        $this->set(compact('flights'));
    }

    /**
     * View method
     *
     * @param string|null $id Flight id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $flight = $this->Flights->get($id, [
            'contain' => ['ProductsSales']
        ]);

        $this->set('flight', $flight);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $flight = $this->Flights->newEntity();
        if ($this->request->is('post')) {
            $flight = $this->Flights->patchEntity($flight, $this->request->getData());
            if ($this->Flights->save($flight)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->loadModel("Stations");
        $stations = $this->Stations->find("list", array("order" => array("name ASC")));
        $this->set(compact('flight', 'stations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Flight id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flight = $this->Flights->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $flight = $this->Flights->patchEntity($flight, $this->request->getData());
            if ($this->Flights->save($flight)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->loadModel("Stations");
        $stations = $this->Stations->find("list", array("order" => array("name ASC")));
        $this->set(compact('flight', 'stations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Flight id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $flight = $this->Flights->get($id);
        if ($this->Flights->delete($flight)) {
            $this->Flash->success(__('The flight has been deleted.'));
        } else {
            $this->Flash->error(__('The flight could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
