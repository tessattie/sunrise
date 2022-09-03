<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Flights Model
 *
 * @property \App\Model\Table\ProductsSalesTable|\Cake\ORM\Association\HasMany $ProductsSales
 *
 * @method \App\Model\Entity\Flight get($primaryKey, $options = [])
 * @method \App\Model\Entity\Flight newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Flight[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Flight|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Flight saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Flight patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Flight[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Flight findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FlightsTable extends Table
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

        $this->setTable('flights');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ProductsSales', [
            'foreignKey' => 'flight_id'
        ]);

        $this->belongsTo('Stations', [
            'foreignKey' => 'station_id',
            'joinType' => 'LEFT'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->boolean('status')
            ->allowEmptyString('status', false);

        return $validator;
    }
}
