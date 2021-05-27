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
        $this->loadModel('ProductsSales'); $this->loadModel("Flights");
        // debug($id); die();
        $productsSale = $this->ProductsSales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            debug($this->request->getData());
            $productsSale = $this->ProductsSales->patchEntity($productsSale, $this->request->getData());
            $productsSale->flight_id = $this->request->getData()['flight_id'];
            if($this->request->getData()['is_loaded'] == 1){
               $productsSale->is_loaded = $this->request->getData()['is_loaded']; 
               $productsSale->loaded_user_id = $this->Auth->user()['id'];
               $productsSale->loaded = date("Y-m-d H:i:s");
            }else{
               $productsSale->is_loaded = 0; 
               $productsSale->loaded_user_id = NULL;
               $productsSale->loaded = NULL;
            }

            if($this->request->getData()['is_landed'] == 1){
               $productsSale->is_landed = $this->request->getData()['is_landed']; 
               $productsSale->landed_user_id = $this->Auth->user()['id'];
               $productsSale->landed = date("Y-m-d H:i:s");
            }else{
               $productsSale->is_landed = 0; 
               $productsSale->landed_user_id = NULL;
               $productsSale->landed = NULL;
            }

            if($this->request->getData()['is_delivered'] == 1){
               $productsSale->is_delivered = $this->request->getData()['is_delivered']; 
               $productsSale->delivered_user_id = $this->Auth->user()['id'];
               $productsSale->delivered = date("Y-m-d H:i:s");
            }else{
               $productsSale->is_delivered = 0; 
               $productsSale->delivered_user_id = NULL;
               $productsSale->delivered = NULL;
            }
            
            if ($this->ProductsSales->save($productsSale)) {
                $this->Flash->success(__('The products sale has been saved.'));

                return $this->redirect(['controller' => 'sales', 'action' => 'colis']);
            }
            $this->Flash->error(__('The products sale could not be saved. Please, try again.'));
        }
        $flights = $this->Flights->find("list");
        $this->set(compact('productsSale', 'flights'));
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
