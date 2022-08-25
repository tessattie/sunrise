<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrackingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrackingsTable Test Case
 */
class TrackingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrackingsTable
     */
    public $Trackings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Trackings',
        'app.ProductsSales',
        'app.Flights',
        'app.Movements',
        'app.Users',
        'app.Stations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Trackings') ? [] : ['className' => TrackingsTable::class];
        $this->Trackings = TableRegistry::getTableLocator()->get('Trackings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Trackings);

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
