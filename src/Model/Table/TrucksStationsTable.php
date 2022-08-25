<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TrucksStations Model
 *
 * @property \App\Model\Table\StationsTable|\Cake\ORM\Association\BelongsTo $Stations
 * @property \App\Model\Table\TrucksTable|\Cake\ORM\Association\BelongsTo $Trucks
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\TrucksStation get($primaryKey, $options = [])
 * @method \App\Model\Entity\TrucksStation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TrucksStation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TrucksStation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrucksStation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrucksStation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TrucksStation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TrucksStation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrucksStationsTable extends Table
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

        $this->setTable('trucks_stations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Stations', [
            'foreignKey' => 'station_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Trucks', [
            'foreignKey' => 'truck_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->numeric('price')
            ->allowEmptyString('price', false);

        $validator
            ->numeric('taxe')
            ->allowEmptyString('taxe', false);

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
        $rules->add($rules->existsIn(['station_id'], 'Stations'));
        $rules->add($rules->existsIn(['truck_id'], 'Trucks'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
