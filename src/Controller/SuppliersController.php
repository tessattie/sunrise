<?php
namespace App\Controller;

use App\Controller\AppController;
use FPDF;
use PDF_BARCODE;
/**
 * Suppliers Controller
 *
 * @property \App\Model\Table\SuppliersTable $Suppliers
 *
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuppliersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $suppliers = $this->Suppliers->find("all", array("order" => array("Suppliers.name ASC")))->contain(['Items']);

        $this->set(compact('products', 'suppliers'));
    }

    /**
     * View method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supplier = $this->Suppliers->get($id, [
            'contain' => ['Users', 'Trucks', 'Receivings']
        ]);

        $this->set('supplier', $supplier);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $supplier = $this->Suppliers->newEntity();
        if ($this->request->is('post')) {
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());
            $supplier->user_id = $this->Auth->user()['id'];
            if ($id = $this->Suppliers->save($supplier)) {
                $this->Flash->success(__('Sauvegarde réussie'));

                return $this->redirect(['action' => 'edit', $id['id']]);
            }
            $this->Flash->error(__('Impossible de sauvegarder. Contactez votre administrateur'));
        }
        $users = $this->Suppliers->Users->find('list', ['limit' => 200]);
        $products = $this->Suppliers->Items->find("list");
        $trucks = $this->Suppliers->Trucks->find('list', ['limit' => 200]);
        $this->set(compact('supplier', 'users', 'trucks', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";

        $supplier = $this->Suppliers->get($id, [
            'contain' => ['Trucks', 'SuppliersTrucks' => ['Trucks', 'Items'], 'SuppliersViolations' => ['Violations', 'Trucks', 'Users']]
        ]);
        $supplier->violations = $this->Suppliers->SuppliersViolations->find('all', array('conditions' => array("SuppliersViolations.created >= " => $from, "SuppliersViolations.created <=" => $to, 'supplier_id' => $supplier->id)))->contain(['Violations', "Users", 'Trucks']);
        $supplier->receivings = $this->Suppliers->Receivings->find('all', array('conditions' => array("Receivings.created >= " => $from, "Receivings.created <=" => $to, 'supplier_id' => $supplier->id)))->contain(['Items', "Users", 'Trucks']);
        $supplier->payments = $this->Suppliers->Spayments->find('all', array('conditions' => array("Spayments.created >= " => $from, "Spayments.created <=" => $to, 'supplier_id' => $supplier->id)))->contain(['Rates', "Users"]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());
            if ($this->Suppliers->save($supplier)) {
                $this->Flash->success(__('Sauvegarde réussie'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de sauvegarder. Contactez votre administrateur'));
        }
        $users = $this->Suppliers->Users->find('list', ['limit' => 200]);
        $products = $this->Suppliers->Items->find("list");
        $types = $this->Suppliers->Receivings->types;
        $violations = $this->Suppliers->SuppliersViolations->Violations->find('list', array('order' => "name ASC"));
        $this->set(compact('supplier', 'users', 'trucks', 'products', "violations", 'types'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Suppliers->get($id);
        if ($this->Suppliers->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function export(){
        if ($this->request->is(['patch', 'post', 'put'])){
            // debug($this->request->getData()); die();

            $supplier = $this->Suppliers->get($this->request->getData()['supplier_id']);
            $truck = $this->Suppliers->SuppliersTrucks->Trucks->get($this->request->getData()['truck_id']);

            $sp = $this->Suppliers->SuppliersTrucks->get($this->request->getData()['id'], ['contain' => ['Items']]);

            require_once(ROOT . DS . 'vendor' . DS  . 'fpdf-barcode-master'  . DS . 'pdf_barcode.php');

            // require(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
            $fpdf = new PDF_BARCODE('P','mm','A4');
            $fpdf->AddPage();
            $fpdf->Image(ROOT.'/webroot/img/logo.png',10,4,50);
            $fpdf->SetFont('Arial','B',11);
            $fpdf->Cell(190,0,date("m/d/Y" ,strtotime($this->request->getData()['from']))." - ".date("m/d/Y" ,strtotime($this->request->getData()['to'])),0,0, 'R');
            $fpdf->Ln(7);
            $fpdf->Cell(190,0,"",'B',0, 'R');
            $fpdf->Ln();
            $fpdf->Cell(40,25,$supplier->name,'B,R,L',0, 'C');
            $fpdf->Cell(40,25,"Camion : ".$truck->immatriculation,'B,R',0, 'C');
            $fpdf->Cell(40,25,"Produit : ".$sp->item->name,'B,R',0, 'C');
            $fpdf->Cell(70,25,$fpdf->EAN13(143,21,$sp->code,15,0.4,9),'B,R',0, 'C');

            $fpdf->SetFont('Arial','B',9);
            $fpdf->Ln();
            $fpdf->Cell(30,7,"DATE",'B,R,L',0, 'C');
            $fpdf->Cell(20,7,"HEURE",'B,R,L',0, 'C');
            $fpdf->Cell(70,7,"FICHE",'B,R',0, 'C');
            $fpdf->Cell(35,7,"ATV",'B,R',0, 'C');
            $fpdf->Cell(35,7,"STOCK",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
            $fpdf->Cell(30,13,"",'B,R,L',0, 'C');
            $fpdf->Cell(20,13,"",'B,R',0, 'C');
            $fpdf->Cell(70,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Cell(35,13,"",'B,R',0, 'C');
            $fpdf->Ln();
        }

        $fpdf->Output('I');
        die();
    }

    /**
     * Delete method
     *
     * @param string|null $id Suppliers Truck id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteviolation($id = null)
    {
        $this->loadModel('SuppliersViolations');
        $this->request->allowMethod(['post', 'delete', 'get']);
        $suppliersViolation = $this->SuppliersViolations->get($id);
        $supplier = $suppliersViolation->supplier_id;
        if ($this->SuppliersViolations->delete($suppliersViolation)) {
        } else {
        }
        return $this->redirect(['controller' => 'Suppliers', 'action' => 'edit', $supplier]);
    }

    public function newpayment(){
        if ($this->request->is('post')){
            $spayment = $this->Suppliers->Spayments->newEntity();
            $spayment = $this->Suppliers->Spayments->patchEntity($spayment, $this->request->getData());
            $spayment->user_id = $this->Auth->user()['id'];
            if ($this->Suppliers->Spayments->save($spayment)) {
                $this->Flash->success(__('Paiement sauvegardé'));
            }
            return $this->redirect(['action' => 'edit', $this->request->getData()['supplier_id']]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
