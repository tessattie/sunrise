<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReceivingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReceivingsTable Test Case
 */
class ReceivingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReceivingsTable
     */
    public $Receivings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Receivings',
        'app.Users',
        'app.Trucks',
        'app.Suppliers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Receivings') ? [] : ['className' => ReceivingsTable::class];
        $this->Receivings = TableRegistry::getTableLocator()->get('Receivings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Receivings);

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
