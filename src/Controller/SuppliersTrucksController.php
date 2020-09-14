<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SuppliersTrucks Controller
 *
 * @property \App\Model\Table\SuppliersTrucksTable $SuppliersTrucks
 *
 * @method \App\Model\Entity\SuppliersTruck[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuppliersTrucksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Suppliers', 'Trucks']
        ];
        $suppliersTrucks = $this->paginate($this->SuppliersTrucks);

        $this->set(compact('suppliersTrucks'));
    }

    /**
     * View method
     *
     * @param string|null $id Suppliers Truck id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $suppliersTruck = $this->SuppliersTrucks->get($id, [
            'contain' => ['Suppliers', 'Trucks']
        ]);

        $this->set('suppliersTruck', $suppliersTruck);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $suppliersTruck = $this->SuppliersTrucks->newEntity();
        if ($this->request->is('post')) {
            $suppliersTruck = $this->SuppliersTrucks->patchEntity($suppliersTruck, $this->request->getData());
            if ($this->SuppliersTrucks->save($suppliersTruck)) {
                $this->Flash->success(__('The suppliers truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The suppliers truck could not be saved. Please, try again.'));
        }
        $suppliers = $this->SuppliersTrucks->Suppliers->find('list', ['limit' => 200]);
        $trucks = $this->SuppliersTrucks->Trucks->find('list', ['limit' => 200]);
        $this->set(compact('suppliersTruck', 'suppliers', 'trucks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Suppliers Truck id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $suppliersTruck = $this->SuppliersTrucks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $suppliersTruck = $this->SuppliersTrucks->patchEntity($suppliersTruck, $this->request->getData());
            if ($this->SuppliersTrucks->save($suppliersTruck)) {
                $this->Flash->success(__('The suppliers truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The suppliers truck could not be saved. Please, try again.'));
        }
        $suppliers = $this->SuppliersTrucks->Suppliers->find('list', ['limit' => 200]);
        $trucks = $this->SuppliersTrucks->Trucks->find('list', ['limit' => 200]);
        $this->set(compact('suppliersTruck', 'suppliers', 'trucks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Suppliers Truck id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('SuppliersTrucks');
        $this->request->allowMethod(['post', 'delete', 'get']);
        $suppliersTruck = $this->SuppliersTrucks->get($id);
        $supplier = $suppliersTruck->supplier_id;
        if ($this->SuppliersTrucks->delete($suppliersTruck)) {
        } else {
        }
        return $this->redirect(['controller' => 'Suppliers', 'action' => 'edit', $supplier]);
    }
}
