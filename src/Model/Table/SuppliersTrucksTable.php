<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SuppliersTrucks Model
 *
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\TrucksTable|\Cake\ORM\Association\BelongsTo $Trucks
 *
 * @method \App\Model\Entity\SuppliersTruck get($primaryKey, $options = [])
 * @method \App\Model\Entity\SuppliersTruck newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SuppliersTruck[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SuppliersTruck|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SuppliersTruck saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SuppliersTruck patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SuppliersTruck[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SuppliersTruck findOrCreate($search, callable $callback = null, $options = [])
 */
class SuppliersTrucksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('suppliers_trucks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Trucks', [
            'foreignKey' => 'truck_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));
        $rules->add($rules->existsIn(['truck_id'], 'Trucks'));
        $rules->add($rules->isUnique(['truck_id', 'supplier_id']));
        $rules->add($rules->isUnique(['code']));

        return $rules;
    }
}
