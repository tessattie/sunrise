<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CpaymentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CpaymentsTable Test Case
 */
class CpaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CpaymentsTable
     */
    public $Cpayments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Cpayments',
        'app.Customers',
        'app.Rates',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cpayments') ? [] : ['className' => CpaymentsTable::class];
        $this->Cpayments = TableRegistry::getTableLocator()->get('Cpayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cpayments);

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
