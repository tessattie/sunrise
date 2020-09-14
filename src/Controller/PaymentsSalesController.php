<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PaymentsSales Controller
 *
 * @property \App\Model\Table\PaymentsSalesTable $PaymentsSales
 *
 * @method \App\Model\Entity\PaymentsSale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsSalesController extends AppController
{

    public function reset(){
        $this->loadModel('PaymentsSales');
        $payments = $this->PaymentsSales->Payments->find('all'); 
        foreach($payments as $payment){
            $ps = $this->PaymentsSales->newEntity(); 
            $ps->sale_id = $payment->sale_id;
            $ps->payment_id = $payment->id; 
            $ps->amount = $payment->amount;
            $this->PaymentsSales->save($ps);
        }
        die();
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sales', 'Payments']
        ];
        $paymentsSales = $this->paginate($this->PaymentsSales);

        $this->set(compact('paymentsSales'));
    }

    /**
     * View method
     *
     * @param string|null $id Payments Sale id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentsSale = $this->PaymentsSales->get($id, [
            'contain' => ['Sales', 'Payments']
        ]);

        $this->set('paymentsSale', $paymentsSale);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentsSale = $this->PaymentsSales->newEntity();
        if ($this->request->is('post')) {
            $paymentsSale = $this->PaymentsSales->patchEntity($paymentsSale, $this->request->getData());
            if ($this->PaymentsSales->save($paymentsSale)) {
                $this->Flash->success(__('The payments sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payments sale could not be saved. Please, try again.'));
        }
        $sales = $this->PaymentsSales->Sales->find('list', ['limit' => 200]);
        $payments = $this->PaymentsSales->Payments->find('list', ['limit' => 200]);
        $this->set(compact('paymentsSale', 'sales', 'payments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payments Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentsSale = $this->PaymentsSales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentsSale = $this->PaymentsSales->patchEntity($paymentsSale, $this->request->getData());
            if ($this->PaymentsSales->save($paymentsSale)) {
                $this->Flash->success(__('The payments sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payments sale could not be saved. Please, try again.'));
        }
        $sales = $this->PaymentsSales->Sales->find('list', ['limit' => 200]);
        $payments = $this->PaymentsSales->Payments->find('list', ['limit' => 200]);
        $this->set(compact('paymentsSale', 'sales', 'payments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payments Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentsSale = $this->PaymentsSales->get($id);
        if ($this->PaymentsSales->delete($paymentsSale)) {
            $this->Flash->success(__('The payments sale has been deleted.'));
        } else {
            $this->Flash->error(__('The payments sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
