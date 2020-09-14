<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SuppliersTrucksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SuppliersTrucksTable Test Case
 */
class SuppliersTrucksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SuppliersTrucksTable
     */
    public $SuppliersTrucks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SuppliersTrucks',
        'app.Suppliers',
        'app.Trucks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SuppliersTrucks') ? [] : ['className' => SuppliersTrucksTable::class];
        $this->SuppliersTrucks = TableRegistry::getTableLocator()->get('SuppliersTrucks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SuppliersTrucks);

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
