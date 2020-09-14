<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequisitionsProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequisitionsProductsTable Test Case
 */
class RequisitionsProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RequisitionsProductsTable
     */
    public $RequisitionsProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RequisitionsProducts',
        'app.Products',
        'app.Requisitions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RequisitionsProducts') ? [] : ['className' => RequisitionsProductsTable::class];
        $this->RequisitionsProducts = TableRegistry::getTableLocator()->get('RequisitionsProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequisitionsProducts);

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
