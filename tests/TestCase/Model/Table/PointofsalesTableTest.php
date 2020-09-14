<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PointofsalesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PointofsalesTable Test Case
 */
class PointofsalesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PointofsalesTable
     */
    public $Pointofsales;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Pointofsales',
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
        $config = TableRegistry::getTableLocator()->exists('Pointofsales') ? [] : ['className' => PointofsalesTable::class];
        $this->Pointofsales = TableRegistry::getTableLocator()->get('Pointofsales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pointofsales);

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
