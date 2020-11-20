<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReceiversTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReceiversTable Test Case
 */
class ReceiversTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReceiversTable
     */
    public $Receivers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Receivers',
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
        $config = TableRegistry::getTableLocator()->exists('Receivers') ? [] : ['className' => ReceiversTable::class];
        $this->Receivers = TableRegistry::getTableLocator()->get('Receivers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Receivers);

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
