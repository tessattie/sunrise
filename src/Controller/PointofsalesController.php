<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pointofsales Controller
 *
 * @property \App\Model\Table\PointofsalesTable $Pointofsales
 *
 * @method \App\Model\Entity\Pointofsale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PointofsalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $pointofsales = $this->paginate($this->Pointofsales);

        $this->set(compact('pointofsales'));
    }

    /**
     * View method
     *
     * @param string|null $id Pointofsale id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pointofsale = $this->Pointofsales->get($id, [
            'contain' => ['Sales']
        ]);

        $this->set('pointofsale', $pointofsale);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pointofsale = $this->Pointofsales->newEntity();
        if ($this->request->is('post')) {
            $pointofsale = $this->Pointofsales->patchEntity($pointofsale, $this->request->getData());
            if ($ident = $this->Pointofsales->save($pointofsale)) {
                $this->Flash->success(__('Le POS a bien été sauvegardée'));

                return $this->redirect(['action' => 'edit', $ident['id']]);
            }
            $this->Flash->error(__('Nous n\'avons pas pu sauvegarder le POS. Réessayez plus-tard'));
        }
        $this->set(compact('pointofsale'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pointofsale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pointofsale = $this->Pointofsales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pointofsale = $this->Pointofsales->patchEntity($pointofsale, $this->request->getData());
            if ($this->Pointofsales->save($pointofsale)) {
                $this->Flash->success(__('Les mises à jours ont bien été effectuées'));

            }else{
                $this->Flash->error(__('Les mises à jour n\'ont pas pu être effectuées. Réessayez.'));
            }
        }
        $this->set(compact('pointofsale'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pointofsale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $pointofsale = $this->Pointofsales->get($id);
        if ($this->Pointofsales->delete($pointofsale)) {
            $this->Flash->success(__('POS Supprimé'));
        } else {
            $this->Flash->error(__('Vous ne pouvez pas supprimer ce POS'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
