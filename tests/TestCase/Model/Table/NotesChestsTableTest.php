<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotesChestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotesChestsTable Test Case
 */
class NotesChestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotesChestsTable
     */
    public $NotesChests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotesChests',
        'app.Notes',
        'app.Movements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NotesChests') ? [] : ['className' => NotesChestsTable::class];
        $this->NotesChests = TableRegistry::getTableLocator()->get('NotesChests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotesChests);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
