<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sales Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\TrucksTable|\Cake\ORM\Association\BelongsTo $Trucks
 * @property \App\Model\Table\PointofsalesTable|\Cake\ORM\Association\BelongsTo $Pointofsales
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\HasMany $Payments
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \App\Model\Entity\Sale get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sale newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sale|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sale[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sale findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SalesTable extends Table
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

        $this->setTable('sales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Pointofsales', [
            'foreignKey' => 'pointofsale_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Trucks', [
            'foreignKey' => 'truck_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Payments', [
            'foreignKey' => 'sale_id'
        ]);

        $this->belongsTo('Receivers', [
            'foreignKey' => 'receiver_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Stations', [
            'foreignKey' => 'station_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('PaymentsSales', [
            'foreignKey' => 'sale_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ProductsSales', [
            'foreignKey' => 'sale_id'
        ]);

    $this->hasMany('ProductsSales', [
       'foreignKey' => 'sale_id'
   ]);

    $this->hasMany('RequisitionsSales', [
       'foreignKey' => 'sale_id'
   ]);

    $this->belongsToMany('Products', [
       'foreignKey' => 'sale_id',
       'targetForeignKey' => 'product_id',
       'joinTable' => 'products_sales'
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
            ->scalar('sale_number')
            ->maxLength('sale_number', 255)
            ->requirePresence('sale_number', 'create')
            ->allowEmptyString('sale_number', false);

        $validator
            ->integer('status')
            ->allowEmptyString('status', false);

        $validator
            ->numeric('taxe')
            ->allowEmptyString('taxe', false);

        $validator
            ->numeric('subtotal')
            ->allowEmptyString('subtotal', false);


        $validator
            ->integer('discount_type')
            ->allowEmptyString('discount_type', false);

        $validator
            ->numeric('total')
            ->allowEmptyString('total', false);

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['pointofsale_id'], 'Pointofsales'));

        return $rules;
    }

    public function findHidden(Query $query, array $options)
    {
        $query->where([
            'Sales.hidden' => true
        ]);
        return $query;
    }
}
