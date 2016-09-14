<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SnsTable Test Case
 */
class SnsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SnsTable
     */
    public $Sns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sns'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Sns') ? [] : ['className' => 'App\Model\Table\SnsTable'];
        $this->Sns = TableRegistry::get('Sns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sns);

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
