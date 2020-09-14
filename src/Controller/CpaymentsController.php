<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cpayments Controller
 *
 * @property \App\Model\Table\CpaymentsTable $Cpayments
 *
 * @method \App\Model\Entity\Cpayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CpaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'Rates', 'Users']
        ];
        $cpayments = $this->paginate($this->Cpayments);

        $this->set(compact('cpayments'));
    }

    /**
     * View method
     *
     * @param string|null $id Cpayment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cpayment = $this->Cpayments->get($id, [
            'contain' => ['Customers', 'Rates', 'Users']
        ]);

        $this->set('cpayment', $cpayment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cpayment = $this->Cpayments->newEntity();
        if ($this->request->is('post')) {
            $this->loadModel('Customers'); 

            $rate = $this->Rates->get(2)->amount;
            $cpayment = $this->Cpayments->patchEntity($cpayment, $this->request->getData());
            $cpayment->daily_rate = $rate;
            $cpayment->user_id = $this->Auth->user()['id'];
            $customer = $this->Customers->get($cpayment->customer_id);
            if ($this->Cpayments->save($cpayment)) {
                $this->Flash->success(__('Paiement sauvegardé pour le client '. strtoupper($customer->last_name)));  
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cpayment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cpayment = $this->Cpayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cpayment = $this->Cpayments->patchEntity($cpayment, $this->request->getData());
            if ($this->Cpayments->save($cpayment)) {
                $this->Flash->success(__('The cpayment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cpayment could not be saved. Please, try again.'));
        }
        $customers = $this->Cpayments->Customers->find('list', ['limit' => 200]);
        $rates = $this->Cpayments->Rates->find('list', ['limit' => 200]);
        $users = $this->Cpayments->Users->find('list', ['limit' => 200]);
        $this->set(compact('cpayment', 'customers', 'rates', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cpayment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cpayment = $this->Cpayments->get($id);
        if ($this->Cpayments->delete($cpayment)) {
            $this->Flash->success(__('The cpayment has been deleted.'));
        } else {
            $this->Flash->error(__('The cpayment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
