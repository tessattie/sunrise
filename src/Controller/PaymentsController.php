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
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $this->loadModel("Sales");
        if($customer != false){
            // search for payments for this customer and show them
            $payments = $this->Payments->find("all", array("conditions" => array("Payments.customer_id" => $customer,"Payments.created >=" => $from, "Payments.created <=" => $to, "Payments.method_id <>" => 3), "order" => array('Payments.created DESC')))->contain(['Customers', 'Rates', 'Methods']);
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
            $sales = $this->Payments->PaymentsSales->Sales->find('all', array('conditions' => array("customer_id" => $customer, 'OR' => array("Sales.status = 0","Sales.status = 4")), "order" => array('Sales.created ASC')))->contain(['ProductsSales' => ['Products'], 'Customers' , "PaymentsSales" => ['Payments']]);
            $customer = $this->Payments->PaymentsSales->Sales->Customers->get($customer, ['contain' => ['Rates']]);
        }
        
        if ($this->request->is(["patch", "put", 'post'])){
            if(!empty($this->request->getData()['customer_id']) && empty($this->request->getData()['amount'])){
                $sales = $this->Payments->PaymentsSales->Sales->find('all', array('conditions' => array("customer_id" => $this->request->getData()['customer_id'], 'OR' => array("Sales.status = 0","Sales.status = 4")), "order" => array('created ASC')))->contain(['ProductsSales' => ['Products'], "PaymentsSales" => ['Payments']]);
                $customer = $this->Payments->PaymentsSales->Sales->Customers->get($this->request->getData()['customer_id'], ['contain' => ['Rates']]);
            }
            if(!empty($this->request->getData()['amount'])){
                $customer = $this->Payments->PaymentsSales->Sales->Customers->get($this->request->getData()['customer_id'], ['contain' => ['Rates']]);
                $payment = $this->Payments->newEntity();
                $payment->amount = $this->request->getData()['amount']; 
                $payment->method_id = $this->request->getData()['method_id'];
                $payment->memo = $this->request->getData()['memo'];  
                $payment->rate_id = $this->request->getData()['rate_id']; 
                $payment->daily_rate = $this->request->getData()['daily_rate']; 
                $payment->type = 2;
                $payment->customer_id = $this->request->getData()['customer_id'];
                
                if($pm = $this->Payments->save($payment)){
  
                }
                return $this->redirect(['action' => "index", $pm['customer_id']]);
            }
            if(empty($customer->id)){
               $customer = $this->Payments->PaymentsSales->Sales->Customers->get($customer, ['contain' => ['Rates']]); 
            }
            
        }

        $methods = $this->Payments->Methods->find('list', ['conditions' => ['id <>' => 3]]);
        $rates = $this->Payments->Rates->find('list', ['limit' => 200]);
        $daily_rate = $this->Payments->Rates->get(2)->amount;
        $this->set(compact('payment',  'sales', 'methods', 'rates',"customer", 'daily_rate'));
    }


    public function receipt($id){
        $payment = $this->Payments->get($id, ['contain' => ['Customers' => ['Rates'], 'Rates']]);
        $email = "";
        if($this->request->is(['patch', 'put', "post"])){
            $email = $this->request->getData()['email'];
        }
        $status = array(0=>"Annulé", 1=> "Actif");
        $this->loadModel('Customers');
        $customer = $payment->customer;
        $customer->balance_at_payment = $this->getBalanceByDate($customer->id, date("Y-m-d H:i:s",strtotime($payment->created)));
        $customer->balance = $this->getBalance($customer->id);
        if($payment->rate_id == 2){
            $customer->balance_after_payment = $customer->balance_at_payment - $payment->amount*$payment->daily_rate;
            if($payment->status == 0){
                $customer->balance_after_payment = $customer->balance_at_payment;
            }
        }else{
            $customer->balance_after_payment = $customer->balance_at_payment - $payment->amount;
            if($payment->status == 0){
                $customer->balance_after_payment = $customer->balance_at_payment;
            }
        }
        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
        $fpdf = new FPDF();
        $fpdf->AddPage();
        $fpdf->Image(ROOT.'/webroot/img/logo.png',10,4,20);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(190,10,date('l j F Y'),0,0, 'R');
        $fpdf->Ln(15);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(90,0,utf8_decode("RECU DE PAIEMENT #" . $payment->id),0,0, 'L');
        if(!empty($customer->first_name)){
            $fpdf->Cell(100,0,utf8_decode("CLIENT #".$customer->customer_number." - ".strtoupper($customer->first_name)),0,0, 'R');
        }else{
            $fpdf->Cell(100,0,utf8_decode("CLIENT #".$customer->customer_number." - ".strtoupper($customer->last_name)),0,0, 'R');
        }
        $fpdf->SetFont('Arial','',12);
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("Statut du paiement : ".$status[$payment->status]),'',0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(90,0,utf8_decode("Balance avant paiement"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode(number_format($customer->balance_at_payment, 2, ".", ",") . " " . $customer->rate->name),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(90,0,utf8_decode("Montant payé"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode(number_format($payment->amount, 2, ".", ",") ." ". $payment->rate->name),0,0, 'R');
        $fpdf->Ln(9);
        if($payment->rate_id == 2){
            $fpdf->Cell(90,0,utf8_decode("Taux"),0,0, 'L');
            $fpdf->Cell(100,0,utf8_decode("1 USD = ".number_format($payment->daily_rate, 2, ".", ",")." HTG"),0,0, 'R');
        }
        if(!empty($payment->memo)){
            $fpdf->Ln(7);
           $fpdf->Cell(90,0,utf8_decode("Mémo"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode($payment->memo),0,0, 'R');
        }
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(90,0,utf8_decode("Balance après paiement"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode(number_format($customer->balance_after_payment, 2, ".", ",") . " " . $customer->rate->name),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(90,0,utf8_decode("Balance courante"),0,0, 'L');
        $fpdf->Cell(100,0,utf8_decode(number_format($customer->balance, 2, ".", ",") . " " . $customer->rate->name),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(15);

        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(190,0,utf8_decode("Nous vous remercions pour votre confiance et espérons vous revoir très bientôt."),0,0, 'L');
        $fpdf->Ln(15);
        $fpdf->Cell(190,0,utf8_decode("Site Web : www.belgazhaiti.com"),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("E-mail : info@belgaz-admin.com"),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("Chèques à l'ordre de : Belgaz S.A."),0,0, 'L');

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
            ['contain' => ['PaymentsSales' => ["Sales"], 'Customers']
        ]);
        
        $customer = $this->Payments->Customers->get($payment->customer_id, ['contain' => ['Rates']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            $payment->created = $this->request->getData()['created']." 12:00:00";
            if ($pm = $this->Payments->save($payment)) {
               $payments_sales = $this->Payments->PaymentsSales->find("all", array("conditions" => array("payment_id" => $payment->id)));  
            }
        }
        $methods = $this->Payments->Methods->find('list', ['limit' => 200, 'conditions' => ['id <>' => 3]]);
        $rates = $this->Payments->Rates->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'methods', 'rates', 'customer'));
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

    public function cancel($id){
        $payment = $this->Payments->get($id);
        $customer = $payment->customer_id;
        $ps = $this->Payments->PaymentsSales->find("all", array("conditions" => array("payment_id" => $id)));
        if($payment->status == 0){
            $payment->status = 1;
        }else{
            $payment->status = 0;
            // delete all related connected invoices
            foreach($ps as $p){
                $this->Payments->PaymentsSales->delete($p);
            }
        }
        $this->Payments->save($payment); 
        return $this->redirect(['action' => 'index', $customer]);
    }
}
