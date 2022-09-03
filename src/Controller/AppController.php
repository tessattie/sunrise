<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;
use PHPExcel;
use PHPExcel_IOFactory;
use Cake\Datasource\ConnectionManager;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    protected $customer_statuses = array( 1 => array(1 => 7, 2 => 4), 2 => array(1 => 0, 2 => 6));

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        define("ROOT_DIREC", '/sunrise');

        date_default_timezone_set("America/New_York");

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        // $this->loadComponent('Sessions');

        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Sales',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login']
        ]);
    }


    public function beforeFilter(Event $event){
        $this->loadModel('Rates');
        if($this->Auth->user()){
            if(empty($this->request->session()->read("from"))){
                $this->request->session()->write("from", date("Y-m-d"));
            }

            if(empty($this->request->session()->read("to"))){
                $this->request->session()->write("to", date("Y-m-d"));
            }
            
            $this->set('rts', $this->Rates->find('list'));
            $this->set("filterfrom", $this->request->session()->read("from"));
            $this->set("filterto", $this->request->session()->read("to"));
            $this->set('status', array(0 => "Inactif", 1 => "Actif"));
            $this->set('types_reductions', array(0 => "USD", 1 => "%"));
            $this->set('user_connected', $this->Auth->user());
        }
    }


    protected function getBalance($customer){
        $balance = 0;
        $conn = ConnectionManager::get('default');
        $this->loadModel('Customers'); 
        $cust = $this->Customers->get($customer);
        if($cust->rate_id == 1){
            $sql = "SELECT c.id, c.last_name, (SELECT SUM(s.total) FROM sales s WHERE s.customer_id = c.id AND (s.status = 1 OR s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7 OR s.status = 10) GROUP BY c.id ORDER BY c.id) as purchased, (SELECT SUM(p.amount) FROM payments p WHERE customer_id = c.id AND rate_id = 1 AND status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_htg, (SELECT SUM(p.amount*p.daily_rate) FROM payments p WHERE customer_id = c.id AND rate_id = 2 AND status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_usd FROM customers c WHERE c.id = ".$customer;
        }else{
            $sql = "SELECT c.id, c.last_name, (SELECT SUM(s.total) FROM sales s WHERE s.customer_id = c.id AND (s.status = 1 OR s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7 OR s.status = 10) GROUP BY c.id ORDER BY c.id) as purchased, (SELECT SUM(p.amount/p.daily_rate) FROM payments p WHERE customer_id = c.id AND rate_id = 1 AND status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_htg, (SELECT SUM(p.amount) FROM payments p WHERE customer_id = c.id AND rate_id = 2 AND status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_usd FROM customers c WHERE c.id = ".$customer;
        }
        
        $balances = $conn->query($sql);
        foreach($balances as $b){
            // debug($b); die();
            $balance = $b['purchased'] - $b['paid_htg'] - $b['paid_usd'] ;
        } 
        return $balance;
    }

    protected function getBalanceByDate($customer, $date){
        $balance = 0;
        $conn = ConnectionManager::get('default');

        $this->loadModel('Customers'); 
        $cust = $this->Customers->get($customer);
        if($cust->rate_id == 1){
            $sql = "SELECT c.id, c.last_name, (SELECT SUM(s.total) FROM sales s WHERE s.customer_id = c.id AND (s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7 ) AND s.status=1 AND s.created < '".$date."' GROUP BY c.id ORDER BY c.id) as purchased, (SELECT SUM(p.amount) FROM payments p WHERE p.customer_id = c.id  AND p.created < '".$date."' AND p.rate_id = 1 AND p.status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_htg, (SELECT SUM(p.amount*p.daily_rate) FROM payments p WHERE p.customer_id = c.id  AND p.created < '".$date."' AND p.rate_id = 2 AND p.status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_usd FROM customers c WHERE c.id = ".$customer;
        }else{
            $sql = "SELECT c.id, c.last_name, (SELECT SUM(s.total) FROM sales s WHERE s.customer_id = c.id AND (s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7) AND s.created < '".$date."' GROUP BY c.id ORDER BY c.id) as purchased, (SELECT SUM(p.amount/p.daily_rate) FROM payments p WHERE p.customer_id = c.id  AND p.created < '".$date."' AND p.rate_id = 1 AND p.status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_htg, (SELECT SUM(p.amount) FROM payments p WHERE p.customer_id = c.id  AND p.created < '".$date."' AND p.rate_id = 2 AND p.status = 1 AND method_id != 3 GROUP BY c.id ORDER BY c.id) as paid_usd FROM customers c WHERE c.id = ".$customer;
        }

        
        $balances = $conn->query($sql);

        foreach($balances as $b){
            $balance = $b['purchased'] - $b['paid_htg'] - $b['paid_usd'] ;
        } 
        return $balance;
    }

    protected function getPaymentsByDate($customer, $date){
        $balance = 0;
        $conn = ConnectionManager::get('default');
        $sql = "SELECT c.id, c.last_name, (SELECT SUM(s.total) FROM sales s WHERE s.customer_id = c.id AND (s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7) AND s.created < '".$date."' GROUP BY c.id ORDER BY c.id) as purchased, (SELECT SUM(p.amount) FROM payments p WHERE p.customer_id = c.id  AND p.created < '".$date."' and p.status = 1 GROUP BY c.id ORDER BY c.id) as paid FROM customers c WHERE c.id = ".$customer;
        
        $balances = $conn->query($sql);

        foreach($balances as $b){
            $balance = $b['paid'] ;
        } 
        return $balance;
    }


    protected function checkfile($file, $name, $directory){
        $allowed_extensions = array('jpg', "JPG", "jpeg", "JPEG", "png", "PNG");
        if(!$file['error']){
            $extension = explode("/", $file['type'])[1];
            if(in_array($extension, $allowed_extensions)){
                // $dossier = '/var/www/html/app/webroot/img/'.$directory.'/';
                $dossier = 'C:/wamp/www'.ROOT_DIREC.'/webroot/img/'.$directory.'/';
                if(move_uploaded_file($file['tmp_name'], $dossier . $name . "." . $extension)){
                    return $name . "." . $extension;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
