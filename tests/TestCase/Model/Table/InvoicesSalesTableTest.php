<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoicesSalesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoicesSalesTable Test Case
 */
class InvoicesSalesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoicesSalesTable
     */
    public $InvoicesSales;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.InvoicesSales',
        'app.Invoices',
        'app.Sales'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InvoicesSales') ? [] : ['className' => InvoicesSalesTable::class];
        $this->InvoicesSales = TableRegistry::getTableLocator()->get('InvoicesSales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InvoicesSales);

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
