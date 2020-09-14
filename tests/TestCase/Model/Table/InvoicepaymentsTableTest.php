<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoicepaymentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoicepaymentsTable Test Case
 */
class InvoicepaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoicepaymentsTable
     */
    public $Invoicepayments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Invoicepayments',
        'app.Users',
        'app.Rates',
        'app.Customers',
        'app.Invoices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Invoicepayments') ? [] : ['className' => InvoicepaymentsTable::class];
        $this->Invoicepayments = TableRegistry::getTableLocator()->get('Invoicepayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Invoicepayments);

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
