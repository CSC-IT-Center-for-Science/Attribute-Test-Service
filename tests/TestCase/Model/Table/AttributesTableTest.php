<?php
namespace Attribute\Test\TestCase\Model\Table;

use Attribute\Model\Table\AttributesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Attribute\Model\Table\AttributesTable Test Case
 */
class AttributesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Attribute\Model\Table\AttributesTable
     */
    public $Attributes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.attribute.attributes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Attributes') ? [] : ['className' => 'Attribute\Model\Table\AttributesTable'];
        $this->Attributes = TableRegistry::get('Attributes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Attributes);

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
