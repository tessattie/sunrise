<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaymentsSalesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaymentsSalesTable Test Case
 */
class PaymentsSalesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PaymentsSalesTable
     */
    public $PaymentsSales;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PaymentsSales',
        'app.Sales',
        'app.Payments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PaymentsSales') ? [] : ['className' => PaymentsSalesTable::class];
        $this->PaymentsSales = TableRegistry::getTableLocator()->get('PaymentsSales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PaymentsSales);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
