<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminRatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminRatesTable Test Case
 */
class AdminRatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminRatesTable
     */
    public $AdminRates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AdminRates',
        'app.CoffreStatus',
        'app.CoffreTransactions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdminRates') ? [] : ['className' => AdminRatesTable::class];
        $this->AdminRates = TableRegistry::getTableLocator()->get('AdminRates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminRates);

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
