<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrucksStationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrucksStationsTable Test Case
 */
class TrucksStationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrucksStationsTable
     */
    public $TrucksStations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TrucksStations',
        'app.Stations',
        'app.Trucks',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TrucksStations') ? [] : ['className' => TrucksStationsTable::class];
        $this->TrucksStations = TableRegistry::getTableLocator()->get('TrucksStations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrucksStations);

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
