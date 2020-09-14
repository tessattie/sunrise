<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomersProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomersProductsTable Test Case
 */
class CustomersProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomersProductsTable
     */
    public $CustomersProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CustomersProducts',
        'app.Customers',
        'app.Products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomersProducts') ? [] : ['className' => CustomersProductsTable::class];
        $this->CustomersProducts = TableRegistry::getTableLocator()->get('CustomersProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomersProducts);

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
