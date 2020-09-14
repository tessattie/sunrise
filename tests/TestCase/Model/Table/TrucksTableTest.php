<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrucksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrucksTable Test Case
 */
class TrucksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrucksTable
     */
    public $Trucks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Trucks',
        'app.Users',
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
        $config = TableRegistry::getTableLocator()->exists('Trucks') ? [] : ['className' => TrucksTable::class];
        $this->Trucks = TableRegistry::getTableLocator()->get('Trucks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Trucks);

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
