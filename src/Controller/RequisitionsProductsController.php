<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequisitionsProducts Controller
 *
 * @property \App\Model\Table\RequisitionsProductsTable $RequisitionsProducts
 *
 * @method \App\Model\Entity\RequisitionsProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequisitionsProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'Requisitions']
        ];
        $requisitionsProducts = $this->paginate($this->RequisitionsProducts);

        $this->set(compact('requisitionsProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Requisitions Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requisitionsProduct = $this->RequisitionsProducts->get($id, [
            'contain' => ['Products', 'Requisitions']
        ]);

        $this->set('requisitionsProduct', $requisitionsProduct);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requisitionsProduct = $this->RequisitionsProducts->newEntity();
        if ($this->request->is('post')) {
            $requisitionsProduct = $this->RequisitionsProducts->patchEntity($requisitionsProduct, $this->request->getData());
            if ($this->RequisitionsProducts->save($requisitionsProduct)) {
                $this->Flash->success(__('The requisitions product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisitions product could not be saved. Please, try again.'));
        }
        $products = $this->RequisitionsProducts->Products->find('list', ['limit' => 200]);
        $requisitions = $this->RequisitionsProducts->Requisitions->find('list', ['limit' => 200]);
        $this->set(compact('requisitionsProduct', 'products', 'requisitions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requisitions Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requisitionsProduct = $this->RequisitionsProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requisitionsProduct = $this->RequisitionsProducts->patchEntity($requisitionsProduct, $this->request->getData());
            if ($this->RequisitionsProducts->save($requisitionsProduct)) {
                $this->Flash->success(__('The requisitions product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisitions product could not be saved. Please, try again.'));
        }
        $products = $this->RequisitionsProducts->Products->find('list', ['limit' => 200]);
        $requisitions = $this->RequisitionsProducts->Requisitions->find('list', ['limit' => 200]);
        $this->set(compact('requisitionsProduct', 'products', 'requisitions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requisitions Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requisitionsProduct = $this->RequisitionsProducts->get($id);
        if ($this->RequisitionsProducts->delete($requisitionsProduct)) {
            $this->Flash->success(__('The requisitions product has been deleted.'));
        } else {
            $this->Flash->error(__('The requisitions product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
