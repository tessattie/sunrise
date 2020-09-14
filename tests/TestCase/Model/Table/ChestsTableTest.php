<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChestsTable Test Case
 */
class ChestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChestsTable
     */
    public $Chests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Chests',
        'app.Currencies',
        'app.Notes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Chests') ? [] : ['className' => ChestsTable::class];
        $this->Chests = TableRegistry::getTableLocator()->get('Chests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Chests);

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
