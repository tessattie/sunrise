<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Methods Controller
 *
 * @property \App\Model\Table\MethodsTable $Methods
 *
 * @method \App\Model\Entity\Method[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MethodsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $methods = $this->paginate($this->Methods);

        $this->set(compact('methods'));
    }



}
