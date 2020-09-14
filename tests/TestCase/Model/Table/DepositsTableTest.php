<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DepositsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DepositsTable Test Case
 */
class DepositsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DepositsTable
     */
    public $Deposits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Deposits',
        'app.Customers',
        'app.Rates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Deposits') ? [] : ['className' => DepositsTable::class];
        $this->Deposits = TableRegistry::getTableLocator()->get('Deposits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Deposits);

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
