<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 *
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Customers', 'Accounts', 'Sales']
        ];
        $transactions = $this->paginate($this->Transactions);

        $this->set(compact('transactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Users', 'Customers', 'Accounts', 'Sales', 'Transactions']
        ]);

        $this->set('transaction', $transaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->Transactions->newEntity();
        $this->loadModel("Rates");
        if ($this->request->is(['patch', "put", "post"])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            $transaction->user_id = $this->Auth->user()['id'];
            $transaction->daily_rate = $this->Rates->get(2)->amount;
            $transaction->transaction_number = date("dmY").($this->Transactions->find("all", array('conditions' => array('created >=' => date("Y-m-d 00:00:00"), 'created <=' => date('Y-m-d 23:59:59'))))->count() + 1)."";
            if ($new = $this->Transactions->save($transaction)) {
                $this->Flash->success(__('Transaction Sauvegardée'));
            }else{
                $this->Flash->error(__('Impossible de sauvegarder cette transaction. Réessayez ouc ontactez votre administrateur.'));
            }
        }
        return $this->redirect(['controller' => "accounts", 'action' => 'view', $new['account_id']]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel("Rates");
        $transaction = $this->Transactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            $transaction->daily_rate = $this->Rates->get(2)->amount;
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('Transaction Sauvegardée.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de sauvegarder cette transaction. Réessayez ouc ontactez votre administrateur.'));
        }
        $users = $this->Transactions->Users->find('list', ['limit' => 200]);
        $customers = $this->Transactions->Customers->find('list', ['limit' => 200]);
        $accounts = $this->Transactions->Accounts->find('list', ['limit' => 200]);
        $sales = $this->Transactions->Sales->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'users', 'customers', 'accounts', 'sales'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $transaction = $this->Transactions->get($id);
    //     if ($this->Transactions->delete($transaction)) {
    //         $this->Flash->success(__('Transaction Supprimée'));
    //     } else {
    //         $this->Flash->error(__('Impossible de supprimer cette transaction'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
