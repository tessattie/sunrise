<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProductsSales Controller
 *
 * @property \App\Model\Table\ProductsSalesTable $ProductsSales
 *
 * @method \App\Model\Entity\ProductsSale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsSalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'Sales']
        ];
        $productsSales = $this->paginate($this->ProductsSales);

        $this->set(compact('productsSales'));
    }

    /**
     * View method
     *
     * @param string|null $id Products Sale id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productsSale = $this->ProductsSales->get($id, [
            'contain' => ['Products', 'Sales']
        ]);

        $this->set('productsSale', $productsSale);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productsSale = $this->ProductsSales->newEntity();
        if ($this->request->is('post')) {
            $productsSale = $this->ProductsSales->patchEntity($productsSale, $this->request->getData());
            if ($this->ProductsSales->save($productsSale)) {
                $this->Flash->success(__('The products sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The products sale could not be saved. Please, try again.'));
        }
        $products = $this->ProductsSales->Products->find('list', ['limit' => 200]);
        $sales = $this->ProductsSales->Sales->find('list', ['limit' => 200]);
        $this->set(compact('productsSale', 'products', 'sales'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Products Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productsSale = $this->ProductsSales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productsSale = $this->ProductsSales->patchEntity($productsSale, $this->request->getData());
            if ($this->ProductsSales->save($productsSale)) {
                $this->Flash->success(__('The products sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The products sale could not be saved. Please, try again.'));
        }
        $products = $this->ProductsSales->Products->find('list', ['limit' => 200]);
        $sales = $this->ProductsSales->Sales->find('list', ['limit' => 200]);
        $this->set(compact('productsSale', 'products', 'sales'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Products Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productsSale = $this->ProductsSales->get($id);
        if ($this->ProductsSales->delete($productsSale)) {
            $this->Flash->success(__('The products sale has been deleted.'));
        } else {
            $this->Flash->error(__('The products sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
