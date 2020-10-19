<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpaymentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpaymentsTable Test Case
 */
class SpaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SpaymentsTable
     */
    public $Spayments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Spayments',
        'app.Users',
        'app.Suppliers',
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
        $config = TableRegistry::getTableLocator()->exists('Spayments') ? [] : ['className' => SpaymentsTable::class];
        $this->Spayments = TableRegistry::getTableLocator()->get('Spayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Spayments);

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
