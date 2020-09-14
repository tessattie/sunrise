<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotesMovements Model
 *
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\BelongsTo $Notes
 * @property \App\Model\Table\MovementsTable|\Cake\ORM\Association\BelongsTo $Movements
 *
 * @method \App\Model\Entity\NotesMovement get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotesMovement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotesMovement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotesMovement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotesMovement saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotesMovement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotesMovement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotesMovement findOrCreate($search, callable $callback = null, $options = [])
 */
class NotesMovementsTable extends Table
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

        $this->setTable('notes_movements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Notes', [
            'foreignKey' => 'note_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Movements', [
            'foreignKey' => 'movement_id',
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
        $rules->add($rules->existsIn(['note_id'], 'Notes'));
        $rules->add($rules->existsIn(['movement_id'], 'Movements'));

        return $rules;
    }
}
