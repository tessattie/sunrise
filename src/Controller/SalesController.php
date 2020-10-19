<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use FPDF;
use Cake\Mailer\Email;
use Cake\Mailer\Transport\Smtp;
use Cake\Event\Event;


/**
 * Sales Controller
 *
 * @property \App\Model\Table\SalesTable $Sales
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->Auth->allow(array('daily', 'send', 'cubage'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        ini_set('memory_limit', '1024M');
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  = "(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }
        $truck_type = 0;
        $customer = '99999';
        $user = '99999';
        $reussies = 1;
        $transport = 1;

        if ($this->request->is(['patch', 'post', 'put'])){
            if(!empty($this->request->getData()['reussies']) && $this->request->getData()['reussies'] == 2){
                $reussies = 2;
                $condition  = "(Sales.status = 2 OR Sales.status = 3 OR Sales.status = 5)";
            }
            if(!empty($this->request->getData()['transport']) && $this->request->getData()['transport'] == 3){
                $transport = 3;
                $condition .= "AND Sales.transport = 0 ";
            }
            if(!empty($this->request->getData()['transport']) && $this->request->getData()['transport'] == 2){
                $transport = 2;
                $condition  .= "AND Sales.transport = 1 ";
            }

            if(!empty($this->request->getData()['customer_id'])){
                $customer = $this->request->getData()['customer_id'];
                $condition .= " AND Sales.customer_id = ".$this->request->getData()['customer_id'];
            }

            if(!empty($this->request->getData()['user_id'])){
                $user = $this->request->getData()['user_id'];
                $condition .= " AND Sales.user_id = ".$this->request->getData()['user_id'];
            }
            if($this->request->getData()['type'] == 1){
                $truck_type = 1;
                $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales" => ['Products']])->matching('ProductsSales', function ($q) {
                        return $q->where(['ProductsSales.quantity >' => 3]);
                    });
            }elseif($this->request->getData()['type'] == 2){
                $truck_type = 2;
               $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales" => ['Products']])->matching('ProductsSales', function ($q) {
                        return $q->where(['ProductsSales.quantity <=' => 3]);
                    });
            }else{
                $truck_type = 0;
                $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', 'ProductsSales'  => ['Products']]);
            }
        }else{
		$sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales"  => ['Products']]);
        }

        $customers = $this->Sales->Customers->find('list', [ "order" => ['last_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);  

        $users = $this->Sales->Users->find('all', [ "conditions" => array('id=9 OR id=15 OR id=11'), "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($u) {
                return $u->get('name');
            }
        ]); 
        $this->set(compact('sales', 'truck_type', 'users', 'customers', 'customer', 'user', 'reussies', 'transport'));
    }


    public function transport()
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";

        if ($this->request->is(['patch', 'post', 'put'])){
            if(!empty($this->request->getData()['immatriculation'])){
                $immatriculation = $this->request->getData()['immatriculation'];
                $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, "Sales.transport" => 1, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales" => ['Products']])->matching('Trucks', function ($q) use ($immatriculation) {
                        return $q->where(['Trucks.immatriculation' => $immatriculation]);
                    });
            }else{
                $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, "Sales.transport" => 1, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', 'ProductsSales'  => ['Products']]);
            }
        }else{
        $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to,  "Sales.transport" => 1, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales"  => ['Products']]);
        }
        

        $this->set(compact('sales'));
    }

    public function canceled(){
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";

        $condition = "(Sales.status = 2 OR Sales.status = 3 OR Sales.status = 5 OR Sales.status = 8 OR Sales.status = 9)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 3 OR Sales.status = 5 OR Sales.status = 8 OR Sales.status = 9)";
        }

        $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales"  => ['Products']]);

        $this->set(compact('sales'));
    }

    public function monthly(){
        $this->loadModel('Products');
        $from = date("Y-m-01", strtotime($this->request->session()->read("from")));
        $to = date("Y-m-t", strtotime($this->request->session()->read("from")));
        $from_s = date("Y-m-01", strtotime($this->request->session()->read("from")))." 00:00:00";
        $to_s = date("Y-m-t", strtotime($this->request->session()->read("from")))." 23:59:59";

        $products = $this->Products->find("all", array("order" => array("position ASC")));

        $conn = ConnectionManager::get('default');
        $sales = $conn->query("SELECT SUM(sp.quantity) AS total, DATE(s.created) as date, p.name as product, p.id
            FROM sales s 
            LEFT JOIN products_sales sp ON sp.sale_id = s.id 
            LEFT JOIN products p ON p.id = sp.product_id 
            WHERE s.created >='".$from_s."' AND s.created <= '".$to_s."' AND (s.status = 0 OR s.status = 1 OR s.status =4 OR s.status = 6 OR s.status =7)
            GROUP BY DATE(s.created), sp.product_id"); 

        $this->set(compact('sales', "products", "from", "to"));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function status()
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";

        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }

        $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales"  => ['Products']]);        

        $this->set(compact('sales'));
    }


    public function search(){
        if ($this->request->is(['patch', 'post', 'put'])){
            $sale = $this->Sales->find("all", array("conditions" => array("sale_number" => $this->request->getData()['sale_ident'])));
            foreach($sale as $s){
                $id = $s->id;
            } 
            return $this->redirect(['action' => 'view', $id]);
        }
    }

    public function send($file){
        $email = new Email('default');
        $message = "Bonjour à tous!\n\nTrouvez en pièce jointe le rapport journalier des ventes à la VFM.\n\n Bonne fin d'après midi! \n\n Système VFM";
        $email->from(['vfmsysteme@gmail.com' => 'VFM'])
            ->to("jlvorbe@vfmateriaux.com", "Jean Luc Vorbe")
            ->addTo('comptabilite@vfmateriaux.com', 'Comptabilite VFM')
            ->subject('VFM - Rapport Journalier des ventes')
            ->attachments(array(1 => $file))
            ->send($message);
    }

    public function cubage(){
        $from = date('Y-m-d 00:00:00'); 
        $to = date('Y-m-d 23:59:59'); 

        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, "Sales.created <=" => $to)))->contain(['ProductsSales', 'Trucks']); 
        foreach($sales as $sale){
            foreach($sale->products_sales as $ps){
                $product_sale = $this->Sales->ProductsSales->get($ps->id); 
                $product_sale->quantity = $sale->truck->volume;
                $product_sale->total = $product_sale->quantity*$product_sale->price;
                $this->Sales->ProductsSales->save($product_sale);
            }
        }
        die();
    }

    public function dashboard(){
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";

        // Total Sales
        $total_sales = $this->getTotalSales($from, $to);

        $volume = $this->getTotalVolume($from, $to);

        $count = $this->getSalesCount($from, $to);

        $product_data = $this->getProductData($from, $to);

        $best_clients = $this->getBestClients($from,$to);

        $best_trucks = $this->getBestTrucks($from, $to);

        $truck_ratios = $this->getTrucksRatio($from, $to);

        $transport_ratios = $this->getTransportRatio($from, $to);

        $sales = $this->Sales->find("all", array("conditions" => array("Sales.created >=" => $from, 'Sales.created <=' => $to, 'sortie' => 0)));

        $users = $this->Sales->Users->find('all', [ "conditions" => array('id=9 OR id=15 OR id=11'), "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($u) {
                return $u->get('name');
            }
        ]);  
        $i=0;
        foreach($users as $user){
            $closing[$i] = $this->getClosingValues($user->id, $from, $to);
            $closing[$i]['user'] = strtoupper($user->last_name)." ".strtoupper($user->first_name);
            $i++;
        }

        $salesDetails = array("cashHTG" => $this->getSalesCashHTG($from, $to), 'cashUSD' => 0, 'creditHTG' => $this->getSalesCreditHTG($from, $to), 'creditUSD' => $this->getSalesCreditUSD($from, $to), 'chequeUSD' => $this->getSalesChequeUSD($from, $to), 'chequeHTG' => $this->getSalesChequeHTG($from, $to));
        
        $this->set(compact('from', 'to', "total_sales", 'volume', 'count', 'product_data', 'best_clients', 'best_trucks', 'truck_ratios', 'transport_ratios', 'salesDetails', 'sales', 'closing'));
    }

    private function getProductData($from, $to){
        $conn = ConnectionManager::get('default');

        $condition = "(o.status = 1 OR o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        }

        return $conn->query("SELECT p.`abbreviation`, p.`cash_price`, IFNULL((SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
            WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition." 
            GROUP BY op.product_id 
            ORDER BY op.product_id),0) AS total_sold 
            FROM `products` p 
            ORDER BY total_sold DESC"); 
    }

    private function getBestClients($from, $to){
        $conn = ConnectionManager::get('default');

        $condition = "(o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        $conn->query("CREATE OR REPLACE VIEW best_clients AS ( SELECT c.`first_name`, c.`last_name`, c.id, IFNULL((SELECT SUM(ps.quantity) FROM products_sales ps LEFT JOIN sales o ON ps.sale_id = o.id WHERE o.customer_id = c.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition." GROUP BY o.customer_id ORDER BY o.customer_id),0) AS total_sold, IFNULL((SELECT COUNT(ps.quantity) FROM products_sales ps LEFT JOIN sales o ON ps.sale_id = o.id WHERE o.customer_id = c.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition." GROUP BY o.customer_id ORDER BY o.customer_id),0) AS total_trips FROM `customers` c WHERE c.id != 1 )");
        $bestest = $conn->query("SELECT * FROM best_clients WHERE total_sold != 0 ORDER BY total_sold DESC LIMIT 0,10");
        return $bestest;
    }

    private function getBestTrucks($from, $to){
        $conn = ConnectionManager::get('default');

        $condition = "(o.status = 1)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(o.status = 0 OR o.status = 4 or o.status = 1)";
        }
        $conn->query("CREATE OR REPLACE VIEW best_trucks AS ( SELECT t.`name`, t.`immatriculation`, t.id, IFNULL((SELECT SUM(ps.quantity) FROM products_sales ps LEFT JOIN sales o ON ps.sale_id = o.id WHERE o.truck_id = t.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition." GROUP BY o.truck_id ORDER BY o.truck_id),0) AS total_sold,  IFNULL((SELECT COUNT(ps.quantity) FROM products_sales ps LEFT JOIN sales o ON ps.sale_id = o.id WHERE o.truck_id = t.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition." GROUP BY o.truck_id ORDER BY o.truck_id),0) AS total_trips FROM `trucks` t )");
        $bestest = $conn->query("SELECT * FROM best_trucks WHERE total_sold != 0 ORDER BY total_sold DESC LIMIT 0,10");
        return $bestest;
    }


    private function getTrucksRatio($from, $to){
        $canter=0;$six=0;$ten=0;; $canter_v=0;$six_v=0;$ten_v=0;

        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }

        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, $condition)))->contain(['ProductsSales', 'Trucks']);

        foreach($sales as $sale){
            if($sale->truck->volume <= 3){
                $canter = $canter + 1; 
                $canter_v = $canter_v + $sale->products_sales[0]->quantity;    
            }elseif($sale->truck->volume >3 && $sale->truck->volume <= 9){
                $six = $six + 1; 
                $six_v = $six_v + $sale->products_sales[0]->quantity;
            }else{
                $ten = $ten + 1;
                $ten_v = $ten_v + $sale->products_sales[0]->quantity;
            }
        }

          $bestest[0] = array("value" => $ten, 'color' => "#30a5ff", "highlight" => "#62b9fb", "label" => "CAMIONS 10 ROUES (VOYAGES)", "volume" => $ten_v);  

          $bestest[1] = array("value" => $six, 'color' => "#ffb53e", "highlight" => "#fac878", "label" => "CAMIONS 6 ROUES (VOYAGES)", "volume" => $six_v);  

          $bestest[2] = array("value" => $canter, 'color' => "#1ebfae", "highlight" => "#3cdfce", "label" => "CANTERS (VOYAGES)", "volume" => $canter_v);   
        
        return $bestest;
    }

    private function getTransportRatio($from, $to){
        $cash = 0; $credit = 0; $cheque=0; $transport = 0;

        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from,'Sales.created <=' => $to, $condition)))->contain(['ProductsSales']);

        foreach($sales as $sale){

            if($sale->status == 0 || $sale->status == 7){
                if($sale->transport == 0){
                    $credit = $credit + 1;
                }else{
                    $transport = $transport + 1;
                }
                
            }
            if($sale->status == 4 || $sale->status == 6){
                $cheque = $cheque + 1;
            }
            if($sale->status == 1){
                $cash = $cash + 1;
            }
        }

        $bestest[0] = array("value" => round($cash), 'color' => "#30a5ff", "highlight" => "#62b9fb", "label" => "CASH");  
        $bestest[1] = array("value" => round($credit), 'color' => "#ffb53e", "highlight" => "#fac878", "label" => "CREDIT"); 
        $bestest[2] = array("value" => round($cheque), 'color' => "#1ebfae", "highlight" => "#3cdfce", "label" => "CHEQUE");  
        $bestest[3] = array("value" => round($transport), 'color' => "#FF0000", "highlight" => "#3cdfce", "label" => "TRANSPORT");  
        
        return $bestest;
    }

    private function getSalesCount($from, $to){

        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }
        return $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, $condition)))->count();
    }

    private function getTotalVolume($from, $to){
        $volume = 0;
        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from,  'Sales.created <=' => $to, $condition)))->contain(['ProductsSales']);
        foreach($sales as $sale){
            foreach($sale->products_sales as $ps){
                $volume = $volume + $ps->quantity;
            }
        }

        return $volume;
    }

    private function getTotalSales($from, $to){
        $total_sales_htg = 0; $total_sales_usd = 0;
        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, $condition)));

        foreach($sales as $sale){
            if($sale->status == 0 || $sale->status == 6){
                $total_sales_usd = $total_sales_usd + $sale->total;
            }else{
                $total_sales_htg = $total_sales_htg + $sale->total;
            }
        }

        return array($total_sales_htg , $total_sales_usd);
    }

    private function getSalesCashHTG($from, $to){
        $total_sales_htg = 0;
        $condition = "(Sales.status = 1)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 9)";
        }
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, $condition)));

        foreach($sales as $sale){

                $total_sales_htg = $total_sales_htg + $sale->total;
        }

        return $total_sales_htg;
    }

    private function getSalesCreditHTG($from, $to){
        $total_sales_htg = 0;
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, "(Sales.status = 7)")));

        foreach($sales as $sale){

                $total_sales_htg = $total_sales_htg + $sale->total;
        }

        return $total_sales_htg;
    }

    private function getSalesChequeHTG($from, $to){
        $total_sales_htg = 0;
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, "(Sales.status = 4)")));

        foreach($sales as $sale){

                $total_sales_htg = $total_sales_htg + $sale->total;
        }

        return $total_sales_htg;
    }

    private function getSalesChequeUSD($from, $to){
        $total_sales_htg = 0;
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, "(Sales.status = 6)")));

        foreach($sales as $sale){

                $total_sales_htg = $total_sales_htg + $sale->total;
        }

        return $total_sales_htg;
    }

    private function getSalesCreditUSD($from, $to){
        $total_sales_htg = 0;
        $sales = $this->Sales->find('all', array('conditions' => array("Sales.created >=" => $from, 'Sales.created <=' => $to, "(Sales.status = 0)")));

        foreach($sales as $sale){
                $total_sales_htg = $total_sales_htg + $sale->total;
        }

        return $total_sales_htg;
    }

    public function daily(){

        $from = date("Y-m-d 00:00:00");
        $to = date("Y-m-d 23:59:59");

        // $from = "2020-09-10 00:00:00";
        // $to = '2020-09-10 23:59:59';
        
        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
        $fpdf = new FPDF();
        $fpdf->AddPage();
        $fpdf->Image(ROOT.'/webroot/img/logo.png',10,4,50);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(190,0,date('l j F Y'),0,0, 'R');
        $fpdf->Ln(10);
        $fpdf->SetFont('Arial','B',8);

        // Tableau Dashboard #2 [ 22 - 42 ] 

        $salesDetails = array("cashHTG" => $this->getSalesCashHTG($from, $to), 'cashUSD' => 0, 'creditHTG' => $this->getSalesCreditHTG($from, $to), 'creditUSD' => $this->getSalesCreditUSD($from, $to), 'chequeUSD' => $this->getSalesChequeUSD($from, $to), 'chequeHTG' => $this->getSalesChequeHTG($from, $to));

        $fpdf->Cell(22,5,"RESUME",'T,L',0, 'L');
        $fpdf->Cell(42,5,"CASH",'L,B,R,T',0, 'C');
        $fpdf->Cell(42,5,"CREDIT",'B,R,T',0, 'C');
        $fpdf->Cell(42,5,"CHEQUE",'B,R,T',0, 'C');
        $fpdf->Cell(42,5,"TOTAL",'B,R,T',0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(22,5,"HTG",'L,B,R,T',0, 'C');
        $fpdf->SetFont('Arial','',8);
        $fpdf->Cell(42,5,number_format($salesDetails['cashHTG'], "2", ".", ",")." HTG","B,R",0, 'C');
        $fpdf->Cell(42,5,number_format($salesDetails['creditHTG'], "2", ".", ",")." HTG","B,R",0, 'C');
        $fpdf->Cell(42,5,number_format($salesDetails['chequeHTG'], 2, ".", ",")." HTG","B,R",0, 'C');
        $fpdf->Cell(42,5,number_format(($salesDetails['creditHTG'] + $salesDetails['cashHTG'] + $salesDetails['chequeHTG']), "2", ".", ",")." HTG","B,R",0, 'C');
        $fpdf->Ln();
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(22,5,"USD","L,B,R",0, 'C');
        $fpdf->SetFont('Arial','',8);
        $fpdf->Cell(42,5,number_format($salesDetails['cashUSD'], "2", ".", ",")." USD","B,R",0, 'C');
        $fpdf->Cell(42,5,number_format($salesDetails['creditUSD'], "2", ".", ",")." USD","B,R",0, 'C');
        $fpdf->Cell(42,5,number_format($salesDetails['chequeUSD'], "2", ".", ",")." USD","B,R",0, 'C');
        $fpdf->Cell(42,5,number_format(($salesDetails['cashUSD'] + $salesDetails['creditUSD'] + $salesDetails['chequeUSD']), "2", ".", ",")." USD","B,R",0, 'C');

        // Rapport de ventes par produits
        $conn = ConnectionManager::get('default');
        $products = $conn->query("SELECT p.id, p.`name`, p.`cash_price`, c.name as cname, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
            WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND (o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7 OR o.status = 1)
            GROUP BY op.product_id 
            ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
            WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND (o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7 OR o.status = 1)
            GROUP BY op.product_id 
            ORDER BY op.product_id) AS total_trips 
            FROM `products` p 
            LEFT JOIN categories c ON c.id = p.category_id
            ORDER BY total_sold DESC"); 
        $fpdf->SetFont('Arial','B',8);  
        $fpdf->Ln(9);
        $fpdf->Cell(70,5,"VENTES PAR PRODUITS","L,B,R,T",0, 'L');
        $fpdf->Cell(20,5,"VOYAGES",'B,R,T',0, 'C');
        $fpdf->Cell(70,5,"VOLUME (M3)",'B,R,T',0, 'C');
        $fpdf->Cell(30,5,"AVG / VOY",'B,R,T',0, 'C');
        $total=0;$fiches = 0;
        $fpdf->SetFont('Arial','',8);
        $total = 0; $fiches = 0;
        foreach ($products as $product){
            $total = $total + $product['total_sold'];
            $fiches = $fiches + $product['total_trips'];
        }
        $cummule = 0;
        foreach($products as $product){
            if($total != 0){
                $pourcentage = $product['total_sold']*100/$total; $cummule = $cummule + $pourcentage;
            }else{
                $pourcentage = 0; $cumule = 0;
            }
            if($product['total_sold'] != 0){
                $average = $product['total_sold']/$product['total_trips'];
                $fpdf->Ln();
                $fpdf->Cell(70,5,$product['name'],"L,B,R",0, 'L');
                $fpdf->Cell(20,5,number_format($product['total_trips'], 0, ".", ","),'B,R',0, 'C');
                $fpdf->Cell(70,5,number_format($product['total_sold'], 2, ".", ",")." M3 (".number_format($pourcentage, 2, ".", ",")."%)",'B,R',0, 'C');
                $fpdf->Cell(30,5,number_format($average, 3, ".", ",")." M3",'B,R',0, 'C');
            }
        }
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Ln();
        $total_average = $total / $fiches;
        $fpdf->Cell(70,5,"TOTAL","L,B,R",0, 'L');
        $fpdf->Cell(20,5,number_format($fiches, 0, ".", ","),'B,R',0, 'C');
        $fpdf->Cell(70,5,number_format($total, 2, ".", ",")." M3",'B,R',0, 'C');
        $fpdf->Cell(30,5,number_format($total_average, 3,".", ",")." M3",'B,R',0, 'C');


        // Meilleurs clients crédits
        $best_clients = $this->getBestClients($from,$to);
        $fpdf->Ln(9);
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(100,5,"MEILLEURS CLIENTS CREDITS","L,B,R,T",0, 'L');
        $fpdf->Cell(45,5,"VOYAGES",'B,R,T',0, 'C');
        $fpdf->Cell(45,5,"VOLUME (M3)",'B,R,T',0, 'C');
        $fpdf->SetFont('Arial','',8);
        foreach($best_clients as $client){
            $total = $total + $product['total_sold'];
            $fiches = $fiches + $product['total_trips'];
            $fpdf->Ln();
            $fpdf->Cell(100,5,strtoupper(strtolower($client['first_name']))." ".strtoupper($client['last_name']),"L,B,R",0, 'L');
            $fpdf->Cell(45,5,number_format($client['total_trips'], 0, ".", ","),'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($client['total_sold'], 2, ".", ",")." M3",'B,R',0, 'C');
        }

        $truck_ratios = $this->getTrucksRatio($from, $to);
        $fpdf->Ln(9);
        $fpdf->SetFont('Arial','B',8);
        $tot_voyages = $truck_ratios[0]['value'] + $truck_ratios[1]['value'] + $truck_ratios[2]['value'];
        $fpdf->Cell(55,5,"VOLUMES PAR TYPE DE CAMION","L,T,R",0, 'L');
        $fpdf->Cell(60,5,"VOYAGES",'T,R',0, 'C');
        $fpdf->Cell(75,5,"VOLUME (M3)",'T,R',0, 'C');
        $fpdf->SetFont('Arial','',9);
        $fpdf->Ln();
        $fpdf->Cell(55,5,"10 ROUES","L,R,T",0, 'L');
        $fpdf->Cell(60,5,$truck_ratios[0]['value'] ." (".number_format(($truck_ratios[0]['value']*100/$tot_voyages), 2, ".", ",")."%)" ,'R,T',0, 'C');
        $fpdf->Cell(75,5,$truck_ratios[0]['volume']." M3",'R,T',0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(55,5,"6 ROUES","L,B,R,T",0, 'L');
        $fpdf->Cell(60,5,$truck_ratios[1]['value'] ." (".number_format(($truck_ratios[1]['value']*100/$tot_voyages), 2, ".", ",")."%)",'B,R,T',0, 'C');
        $fpdf->Cell(75,5,$truck_ratios[1]['volume']." M3",'B,R,T',0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(55,5,"CANTERS","L,B,R",0, 'L');
        $fpdf->Cell(60,5,$truck_ratios[2]['value'] ." (".number_format(($truck_ratios[2]['value']*100/$tot_voyages), 2, ".", ",")."%)" ,'B,R',0, 'C');
        $fpdf->Cell(75,5,$truck_ratios[2]['volume']." M3",'B,R',0, 'C');

        $users = $this->Sales->Users->find('all', [ "conditions" => array('id=9 OR id=15 OR id=11'), "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($u) {
                return $u->get('name');
            }
        ]);  
        $i=0;
        foreach($users as $user){
            $closing[$i] = $this->getClosingValues($user->id, $from, $to);
            $closing[$i]['user'] = strtoupper($user->last_name)." ".strtoupper($user->first_name);
            $i++;
        }

        $fpdf->Ln(9);
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(55,7,"RAPPORT DE FERMETURE","T,L,B,R",0, 'L');
        $fpdf->Cell(45,7,"#",'T,B,R',0, 'C');
        $fpdf->Cell(45,7,"HTG",'T,B,R',0, 'C');
        $fpdf->Cell(45,7,"USD",'T,B,R',0, 'C');
        $total_voyages = 0; $total_htg=0; $total_usd = 0; 
        $total_cash_htg=0;$total_ch_htg=0;$total_cr_htg=0;
        $total_cash_usd=0;$total_ch_usd=0;$total_cr_usd=0;
        $total_voy_cash=0;$total_voy_ch=0;$total_voy_cr=0;
        foreach($closing as $report){
            $fpdf->Ln();
            $fpdf->SetFont('Arial','B',8);
            $fpdf->Cell(190,7,utf8_decode($report['user']),"L,R,B",0, 'L');
            $fpdf->Ln();
            $fpdf->SetFont('Arial','',8);
            $fpdf->Cell(55,5,"CASH","L,B,R",0, 'L');
            $fpdf->Cell(45,5,$report['total_cash'],'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($report['cash_htg'], 2, ".", ",")." HTG",'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($report['cash_usd'], 2, ".", ",")." USD",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(55,5,"CHEQUE","L,B,R",0, 'L');
            $fpdf->Cell(45,5,$report['total_ch'],'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($report['cheque_htg'], 2, ".", ",")." HTG",'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($report['cheque_usd'], 2, ".", ",")." USD",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(55,5,"CREDIT","L,B,R",0, 'L');
            $fpdf->Cell(45,5,$report['total_cr'],'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($report['credit_htg'], 2, ".", ",")." HTG",'B,R',0, 'C');
            $fpdf->Cell(45,5,number_format($report['credit_usd'], 2, ".", ",")." USD",'B,R',0, 'C');
            $total_voyages = $total_voyages + $report['total_cash']+$report['total_ch']+$report['total_cr'];
            $total_htg = $total_htg + $report['cash_htg']+$report['cheque_htg']+$report['credit_htg'];
            $total_usd = $total_usd + $report['cash_usd']+$report['cheque_usd']+$report['credit_usd'];
            $total_voy_cash = $total_voy_cash + $report['total_cash'];
            $total_voy_ch = $total_voy_ch + $report['total_ch'];
            $total_voy_cr = $total_voy_cr + $report['total_cr'];
            $total_cash_usd = $total_cash_usd + $report['cash_usd'];
            $total_ch_usd = $total_ch_usd + $report['cheque_usd'];
            $total_cr_usd = $total_cr_usd + $report['credit_usd'];
            $total_cash_htg = $total_cash_htg + $report['cash_htg'];
            $total_ch_htg = $total_ch_htg + $report['cheque_htg'];
            $total_cr_htg = $total_cr_htg + $report['credit_htg'];
        }
        $fpdf->Ln();
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(190,6,"TOTAL","L,R,B",0, 'L');
        $fpdf->Ln();
        $fpdf->SetFont('Arial','',8);
        $fpdf->Cell(55,5,"CASH","L,B,R",0, 'L');
        $fpdf->Cell(45,5,$total_voy_cash,'B,R',0, 'C');
        $fpdf->Cell(45,5,number_format($total_cash_htg, 2, ".", ",")." HTG",'B,R',0, 'C');
        $fpdf->Cell(45,5,number_format($total_cash_usd, 2, ".", ",")." USD",'B,R',0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(55,5,"CHEQUE","L,B,R",0, 'L');
        $fpdf->Cell(45,5,$total_voy_ch,'B,R',0, 'C');
        $fpdf->Cell(45,5,number_format($total_ch_htg, 2, ".", ",")." HTG",'B,R',0, 'C');
        $fpdf->Cell(45,5,number_format($total_ch_usd, 2, ".", ",")." USD",'B,R',0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(55,5,"CREDIT","L,B,R",0, 'L');
        $fpdf->Cell(45,5,$total_voy_cr,'B,R',0, 'C');
        $fpdf->Cell(45,5,number_format($total_cr_htg, 2, ".", ",")." HTG",'B,R',0, 'C');
        $fpdf->Cell(45,5,number_format($total_cr_usd, 2, ".", ",")." USD",'B,R',0, 'C');
        $fpdf->Ln();
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(55,6,"TOTAL","L,B,R",0, 'L');
        $fpdf->Cell(45,6,$total_voyages,'B,R',0, 'C');
        $fpdf->Cell(45,6,number_format($total_htg,2,".",",")." HTG",'B,R',0, 'C');
        $fpdf->Cell(45,6,number_format($total_usd,2,".",",")." USD",'B,R',0, 'C');

        $directoryName = ROOT."/webroot/tmp/rapport_journalier_".date('Ymd').'.pdf'; 
        $fpdf->Output($directoryName, 'F');
        // $fpdf->Output('I');
        $this->send($directoryName);
        die("DONE WITH DAILY");
    }



    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Rates');
        $rate = $this->Rates->get(2);
        

        $sale = $this->Sales->get($id, [
            'contain' => ['Users', "RequisitionsSales" => ['Requisitions'], 'Customers' => ['Rates'], 'Trucks', 'Pointofsales', 'ProductsSales' => ["Products"], 'PaymentsSales' => ['Payments' => ['Methods', 'Rates']]]
        ]);

        $this->set('sale', $sale); $this->set('rate', $rate);
    }

    public function closing(){
        $users = $this->Sales->Users->find('all', [ "conditions" => array('id=9 OR id=15 OR id=11'), "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($u) {
                return $u->get('name');
            }
        ]);  
        
        $date = date('Y-m-d');
        $condition = ""; 
        $from = date("Y-m-d")." 00:00:00";
        $to = date("Y-m-d")." 23:59:59";
        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['date'])){
                $from = $this->request->getData()['date'] . " 00:00:00";
                $to = $this->request->getData()['date'] . " 23:59:59";
                $date = $this->request->getData()['date'];
            }
        }
        $i=0;
        foreach($users as $user){
            $closing[$i] = $this->getClosingValues($user->id, $from, $to);
            $closing[$i]['user'] = strtoupper($user->last_name)." ".strtoupper($user->first_name);
            $i++;
        }

        $this->set('closing', $closing);$this->set('date', $date);
    }

    private function getClosingValues($user,$from,$to){
        $cash_htg = 0;
        $cash_usd=0;
        $cheque_htg = 0;
        $credit_htg = 0;
        $credit_usd = 0;
        $cheque_usd = 0;
        $total_cash = 0;
        $total_ch = 0;
        $total_cr = 0;

        $query = $this->Sales->find('all', array('conditions' => array("Sales.status" => 1, 'Sales.user_id' => $user, 'Sales.created >=' => $from, 'Sales.created <=' => $to)));
        $total_cash = $total_cash + $query->count();
        foreach($query as $q){
            $cash_htg = $cash_htg + $q->total;
        }

        $query = $this->Sales->find('all', array('conditions' => array("Sales.status" => 10, 'Sales.user_id' => $user, 'Sales.created >=' => $from, 'Sales.created <=' => $to)));
        $total_cash = $total_cash + $query->count();
        foreach($query as $q){
            $cash_usd = $cash_usd + $q['sum'];
        }

        $query = $this->Sales->find('all', array('conditions' => array("Sales.status" => 4, 'Sales.user_id' => $user, 'Sales.created >=' => $from, 'Sales.created <=' => $to)));
        $total_ch = $total_ch + $query->count();
        foreach($query as $q){
            $cheque_htg = $cheque_htg + $q->total;
        }

        $query = $this->Sales->find('all', array('conditions' => array("Sales.status" => 6, 'Sales.user_id' => $user, 'Sales.created >=' => $from, 'Sales.created <=' => $to)));
        $total_ch = $total_ch + $query->count();
        foreach($query as $q){
            $cheque_usd = $cheque_usd + $q->total;
        }

        $query = $this->Sales->find('all', array('conditions' => array("Sales.status" => 7, 'Sales.user_id' => $user, 'Sales.created >=' => $from, 'Sales.created <=' => $to)));
        $total_cr = $total_cr + $query->count();
        foreach($query as $q){
            $credit_htg = $credit_htg + $q->total;
        }

        $query = $this->Sales->find('all', array('conditions' => array("Sales.status" => 0, 'Sales.user_id' => $user, 'Sales.created >=' => $from, 'Sales.created <=' => $to)));
        $total_cr = $total_cr + $query->count();
        foreach($query as $q){
            $credit_usd = $credit_usd +$q->total;
        }

        return array('credit_usd' => $credit_usd, "cheque_usd" => $cheque_usd, "cheque_htg" => $cheque_htg, "cash_usd" => $cash_usd, "cash_htg" => $cash_htg, 'credit_htg' => $credit_htg, 'total_cash' => $total_cash, 'total_ch' => $total_ch, 'total_cr' => $total_cr);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Rates');
        $sale = $this->Sales->newEntity();
        if ($this->request->is('post')) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            $customer = $this->Sales->Customers->get($sale->customer_id);
            $sale->status = $this->customer_statuses[$customer->rate_id][$customer->type];
            $trucks = $this->Sales->Trucks->find("all", array('conditions' => array('immatriculation' => $this->request->getData()['truck_id'])));
            foreach($trucks as $tr){
                $truck = $tr;
            }
            $product = $this->Sales->Products->get($this->request->getData()['product_id']);
            if($customer->rate_id == 2){
                $sale_total = $truck->volume*$product->credit_price;
            }else{
                $sale_total = $truck->volume*$product->cash_price;
            }

            $sale->subtotal = $sale_total;
            $sale->taxe = 0;
            if($sale->discount_type == 0){
                $discount = $sale_total*$this->request->getData()['discount']/100;
            }else{
                $discount = $this->request->getData()['discount'];
            }
            $sale->pointofsale_id = 1;
            $sale->total = $sale->subtotal + $sale->taxe - $discount;
            if($sale->charged == 1){
                $sale->charged_time = date("Y-m-d H:i:s");
                $sale->charged_user_id = $this->Auth->User()['id'];
            }

            if($sale->sortie == 1){
                $sale->sortie_time = date("Y-m-d H:i:s");
                $sale->sortie_user_id = $this->Auth->User()['id'];
            }
            $sale->truck_id = $truck->id;
            $sale->sale_number = $this->salenumber();
            $sale->user_id = $this->Auth->User()['id'];
            $sale->monnaie = 0;
            if ($new = $this->Sales->save($sale)) {
                $new = $this->Sales->get($new['id']);

                $ps = $this->Sales->ProductsSales->newEntity();
                $ps->product_id = $this->request->getData()['product_id'];
                $ps->sale_id = $new->id;
                if($customer->rate_id == 2){
                    $ps->price = $product->credit_price;
                    $ps->totalPrice = $product->credit_price*$truck->volume;
                }else{
                    $ps->price = $product->cash_price;
                    $ps->totalPrice = $product->cash_price*$truck->volume;
                }
                $ps->quantity = $truck->volume;
                $this->Sales->ProductsSales->save($ps);


                if(!empty($this->request->getData()['requisition_id'])){
                    $rs = $this->Sales->RequisitionsSales->newEntity();
                    $rp = $this->Sales->RequisitionsSales->Requisitions->RequisitionsProducts->find("all", array('conditions' => array('requisition_id' => $this->request->getData()['requisition_id'], "product_id" => $this->request->getData()['product_id'])));
                    foreach($rp as $rpp){
                        $rpp->used = $rpp->used + 1;
                        $this->Sales->RequisitionsSales->Requisitions->RequisitionsProducts->save($rpp); 
                    }
                    
                    $rs ->sale_id = $new->id;
                    $rs->requisition_id = $this->request->getData()['requisition_id'];
                    $this->Sales->RequisitionsSales->save($rs);
                }

                return $this->redirect(['action' => 'view', $new['id']]);
            }
        }
        $users = $this->Sales->Users->find('list');
        $customers = $this->Sales->Customers->find('list', [ "order" => ['last_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);
        $this->loadModel('Rates');
        $rate = $this->Rates->get(2);
        $rates = $this->Rates->find('list');
        $trucks = $this->Sales->Trucks->find('list');
        $methods = $this->Sales->Payments->Methods->find('list', array('conditions' => array('id <>' => 3)));
        $products = $this->Sales->Products->find('all', ['order' => array('name ASC')]);
        $this->set(compact('sale', 'users', 'customers', 'trucks', 'products', 'rate', "methods", 'rates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Products']
        ]);
        $customer_id = $sale->customer_id;
        $status = $sale->status;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());

            if($this->request->getData()['charged'] == 1 && empty($sale->charged_time)){
                $sale->charged_time = date("Y-m-d H:i:s");
                $sale->charged_user_id = $this->Auth->user()['id'];
            }

            if($this->request->getData()['sortie'] == 1 && empty($sale->sortie_time)){
                $sale->sortie_time = date("Y-m-d H:i:s");
                $sale->sortie_user_id = $this->Auth->user()['id'];
            }
            if ($new = $this->Sales->save($sale)) {
                // debug($customer_id); debug($new['customer_id']); debug($new['status']); debug($status); die();
                if($new['status'] == 0 ||  $new['status'] == 4){
                    // its a credit and we can continue
                    $this->loadModel('Accounts');
                    $accounts = $this->Accounts->find("all", array('conditions' => array('customer_id' => $new['customer_id'])));
                    $transactions = $this->Sales->Transactions->find('all', array("conditions" => array("sale_id" => $new['id'])));
                    // debug($status); debug($new['status']); die();
                    if($status != $new['status']){
                        // recalculate total depending on new status
                        $sale = $this->Sales->get($new['id'], ['contain' => ["ProductsSales" => ['Products'], 'Customers', 'Trucks']]);
                        $sale->subtotal = $this->calculateSubtotal($sale);
                        $sale->total = $this->calculateTotal($sale);
                    }

                    $this->Sales->save($sale);
                }
                return $this->redirect(['action' => 'index']);
            }
        }
        $customers = $this->Sales->Customers->find('list');
        $trucks = $this->Sales->Trucks->find('list');
        $products = $this->Sales->Products->find('list');
        $this->set(compact('sale', 'customers', 'trucks', 'products'));
    }

    private function calculateSubtotal($sale){
        $subtotal = 0;

        foreach($sale->products_sales as $ps){
            if($sale->status == 0){
                $subtotal = $subtotal + $sale->truck->volume * $ps->product->credit_price;
            }else{
                $subtotal = $subtotal + $sale->truck->volume * $ps->product->cash_price;  
            }
        }

        return $subtotal;
    }


    public function recalculateTotals(){
        $sales = $this->Sales->find("all")->contain(['ProductsSales' => ['Products'], 'Customers', 'Trucks']);
        foreach($sales as $sale){
            $sale->subtotal = $this->calculateSubtotal($sale); 
            $sale->total = $this->calculateTotal($sale);
            $this->Sales->save($sale);
        }
        die();
    }

    private function calculateTotal($sale){
        $discount = $sale->discount;
        $discount_type = $sale->discount_type; 

        $subtotal = 0; $total = 0;

        foreach($sale->products_sales as $ps){
            if($sale->status == 0){
                $subtotal = $subtotal + $sale->truck->volume * $ps->product->credit_price;
            }else{
                $subtotal = $subtotal + $sale->truck->volume * $ps->product->cash_price;  
            }
        }

        if($discount_type == 1){
            $total = $subtotal - $subtotal*$discount/100;
        }else{
            $total = $subtotal - $discount;
        }

        return $total;

    }

    /**
     * Delete method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $sale = $this->Sales->get($id);
        if ($this->Sales->delete($sale)) {
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function products(){
        $conn = ConnectionManager::get('default');

        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $customer = "99999";

        $condition = "(o.status = 1 OR o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        }

        if($this->request->is(['patch', 'put', 'post']) && !empty($this->request->getData()['customer_id'])){
            $customer = $this->request->getData()['customer_id'];
            $product_list = $conn->query("SELECT p.id, p.`name`, p.`cash_price`, c.name as cname, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_trips 
                FROM `products` p 
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY total_sold DESC");  
        }else{
           $product_list = $conn->query("SELECT p.id, p.`name`, p.`cash_price`, c.name as cname, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_trips 
                FROM `products` p 
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY total_sold DESC");    
        }

        

        $customers = $this->Sales->Customers->find('list', [ "order" => ['last_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);      
    
        $this->set(compact('product_list', 'customers', 'customer'));
    }


    public function salenumber(){
        $alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $date = date("Y-m-d H:i:s");
        $time = strtotime($date);
        $index = array_rand($alphabet);
        $index2 = array_rand($alphabet);
        $int = substr($time , 4 , 10);

        return $alphabet[$index].$alphabet[$index2].$int;
    }


    public function cancel($id = false){
        if($id == false){
            return $this->redirect(['action' => 'index']);
        }

        $sale = $this->Sales->get($id);

        if($sale->status == 0 || $sale->status == 1 || $sale->status = 4 || $sale->status = 7 ){
            if($sale->status == 0){
                $sale->status = 3; 
            }
            if($sale->status == 1){
                $sale->status = 2; 
            }
            if($sale->status == 4){
                $sale->status = 5; 
            }
            if($sale->status == 6){
                $sale->status = 9; 
            }
            if($sale->status == 7){
                $sale->status = 8; 
            }
            $this->Sales->save($sale);
        }
        return $this->redirect(['action' => 'view', $id]); 
        
    }

    public function setDates(){
        if ($this->request->is(['put', 'patch', 'post'])){
            if(!empty($this->request->getData()["from"])){
                $this->request->session()->write("from", $this->request->getData()["from"]);
            }

            if(!empty($this->request->getData()["to"])){
                $this->request->session()->write("to", $this->request->getData()["to"]);
            }
        }

        return $this->redirect($this->referer());
    }

    private function getTotalCashSalesPerProduct($sales, $id){
        $total = 0;
        foreach($sales as $sale){
            if($sale->products_sales[0]->product_id == $id){
                $total = $total + $sale->total;
            }
        }
        return $total;
    }

    private function getTotalHiddenSalesPerProduct($sales, $id){
        $total = 0;
        foreach($sales as $sale){
            if($sale->products_sales[0]->product_id == $id){
                if($sale->hidden == 1){
                   $total = $total + $sale->total; 
                }
            }
        }
        return $total;
    }

    public function testSale(){
        $sales = $this->Sales->find("all", array("conditions" => array("created >=" => "2020-01-03 00:00:00", 'created <=' => "2020-01-31 23:59:59")))->contain(['ProductsSales'])->matching('ProductsSales', function ($q) use ($product_id) {
                return $q->where(['ProductsSales.product_id' => 17]);
            });
        $sale = $sale->first();
        if(!empty($sale)){
            $sale->hidden = 0;
            $total = $total + $sale->total;
            debug($total);
            // $this->Sales->save($sale);
        }

        die();
    }

    private function getProductPercentage($from, $to, $product_id){
        $total = 0;
        $sales = $this->Sales->find("all", array("conditions" => array("created >=" => $from, 'created <=' => $to, 'status' => 1)))->contain(['ProductsSales'])->matching('ProductsSales', function ($q) use ($product_id) {
                return $q->where(['ProductsSales.product_id' => $product_id]);
            });

        foreach($sales as $sale){
            $total = $total + $sale->total;
        }
        return $total;
    }

    private function getProductsHiddenTotal($from, $to, $product_id){
        $total = 0;
        $sales = $this->Sales->find("all", array("conditions" => array("created >=" => $from, 'created <=' => $to, 'status' => 1, "hidden" => 0, 'customer_id' => 1)))->contain(['ProductsSales'])->matching('ProductsSales', function ($q) use ($product_id) {
                return $q->where(['ProductsSales.product_id' => $product_id]);
            });

        foreach($sales as $sale){
            $total = $total + $sale->total;
        }
        return $total;
    }


    private function getTotalCashSales($from, $to){

        $sales = $this->Sales->find("all", array("conditions" => array("created >=" => $from, 'created <=' => $to, 'status' => 1)))->contain(['ProductsSales']);
        $total = 0;
        foreach($sales as $sale){
            $total = $total + $sale->total;
        }
        return $total;
    }

    private function getTotalHiddenSales($from, $to){
        $total = 0;
        $sales = $this->Sales->find("all", array("conditions" => array("created >=" => $from, 'created <=' => $to,'hidden' => 0)))->contain(['ProductsSales']);
        foreach($sales as $sale){
            if($sale->hidden == 0){
               $total = $total + $sale->total; 
            }
        }
        return $total;
    }


    public function balance(){
        $this->loadModel("Products");
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";

        $from_p = $this->request->session()->read("from");
        $to_p = $this->request->session()->read("to");
        if($this->request->is(['put', 'patch', 'post'])){
            if(!empty($this->request->getData()['value'])){
               $total_to_show = $this->request->getData()['value'];  
            }
        }else{
            $total_to_show = 0;
        }

        $total_sales = $this->getTotalCashSales($from, $to);
        // $hidden = $this->getTotalHiddenSales($from, $to);
        // $total_to_show = $total_to_show - $hidden;

        // put conditions to show how much is already hidden;
        $products = $this->Products->find("all")->contain(['Categories']);

        //balancer les fiches credit
 

        foreach($products as $product){
            if($total_sales == 0){
                $product->percentage = 0;
            }else{
                $product->percentage = $this->getProductPercentage($from, $to, $product->id)*100/$total_sales;
            }

        }

        if($this->request->is(['put', 'patch', 'post'])){
            $hidden = 0;
            if(!empty($this->request->getData()['product_hide'])){
                $target = $this->request->getData()['product_hide'];
                $product_id = $this->request->getData()['product_id'];
                while($hidden < $target){
                    $sale = $this->Sales->find("all", array("conditions" => array("created >=" => $from_p." 00:00:00","created <=" => $from_p." 23:59:59", "hidden" => 1, 'status' => 1)))->contain(['ProductsSales'])->matching('ProductsSales', function ($q) use ($product_id) {
                        return $q->where(['ProductsSales.product_id' => $product_id]);
                        })->order("rand()")->first();

			if(!empty($sale)){
			    $date = date_create($from_p);
			    date_add($date, date_interval_create_from_date_string("1 days"));
			    $from_p = date_format($date, "Y-m-d");
			}

                    while(empty($sale)){
                        $date = date_create($from_p);
                        date_add($date,date_interval_create_from_date_string("1 days"));
                        $from_p = date_format($date,"Y-m-d"); 

                       $sale = $this->Sales->find("all", array("conditions" => array("created >=" => $from_p." 00:00:00","created <=" => $from_p." 23:59:59", "hidden" => 1, 'status' => 1)))->contain(['ProductsSales'])->matching('ProductsSales', function ($q) use ($product_id) {
                        return $q->where(['ProductsSales.product_id' => $product_id]);
                        })->order("rand()")->first();
                    }
			   if(!empty($sale->id)){ 
			    $sale = $this->Sales->get($sale->id);
			    $sale->hidden = 0;
			    $hidden = $hidden + $sale->total;
			if(!empty($sale)){
    			$this->Sales->save($sale);
			}else{
			debug($sale);
			}
			   }
                    // if(!empty($sale->hidden)){
                    // $sale->hidden = 0;
                    // debug($sale); 
                    // die();
		    // $this->Sales->save($sale);
		    
                    // $hidden = $hidden + $sale->total;
		    // }
		    if($from_p >= date("Y-m-t", strtotime($from_p))){
                        $from_p = $this->request->session()->read("from");
                    }
                }
            }
            
        }

        foreach($products as $product){
            $product->balanced = $this->getProductsHiddenTotal($from, $to, $product->id);
	}
        $this->set(compact('products', 'total_to_show', 'hidden'));
    }
}
