<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FlightsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FlightsTable Test Case
 */
class FlightsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FlightsTable
     */
    public $Flights;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Flights',
        'app.ProductsSales'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Flights') ? [] : ['className' => FlightsTable::class];
        $this->Flights = TableRegistry::getTableLocator()->get('Flights', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Flights);

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
}
