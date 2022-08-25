<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Trackings Model
 *
 * @property \App\Model\Table\ProductsSalesTable|\Cake\ORM\Association\BelongsTo $ProductsSales
 * @property \App\Model\Table\FlightsTable|\Cake\ORM\Association\BelongsTo $Flights
 * @property \App\Model\Table\MovementsTable|\Cake\ORM\Association\BelongsTo $Movements
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\StationsTable|\Cake\ORM\Association\BelongsTo $Stations
 *
 * @method \App\Model\Entity\Tracking get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tracking newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tracking[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tracking|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tracking saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tracking patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tracking[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tracking findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrackingsTable extends Table
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

        $this->setTable('trackings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductsSales', [
            'foreignKey' => 'products_sale_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Flights', [
            'foreignKey' => 'flight_id'
        ]);
        $this->belongsTo('Movements', [
            'foreignKey' => 'movement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Stations', [
            'foreignKey' => 'station_id',
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

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->allowEmptyString('comment');

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
        $rules->add($rules->existsIn(['products_sale_id'], 'ProductsSales'));
        $rules->add($rules->existsIn(['flight_id'], 'Flights'));
        $rules->add($rules->existsIn(['movement_id'], 'Movements'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['station_id'], 'Stations'));

        return $rules;
    }
}
