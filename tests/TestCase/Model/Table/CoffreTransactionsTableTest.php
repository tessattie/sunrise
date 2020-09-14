<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CoffreTransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CoffreTransactionsTable Test Case
 */
class CoffreTransactionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CoffreTransactionsTable
     */
    public $CoffreTransactions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CoffreTransactions',
        'app.Users',
        'app.Methods',
        'app.AdminRates',
        'app.MotifCoffre'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CoffreTransactions') ? [] : ['className' => CoffreTransactionsTable::class];
        $this->CoffreTransactions = TableRegistry::getTableLocator()->get('CoffreTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CoffreTransactions);

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
