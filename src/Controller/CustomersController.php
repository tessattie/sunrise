<?php
namespace App\Controller;

use App\Controller\AppController;
use PHPExcel; 
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use Cake\Datasource\ConnectionManager;
use PHPExcel_Cell_DataValidation;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

    public function simulation(){
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $pourcentage = 0;
        $de = 0;
        $a = 0;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pourcentage = $this->request->getData()['pourcentage'];
            $de = $this->request->getData()['interval_from'];
            $a = $this->request->getData()['interval_to'];
        }
        $conn = ConnectionManager::get('default');
        $sales = $conn->query("SELECT SUM(ps.quantity) as quantity, SUM(s.total) as total, s.truck_id, t.immatriculation 
            FROM products_sales ps
            LEFT JOIN sales s ON s.id = ps.sale_id
            LEFT JOIN trucks t ON t.id = s.truck_id
            WHERE s.created >= '".$from."' AND s.created <= '".$to."' AND (s.status = 1 OR s.status = 10)
            GROUP BY s.truck_id
            ORDER BY s.truck_id"); 
        $this->set('sales', $sales);
        $this->set('pourcentage', $pourcentage);
        $this->set('de', $de);
        $this->set('a', $a);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $customers = $this->Customers->find("all", array("order" => array("last_name ASC"), 'conditions' => array("Customers.id <>" => 1, 'Customers.type <>' => 3)))->contain(['Rates', 'Payments', 'Sales' => ['conditions' => ['Sales.created >=' => $from, 'Sales.created <=' => $to]]]);

        $this->set(compact('customers'));
    }

    public function statements(){
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $customers = $this->Customers->find("list");
        $sales = array();
        $payments = array();
        $customer_balance = 0;
        $customer_balance_before = 0;
        if($this->request->is(['patch', 'put', 'post'])){
            $sales = $this->Customers->Sales->find("all", array("conditions" => array("customer_id" => $this->request->getData()['customer_id'], "OR" => array("Sales.status = 0", "Sales.status = 1", 'Sales.status = 4', 'Sales.status = 6', "Sales.status = 7"), 'Sales.created >=' => $from, 'Sales.created <=' => $to)))->contain(['Customers' => ['Rates']]);
            $payments = $this->Customers->Payments->find("all", array("conditions" => array("customer_id" => $this->request->getData()['customer_id'], "status" => 1, 'Payments.created >=' => $from, 'Payments.created <=' => $to)))->contain(['Rates']);
            $customer = $this->Customers->get($this->request->getData()['customer_id'], ['contain' => ['Rates']]);
            $customer_balance = $this->getBalance($this->request->getData()['customer_id']);
            $customer_balance_before = $this->getBalanceByDate($this->request->getData()['customer_id'], $from);
        }
        
        $this->set("customers", $customers); 
        $this->set("customer", $customer); 
        $this->set("sales", $sales); 
        $this->set("from", $from); 
        $this->set("to", $to); 
        $this->set("payments" ,$payments);
        $this->set("customer_balance" ,$customer_balance);
        $this->set("customer_balance_before" ,$customer_balance_before);
   }

    public function reset(){
        $sales = $this->Customers->Sales->find('all', array('conditions' => array('customer_id' => 736, "Sales.created >=" => "2020-08-31 00:00:00", "Sales.created <=" => "2020-08-31 23:59:59")))->contain(['Trucks', 'ProductsSales']);
        foreach($sales as $sale){
            $sale->subtotal = $sale->truck->volume*21; 
            if($sale->transport == 1){
                $sale->transport_fee = $sale->truck->volume*7;
            }
            $sale->total = $sale->subtotal + $sale->transport_fee;
            if($this->Customers->Sales->save($sale)){
                $ps = $this->Customers->Sales->ProductsSales->get($sale->products_sales[0]->id); 
                $ps->price = 21; 
                $ps->quantity = $sale->truck->volume;
                $ps->totalPrice = $ps->quantity*21;
                $this->Customers->Sales->ProductsSales->save($ps);
            }
        }
        die("DONE");
   }



    public function update(){
        $customers = $this->Customers->find('all'); 
        foreach($customers as $customer){
            if(empty($customer->last_name)){
                $customer->last_name = strtoupper($customer->first_name);
                $this->Customers->save($customer);
            }
        }
        die();
    }

    public function bulk(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel.php');
            require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
            $file = $this->request->getData()['customers']['tmp_name'];

            //  Read Excel
            try {
                $inputFileType = PHPExcel_IOFactory::identify($file);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $excel = $objReader->load($file);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $types = array("CREDIT" => 1, "CHEQUE" => 2);
            $rates = array("HTG" => 1, "USD" => 2);
            $statuses = array("BLOQUE" => 0, "ACTIF" => 1);

            $sheet = $excel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 3; $row <= $highestRow; $row++){ 
                //  Read a row of data into an array
                $customer = $this->Customers->get($sheet->getCell("J".$row)->getValue());
                if(!empty($customer)){
                    $customer->last_name = $sheet->getCell("A".$row)->getValue();
                    $customer->first_name = $sheet->getCell("B".$row)->getValue();
                    $customer->type = $types[$sheet->getCell("C".$row)->getValue()];
                    $customer->rate_id = $rates[$sheet->getCell("D".$row)->getValue()];
                    $customer->phone = $sheet->getCell("E".$row)->getValue();
                    $customer->email = $sheet->getCell("F".$row)->getValue();
                    $customer->credit_limit = $sheet->getCell("G".$row)->getValue();
                    $customer->discount = $sheet->getCell("H".$row)->getValue();
                    $customer->status = $statuses[$sheet->getCell("I".$row)->getValue()];
                    $this->Customers->save($customer);
                }
                //  Insert row data array into your database of choice here
            }


        }

        return $this->redirect(['action' => 'index']);
    }

    public function find(){
        if($this->request->is("ajax")){
            $customer = $this->Customers->find('all', array('conditions' => array("id" => $this->request->getData()['id'])))->contain(["Requisitions" => ['RequisitionsProducts'], 'Accounts' => ['Rates']]);
            foreach($customer as $c){
                $balance = 0;
                foreach($c->accounts as $account){
                    if($account->rate_id == 1){
                        $balance = $balance + ( $account->balance / $account->rate->amount );
                    }else{
                        $balance = $balance + $account->balance;
                    }
                }
                $c->credit_available = $c->credit_limit + $balance;
            }
            if($customer->count() == 0){
                echo json_encode("false");
            }else{
               echo json_encode($customer->toArray()); 
            }
            
        }
        
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $customer = $this->Customers->get($id, [
            'contain' => ['Users', 'Rates', 'Sales' => ["Trucks", "Customers", 'users', "ProductsSales" => ['Products'], 'conditions' => ['Sales.created >=' => $from, 'Sales.created <=' => $to]]]
        ]);
        $customer->balance = $this->getBalance($customer->id);
        $this->set('customer', $customer);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            $customer->user_id = $this->Auth->user()['id'];
            $customer->type = 1;
            if ($ident = $this->Customers->save($customer)) {
                $this->Flash->success(__('Le client a bien été sauvegardée'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder le client. Réessayez plus-tard'));
        }
        $users = $this->Customers->Users->find('list', ['limit' => 200]);
        $this->set(compact('customer', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $users = $this->Customers->Users->find('list', ['limit' => 200]);
        $this->set(compact('customer', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', "get"]);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function import(){
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . "Classes" . DS . 'PHPExcel.php');
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . "Classes" . DS . 'PHPExcel'.DS.'IOFactory.php');
        
        $excel = new PHPExcel();

        $file = "C:/wamp/www/vfm/webroot/tmp/clients.xlsx";

        try {
            $inputFileType = PHPExcel_IOFactory::identify($file);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(1); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();

        debug($highestRow);

        // //  Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++){ 
            //  create customer

            $customer = $this->Customers->newEntity();

            $customer->first_name = $sheet->getCell("B".$row)->getValue();
            $customer->email = $sheet->getCell("D".$row)->getValue();
            $customer->phone = $sheet->getCell("F".$row)->getValue();
            $customer->user_id = $this->Auth->user()['id'];
            $customer->customer_number = 4500 + $row;
            $customer->created = date('Y-m-d H:i:s');
            $customer->modified = date('Y-m-d H:i:s');


            if($ident = $this->Customers->save($customer)){
                $currency = $sheet->getCell("N".$row)->getValue();
                $balance = $sheet->getCell("O".$row)->getValue();
                if($balance != 0){
                    $this->loadModel('Transactions');$this->loadModel('Rates');
                    $account = $this->Customers->Accounts->find('all', array('conditions' => array('customer_id' => $ident['id'], "rate_id" => $currency)));
                    foreach($account as $a){
                        $current = $a;
                    }

                    $transaction = $this->Transactions->newEntity();
                    $transaction->account_id = $current->id;
                    $transaction->customer_id = $current->customer_id;
                    $transaction->user_id = $this->Auth->user()['id'];
                    $transaction->created = date('Y-m-d H:i:s');
                    $transaction->modified = date('Y-m-d H:i:s');
                    $transaction->transaction_number = date("dmY").($this->Transactions->find("all", array('conditions' => array('created >=' => date("Y-m-d 00:00:00"), 'created <=' => date('Y-m-d 23:59:59'))))->count() + 1)."";
                    if($balance > 0){
                        $transaction->type = 1;
                    }else{
                        $transaction->type = 2;
                    }
                    $transaction->amount = $balance;
                    $transaction->daily_rate = $this->Rates->get(2)->amount;
                    $this->Transactions->save($transaction);
                }
            
            }

            // add transaction 
            //  Insert row data array into your database of choice here
        }
        die();
    }

    public function updateCustomerType(){
        $customers = $this->Customers->find("all");
        foreach($customers as $customer){
            if(strpos($customer->first_name, "CH-") === false){
                // $customer->first_name = str_replace("CH-", "", $customer->first_name); 
                $customer->type = 1;
                $this->Customers->save($customer);
            }else{
                $customer->first_name = str_replace("CH-", "", $customer->first_name); 
                $customer->type = 2;
                $this->Customers->save($customer);
            }
        }
        die();
    }

    public function invoices(){
        $sales = array();
        $month = date("m", strtotime($this->request->session()->read("from")));
        $year = date("Y", strtotime($this->request->session()->read("from")));
        $customer = "";
        $condition = "(s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7)";
        if ($this->request->is(['patch', 'post', 'put'])){
            $customer = $this->Customers->get($this->request->getData()['customer_id'], ['contain' => [
                "Rates"
            ]]);
            $from = $this->request->session()->read("from")." 00:00:00";
            $to = $this->request->session()->read("to")." 23:59:59";
            $conn = ConnectionManager::get('default');
            $sales = $conn->query("SELECT s.sale_number, ps.quantity, t.immatriculation, p.abbreviation, p.name, s.created, s.total FROM `sales` s 
                LEFT JOIN products_sales ps on ps.sale_id = s.id
                LEFT JOIN trucks t ON t.id = s.truck_id
                LEFT JOIN products p ON p.id = ps.product_id
                WHERE s.customer_id = ".$this->request->getData()['customer_id']." AND s.created >= '".$from."' AND s.created <= '".$to."' AND ".$condition." 
                ORDER BY ps.product_id ASC, s.created ASC"); 
            }
        $customers = $this->Customers->find('list', [ "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);  

        $this->set('customers', $customers);
        $this->set('customer', $customer);
        $this->set('sales', $sales);
        $this->set('month', $month);
        $this->set('year', $year);
    }

    public function products(){
        $this->loadModel('Products');
        $conn = ConnectionManager::get('default');
        $from = $this->request->session()->read("from");
        $to = $this->request->session()->read("to");
        $from_s = $this->request->session()->read("from")." 00:00:00";
        $to_s = $this->request->session()->read("to")." 23:59:59";

        $condition = "(o.status = 1 OR o.status = 0 OR o.status = 4)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(o.status = 0 OR o.status = 4)";
        }

        $products = $this->Products->find("all", array("order" => array("position ASC")));
        $customers = $this->Customers->find("all", array("order" => array("first_name ASC", "last_name ASC")));
        foreach($customers as $customer){
            $customer->products = $conn->query("SELECT p.id, p.position, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer->id." AND o.created >= '".$from_s."' AND o.created <= '".$to_s."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer->id." AND o.created >= '".$from_s."' AND o.created <= '".$to_s."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_trips 
                FROM `products` p 
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY p.position ASC");  
            $query = $conn->query("SELECT  SUM(o.total) as total FROM sales o WHERE o.customer_id = ".$customer->id." AND o.created >= '".$from_s."' AND o.created <= '".$to_s."' AND ".$condition."
                GROUP BY o.customer_id 
                ORDER BY o.customer_id"); 
            $customer->total = 0;
            foreach($query as $q){
                $customer->total = $q['total'];
            }
            $customer->transport = 0;
        }
        $this->set(compact("products", "from", "to", "customers"));
    }

    private function getCustomerBalance($customer, $date){
        
    }
}
