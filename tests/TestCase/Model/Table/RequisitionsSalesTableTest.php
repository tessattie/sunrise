<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequisitionsSalesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequisitionsSalesTable Test Case
 */
class RequisitionsSalesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RequisitionsSalesTable
     */
    public $RequisitionsSales;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RequisitionsSales',
        'app.Requisitions',
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
        $config = TableRegistry::getTableLocator()->exists('RequisitionsSales') ? [] : ['className' => RequisitionsSalesTable::class];
        $this->RequisitionsSales = TableRegistry::getTableLocator()->get('RequisitionsSales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequisitionsSales);

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
