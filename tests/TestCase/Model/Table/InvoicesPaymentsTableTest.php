<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoicesPaymentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoicesPaymentsTable Test Case
 */
class InvoicesPaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoicesPaymentsTable
     */
    public $InvoicesPayments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.InvoicesPayments',
        'app.Invoices',
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
        $config = TableRegistry::getTableLocator()->exists('InvoicesPayments') ? [] : ['className' => InvoicesPaymentsTable::class];
        $this->InvoicesPayments = TableRegistry::getTableLocator()->get('InvoicesPayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InvoicesPayments);

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
