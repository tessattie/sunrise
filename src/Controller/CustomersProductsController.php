<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomersProducts Controller
 *
 * @property \App\Model\Table\CustomersProductsTable $CustomersProducts
 *
 * @method \App\Model\Entity\CustomersProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel("CustomersProducts");
        $customersProducts = $this->CustomersProducts->find("all")->contain(['Customers', 'Products']);

        $this->set(compact('customersProducts'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel("CustomersProducts");
        $customersProduct = $this->CustomersProducts->newEntity();
        if ($this->request->is('post')) {
            $customersProduct = $this->CustomersProducts->patchEntity($customersProduct, $this->request->getData());
            if ($this->CustomersProducts->save($customersProduct)) {
                $this->Flash->success(__('Mise à jour effectuée.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Nous n\'avons pas pu effectuer cette mise à jour.'));
        }
        $customers = $this->CustomersProducts->Customers->find('list', [ "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);

        $products = $this->CustomersProducts->Products->find('list', [ "order" => ['name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('detail');
            }
        ]);
        $this->set(compact('customersProduct', 'customers', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customers Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel("CustomersProducts");
        $customersProduct = $this->CustomersProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customersProduct = $this->CustomersProducts->patchEntity($customersProduct, $this->request->getData());
            if ($this->CustomersProducts->save($customersProduct)) {
                $this->Flash->success(__('Mise à jour effectuée.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'effectuer cette mise à jour effectuée.'));
        }
        $customers = $this->CustomersProducts->Customers->find('list', [ "order" => ['first_name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);

        $products = $this->CustomersProducts->Products->find('list', [ "order" => ['name ASC'],
            'keyField' => 'id',
            'valueField' => function ($c) {
                return $c->get('name');
            }
        ]);
        $this->set(compact('customersProduct', 'customers', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customers Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel("CustomersProducts");
        $this->request->allowMethod(['post', 'delete', 'get']);
        $customersProduct = $this->CustomersProducts->get($id);
        if ($this->CustomersProducts->delete($customersProduct)) {
            $this->Flash->success(__('Prix Spécial Supprimé'));
        } else {
            $this->Flash->error(__('Nous n\'avons pas pu supprimer ce spécial. Contactez votre administrateur.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
