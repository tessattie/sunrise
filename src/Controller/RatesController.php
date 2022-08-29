<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rates Controller
 *
 * @property \App\Model\Table\RatesTable $Rates
 *
 * @method \App\Model\Entity\Rate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $rates = $this->Rates->find("all");

        $this->set(compact('rates'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rate = $this->Rates->patchEntity($rate, $this->request->getData());
            if ($this->Rates->save($rate)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $this->set(compact('rate'));
    }


    public function find(){
        if($this->request->is("ajax")){
            $rate = $this->Rates->find('all', array('conditions' => array("id" => $this->request->getData()['id'])));
            if($rate->count() == 0){
                echo json_encode("false");
            }else{
               echo json_encode($rate->toArray()); 
            }
        }
        die();
    }
    
}
