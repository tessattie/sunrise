<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Migrations Controller
 */
class MigrationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        ini_set('MAX_EXECUTION_TIME', '-1');
        ini_set('memory_limit', '-1');
        $this->create();
        $this->alter();
        $this->view();
        $this->status();
        $this->migrate();
        $this->update();
        $this->remove();
        die("DONE WITH MIGRATION");
    }

    private function create(){
        $conn = ConnectionManager::get('default');
        $SQL = "CREATE TABLE payments_sales(
                   id INT(11) NOT NULL AUTO_INCREMENT,
                   sale_id INT(11) NOT NULL,
                   payment_id INT(11) NOT NULL,
                   amount DECIMAL(30,6) NOT NULL,
                   PRIMARY KEY(id)
                );";
        $conn->query($SQL);

    }

    private function alter(){
        $conn = ConnectionManager::get('default');
        $SQL = "ALTER TABLE payments
                  ADD customer_id INT(11);";

        // $SQL = "ALTER TABLE trucks
        //           ADD barcode INT(11);";

        // $SQL = "ALTER TABLE trucks
        //           ADD type INT(11);";

        $SQL2 = "ALTER TABLE payments
                  ADD memo VARCHAR(255);";

        $conn->query($SQL);
        $conn->query($SQL2);
    }

    public function view(){
        $SQL = "CREATE VIEW customer_balances AS (
            SELECT c.id, c.last_name, (SELECT SUM(s.total) FROM sales s WHERE customer_id = c.id GROUP BY c.id ORDER BY c.id) as purchased, (SELECT SUM(p.amount) FROM payments p WHERE customer_id = c.id GROUP BY c.id ORDER BY c.id) as paid FROM customers c GROUP BY c.id
        );"; 
        $conn = ConnectionManager::get('default');
        $conn->query($SQL);
    }


    private function status(){
        $this->loadModel("Sales"); 
        $sales = $this->Sales->find("all", array("conditions" => array("customer_id <>" => 1)))->contain(['Customers']);
        foreach($sales as $sale){
            if($sale->customer->rate_id == 1){
                if($sale->customer->type == 1){ // credit HTG
                    if($sale->status == 2 || $sale->status == 3 || $sale->status == 5){
                        $sale->status = 8;
                    }else{
                        $sale->status = 7;
                    }
                }else{ // cheque HTG
                    if($sale->status == 2 || $sale->status == 3 || $sale->status == 5){
                        $sale->status = 5;
                    }else{
                        $sale->status = 4;
                    }
                }
            }else{
                if($sale->customer->type == 1){ //credit USD
                    if($sale->status == 2 || $sale->status == 3 || $sale->status == 5){
                        $sale->status = 3;
                    }else{
                        $sale->status = 0;
                    }
                }else{ // cheque USD
                    if($sale->status == 2 || $sale->status == 3 || $sale->status == 5){
                        $sale->status = 9;
                    }else{
                        $sale->status = 6;
                    }
                }   
            }
            $this->Sales->save($sale);
        }
    }

    public function migrate(){
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

    public function update(){
        // update customer_id in the payments table with the sale customer_id 
        $this->loadModel("Payments"); 
        $payments = $this->Payments->find("all")->contain(['Sales']);
        foreach($payments as $payment){
            $payment->customer_id = $payment->sale->customer_id;
            $this->Payments->save($payment);
        }
    }

    public function finish(){
    	$this->update();
	$this->remove();
	die("FINISHED WITH CUSTOMER ID AND DELETING PAYMENTS");
    }

    public function remove(){
        $SQL = "DELETE FROM payments WHERE customer_id != 1";
        $conn = ConnectionManager::get('default');
        $conn->query($SQL); 
    }
}
