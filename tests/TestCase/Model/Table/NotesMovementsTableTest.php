<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotesMovementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotesMovementsTable Test Case
 */
class NotesMovementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotesMovementsTable
     */
    public $NotesMovements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotesMovements',
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
        $config = TableRegistry::getTableLocator()->exists('NotesMovements') ? [] : ['className' => NotesMovementsTable::class];
        $this->NotesMovements = TableRegistry::getTableLocator()->get('NotesMovements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotesMovements);

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
