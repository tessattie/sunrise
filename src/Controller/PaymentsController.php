<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use FPDF;
use Cake\Mailer\Email;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 *
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($customer = false)
    {
        $this->loadModel("Sales");
        if($customer != false){
            // search for payments for this customer and show them
            $payments = $this->Payments->find("all", array("conditions" => array("Payments.customer_id" => $customer), "order" => array('Payments.created DESC')))->contain(['Customers', 'PaymentsSales' => ['Sales'], 'Rates', 'Methods']);
            $cust = $this->Payments->Customers->get($customer);
            $cust->balance = $this->getBalance($customer);
        }else{
            $cust = false;
            $payments = array();
        }
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $customers = $this->Payments->Customers->find('list', ['conditions' => ['id <>' => 1, 'status' => 1]]);


        $this->set(compact('payments', 'customers', 'cust', 'customer'));
    }

    public function setCustomer(){
        $payments = $this->Payments->find("all")->contain(["Sales"]); 
        foreach($payments as $payment){
            $payment->customer_id = $payment->sale->customer_id;
            $this->Payments->save($payment);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['Sales', 'Methods', 'Rates']
        ]);

        $this->set('payment', $payment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($customer = false)
    {
        $payment = $this->Payments->newEntity();
        $sales = array();

        if(!empty($customer)){
            $sales = $this->Payments->PaymentsSales->Sales->find('all', array('conditions' => array("customer_id" => $customer), "order" => array('Sales.created ASC')))->contain(['ProductsSales' => ['Products'], 'Customers' , "PaymentsSales" => ['Payments']]);
            $customer = $this->Payments->PaymentsSales->Sales->Customers->get($customer, ['contain' => ['Rates']]);
        }
        
        if ($this->request->is(["patch", "put", 'post'])){
            if(!empty($this->request->getData()['customer_id']) && empty($this->request->getData()['amount'])){
                $sales = $this->Payments->PaymentsSales->Sales->find('all', array('conditions' => array("customer_id" => $this->request->getData()['customer_id']), "order" => array('created ASC')))->contain(['ProductsSales' => ['Products'], "PaymentsSales" => ['Payments']]);
                $customer = $this->Payments->PaymentsSales->Sales->Customers->get($this->request->getData()['customer_id'], ['contain' => ['Rates']]);
            }
            if(!empty($this->request->getData()['amount'])){
                $customer = $this->Payments->PaymentsSales->Sales->Customers->get($this->request->getData()['customer_id'], ['contain' => ['Rates']]);
                $payment = $this->Payments->newEntity();
                $payment->amount = $this->request->getData()['amount']; 
                $payment->method_id = $this->request->getData()['method_id'];
                $payment->memo = $this->request->getData()['memo'];  
                $payment->rate_id = $customer->rate_id;
                $payment->sale_id = 57249;
                $payment->customer_id = $this->request->getData()['customer_id'];
                
                if($pm = $this->Payments->save($payment)){
                    $accounts = $this->Payments->PaymentsSales->Sales->Customers->Accounts->find('all', array('conditions' => array('customer_id' => $customer->id, 'rate_id' => $customer->rate_id)));
                    foreach($accounts as $a){
                        $account = $a;
                    }
                    if(!empty($account)){
                        $account->balance = $this->getBalance($customer->id);
                        $this->Payments->PaymentsSales->Sales->Customers->Accounts->save($account);
                    }
                    for($i=0;$i < count($this->request->getData()['amounts']); $i++){
                        if($this->request->getData()['amounts'][$i] != 0){
                            if($this->request->getData()['amounts'][$i] != 0){
                                $ps = $this->Payments->PaymentsSales->newEntity();
                                $ps->sale_id = $this->request->getData()['sale_id'][$i];
                                $ps->amount = $this->request->getData()['amounts'][$i];
                                $ps->payment_id = $pm['id'];
                                $this->Payments->PaymentsSales->save($ps);
                            }
                        }
                    }
                }
                return $this->redirect(['action' => "index", $pm['customer_id']]);
            }
            if(empty($customer->id)){
               $customer = $this->Payments->PaymentsSales->Sales->Customers->get($customer, ['contain' => ['Rates']]); 
            }
            
        }



        $methods = $this->Payments->Methods->find('list', ['conditions' => ['id <>' => 3]]);

        $customers = $this->Payments->Customers->find('list', ['conditions' => ['id <>' => 1]]);  
        $this->set(compact('payment', 'customers', 'sales', 'methods', 'rates', 'users', "customer"));
    }


    public function receipt($id){
        $payment = $this->Payments->get($id, ['contain' => ['Customers' => ['Rates']]]);
        $email = "";
        if($this->request->is(['patch', 'put', "post"])){
            $email = $this->request->getData()['email'];
        }

        $this->loadModel('Customers');
        $customer = $payment->customer;
        $customer->balance = $this->getBalance($customer->id);
        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
        $fpdf = new FPDF();
        $fpdf->AddPage();
        $fpdf->Image(ROOT.'/webroot/img/logo.png',10,4,50);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(190,0,date('l j F Y'),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(90,0,utf8_decode("RECU DE PAIEMENT - #" . $payment->id),0,0, 'L');
        if(!empty($customer->first_name)){
            $fpdf->Cell(100,0,utf8_decode("CLIENT #".$customer->customer_number." - ".strtoupper($customer->first_name)),0,0, 'R');
        }else{
            $fpdf->Cell(100,0,utf8_decode("CLIENT #".$customer->customer_number." - ".strtoupper($customer->last_name)),0,0, 'R');
        }
        $fpdf->SetFont('Arial','',12);
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(90,0,utf8_decode("Montant payé"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode(number_format($payment->amount, 2, ".", ",") ." ". $customer->rate->name),0,0, 'R');
        $fpdf->Ln(9);
        $fpdf->Cell(90,0,utf8_decode("Mémo"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode($payment->memo),0,0, 'R');
        $fpdf->Ln(9);
        $fpdf->Cell(90,0,utf8_decode("Balance courante"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode(number_format($customer->balance, 2, ".", ",") . " " . $customer->rate->name),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(15);

        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(190,0,utf8_decode("Nous vous remercions pour votre confiance et espérons vous revoir très bientôt."),0,0, 'L');
        $fpdf->Ln(15);
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(190,0,utf8_decode("Téléphone : +509-2813-0700"),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("Adresse : Tabarre 41, Route de Tabarre, en face Parc Unibank"),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("Site Web : www.vfmateriaux.com"),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("E-mail : comptabilite@vfmateriaux.com"),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("Chèques à l'ordre de : VFM S.A."),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("Virements : Capital Bank [ HTG : 030011008494 ] - [ USD : 03102447749 ]"),0,0, 'L');

        $directoryName = ROOT."/webroot/tmp/VFM_RECU_PM_".$customer->customer_number."_".date('Ymd').'.pdf'; 
        
        if(!empty($email)){
            $fpdf->Output($directoryName,'F');
            $this->send($directoryName, $email, $payment);
            return $this->redirect(['controller' => 'Payments', "action" => "edit", $payment->id]);
        }else{
            $fpdf->Output('I');
        }
        
        die("VOUS POUVEZ FERMER CETTE PAGE");
    }

    public function send($file, $mail, $payment){
        $email = new Email('default');
        $message = "Bonjour,\n\nTrouvez en pièce jointe votre reçu de paiement #".$payment->id." .\n\n Nous vous remercions pour votre confiance. \n\n L'équipe VFM";
        $email->from(['vfmsysteme@gmail.com' => 'VFM'])
            ->to($mail)
            ->subject('VFM - RECU PAIEMENT #'.$payment->id)
            ->attachments(array(1 => $file))
            ->send($message);
    }


    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, 
            ['contain' => ['PaymentsSales' => ["Sales"]]
        ]);
        $customer = $this->Payments->Customers->get($payment->customer_id, ['contain' => ['Rates']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            $payment->sale_id = 55;
            if ($pm = $this->Payments->save($payment)) {
               $payments_sales = $this->Payments->PaymentsSales->find("all", array("conditions" => array("payment_id" => $payment->id))); 
               foreach($payments_sales as $ps){
                    $this->Payments->PaymentsSales->delete($ps);
               }
               for($i=0;$i < count($this->request->getData()['amounts']); $i++){
                    if($this->request->getData()['amounts'][$i] != 0){
                        if($this->request->getData()['amounts'][$i] != 0){
                            $ps = $this->Payments->PaymentsSales->newEntity();
                            $ps->sale_id = $this->request->getData()['sale_id'][$i];
                            $ps->amount = $this->request->getData()['amounts'][$i];
                            $ps->payment_id = $pm['id'];
                            $this->Payments->PaymentsSales->save($ps);
                        }
                    }
                }
            }
        }
        $sales = $this->getPaymentSales($payment->id);
        $sales2 = $this->getUnpaidSales($customer->id);
        $methods = $this->Payments->Methods->find('list', ['limit' => 200]);
        $rates = $this->Payments->Rates->find('list', ['limit' => 200]);
        $customers = $this->Payments->Customers->find('list', ['conditions' => ['id <>' => 1]]); 
        $this->set(compact('payment', 'sales', 'methods', 'rates', 'users', 'customer', 'sales2', 'customers'));
    }

    private function getPaymentSales($payment_id){
        $sales = array(); 
        $in_array = array();
        $payment = $this->Payments->get($payment_id, ['contain' => ['PaymentsSales' => ['Sales' => ['PaymentsSales']]]]); 
        foreach($payment->payments_sales as $ps){
            if(!in_array($ps->sale_id, $in_array)){
                array_push($in_array, $ps->sale_id);
                array_push($sales, $ps->sale);
            }
        }
        return $sales;
    }

    private function getUnpaidSales($customer_id){
        $this->loadModel('Sales');
        $return = array();
        $sales = $this->Sales->find("all", array("conditions" => array("(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)", "Sales.customer_id" => $customer_id)))->contain(['PaymentsSales' => ['Payments']]);
        $i=0;
        foreach($sales as $sale){
            $paid = 0;
            foreach($sale->payments_sales as $ps){
                $paid = $paid + $ps->amount;
            }
            if($paid < $sale->total){
                $return[$i] = $sale;
                $i++;
            }
        }
        return $return;
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
