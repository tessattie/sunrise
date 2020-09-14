<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequisitionsSales Model
 *
 * @property \App\Model\Table\RequisitionsTable|\Cake\ORM\Association\BelongsTo $Requisitions
 * @property \App\Model\Table\SalesTable|\Cake\ORM\Association\BelongsTo $Sales
 *
 * @method \App\Model\Entity\RequisitionsSale get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequisitionsSale newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequisitionsSale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionsSale|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequisitionsSale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequisitionsSale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionsSale[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionsSale findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RequisitionsSalesTable extends Table
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

        $this->setTable('requisitions_sales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Requisitions', [
            'foreignKey' => 'requisition_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sales', [
            'foreignKey' => 'sale_id',
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
        $rules->add($rules->existsIn(['requisition_id'], 'Requisitions'));
        $rules->add($rules->existsIn(['sale_id'], 'Sales'));

        return $rules;
    }
}
