<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequisitionsSales Controller
 *
 * @property \App\Model\Table\RequisitionsSalesTable $RequisitionsSales
 *
 * @method \App\Model\Entity\RequisitionsSale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequisitionsSalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Requisitions', 'Sales']
        ];
        $requisitionsSales = $this->paginate($this->RequisitionsSales);

        $this->set(compact('requisitionsSales'));
    }

    /**
     * View method
     *
     * @param string|null $id Requisitions Sale id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requisitionsSale = $this->RequisitionsSales->get($id, [
            'contain' => ['Requisitions', 'Sales']
        ]);

        $this->set('requisitionsSale', $requisitionsSale);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requisitionsSale = $this->RequisitionsSales->newEntity();
        if ($this->request->is('post')) {
            $requisitionsSale = $this->RequisitionsSales->patchEntity($requisitionsSale, $this->request->getData());
            if ($this->RequisitionsSales->save($requisitionsSale)) {
                $this->Flash->success(__('The requisitions sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisitions sale could not be saved. Please, try again.'));
        }
        $requisitions = $this->RequisitionsSales->Requisitions->find('list', ['limit' => 200]);
        $sales = $this->RequisitionsSales->Sales->find('list', ['limit' => 200]);
        $this->set(compact('requisitionsSale', 'requisitions', 'sales'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requisitions Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requisitionsSale = $this->RequisitionsSales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requisitionsSale = $this->RequisitionsSales->patchEntity($requisitionsSale, $this->request->getData());
            if ($this->RequisitionsSales->save($requisitionsSale)) {
                $this->Flash->success(__('The requisitions sale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisitions sale could not be saved. Please, try again.'));
        }
        $requisitions = $this->RequisitionsSales->Requisitions->find('list', ['limit' => 200]);
        $sales = $this->RequisitionsSales->Sales->find('list', ['limit' => 200]);
        $this->set(compact('requisitionsSale', 'requisitions', 'sales'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requisitions Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requisitionsSale = $this->RequisitionsSales->get($id);
        if ($this->RequisitionsSales->delete($requisitionsSale)) {
            $this->Flash->success(__('The requisitions sale has been deleted.'));
        } else {
            $this->Flash->error(__('The requisitions sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
