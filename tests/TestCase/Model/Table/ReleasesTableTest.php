<?php
namespace Attribute\Test\TestCase\Model\Table;

use Attribute\Model\Table\ReleasesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Attribute\Model\Table\ReleasesTable Test Case
 */
class ReleasesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Attribute\Model\Table\ReleasesTable
     */
    public $Releases;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.attribute.releases'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Releases') ? [] : ['className' => 'Attribute\Model\Table\ReleasesTable'];
        $this->Releases = TableRegistry::get('Releases', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Releases);

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
