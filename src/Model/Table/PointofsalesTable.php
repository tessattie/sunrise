<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pointofsales Model
 *
 * @property \App\Model\Table\SalesTable|\Cake\ORM\Association\HasMany $Sales
 *
 * @method \App\Model\Entity\Pointofsale get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pointofsale newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pointofsale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pointofsale|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pointofsale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pointofsale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pointofsale[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pointofsale findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PointofsalesTable extends Table
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

        $this->setTable('pointofsales');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Sales', [
            'foreignKey' => 'pointofsale_id'
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

        $validator
            ->scalar('imei')
            ->maxLength('imei', 255)
            ->requirePresence('imei', 'create')
            ->allowEmptyString('imei', false);

        $validator
            ->scalar('serial_number')
            ->maxLength('serial_number', 255)
            ->requirePresence('serial_number', 'create')
            ->allowEmptyString('serial_number', false);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->integer('status')
            ->allowEmptyString('status', false);

        return $validator;
    }
}
