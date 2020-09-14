<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentsFixture
 */
class PaymentsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'sale_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'method_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'amount' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'rate_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_paymentsSales' => ['type' => 'index', 'columns' => ['sale_id'], 'length' => []],
            'FK_methodPayments' => ['type' => 'index', 'columns' => ['method_id'], 'length' => []],
            'FK_paymentsUsers' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'FK_paymentsRates' => ['type' => 'index', 'columns' => ['rate_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_methodPayments' => ['type' => 'foreign', 'columns' => ['method_id'], 'references' => ['methods', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_paymentsRates' => ['type' => 'foreign', 'columns' => ['rate_id'], 'references' => ['rates', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_paymentsSales' => ['type' => 'foreign', 'columns' => ['sale_id'], 'references' => ['sales', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_paymentsUsers' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'sale_id' => 1,
                'method_id' => 1,
                'amount' => 1,
                'rate_id' => 1,
                'created' => '2019-06-14 20:43:16',
                'modified' => '2019-06-14 20:43:16',
                'user_id' => 1
            ],
        ];
        parent::init();
    }
}
