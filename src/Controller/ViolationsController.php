<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Violations Controller
 *
 * @property \App\Model\Table\ViolationsTable $Violations
 *
 * @method \App\Model\Entity\violation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ViolationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $violations = $this->Violations->find('all', array('order' => array("name ASC")));

        $this->set(compact('violations'));
    }

    /**
     * View method
     *
     * @param string|null $id violation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $violation = $this->Violations->get($id);

        $this->set('violation', $violation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $violation = $this->Violations->newEntity();
        if ($this->request->is('post')) {
            $violation = $this->Violations->patchEntity($violation, $this->request->getData());
            if ($ident = $this->Violations->save($violation)) {
                $this->Flash->success(__('La contravention a bien été sauvegardée'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder la contravention. Réessayez plus-tard'));
        }
        $this->set(compact('violation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id violation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $violation = $this->Violations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $violation = $this->Violations->patchEntity($violation, $this->request->getData());
            if ($this->Violations->save($violation)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $this->set(compact('violation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id violation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $violation = $this->Violations->get($id);
        if ($this->Violations->delete($violation)) {
            $this->Flash->success(__('Contravention Supprimée'));
        } else {
            $this->Flash->error(__('Vous ne pouvez pas supprimer cette contravention'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function save()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            // debug($this->request->getData())
            $violation = $this->Violations->get($this->request->getData()['violation_id']);

            $this->loadModel('SuppliersViolations'); 
            // die('here');
            $sp = $this->SuppliersViolations->newEntity();
            // die('here');
            $sp->supplier_id = $this->request->getData()['supplier_id'];
            $sp->violation_id = $this->request->getData()['violation_id'];
            $sp->truck_id = $this->request->getData()['truck_id'];
            $sp->price = $violation->price;
            $sp->user_id = $this->Auth->user()['id'];
            $this->SuppliersViolations->save($sp);
            return $this->redirect(['controller' => 'Suppliers', 'action' => 'edit', $this->request->getData()['supplier_id']]);
        }

        die();
    }
}
