<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $products = $this->Products->find('all', array('order' => array('Products.position ASC')))->contain(["Categories"]);

        $this->set(compact('products'));
    }

    public function find(){
        if($this->request->is("ajax")){
            $product = $this->Products->find('all', array('conditions' => array("id" => $this->request->getData()['id'])));
            if($product->count() == 0){
                echo json_encode("false");
            }else{
               echo json_encode($product->toArray()); 
            }
            
        }
        die();
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $product = $this->Products->get($id, [
            'contain' => ['Categories', 'Sales' => ["Trucks", "Customers", "ProductsSales" => ['Products'], 'conditions' => ['Sales.created >=' => $from, 'Sales.created <=' => $to]],  "ProductsSales" =>  ['Sales' => ['Trucks', 'Users', "Customers", "ProductsSales"]]]
        ]);

        $this->set('product', $product);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($ident = $this->Products->save($product)) {
                $this->Flash->success(__('Produit Sauvegardé'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder ce produit. Réessayez ou appelez votre administrateur.'));
        }
        $categories = $this->Products->Categories->find('list', ['order' => ['name ASC']]);
        $sales = $this->Products->Sales->find('list', ['limit' => 200]);
        $this->set(compact('product', 'categories', 'sales'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Sales']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
            
        }
        $categories = $this->Products->Categories->find('list', ['order' => ['name ASC']]);
        $sales = $this->Products->Sales->find('list', ['limit' => 200]);
        $this->set(compact('product', 'categories', 'sales'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('Produit Supprimé'));
        } else {
            $this->Flash->error(__('Impossible de supprimer ce produit'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
