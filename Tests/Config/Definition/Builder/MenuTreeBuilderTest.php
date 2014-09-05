<?php
namespace Igdr\Bundle\ConfigKnpMenuBundle\Tests\Config\Definition\Builder;

use Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuTreeBuilder;

/**
 * Tests for Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuTreeBuilder
 */
class MenuTreeBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuTreeBuilder
     */
    protected $builder;

    /**
     * Init builder
     */
    protected function setUp()
    {
        $this->builder = new MenuTreeBuilder();
    }

    /**
     * Test constructor
     * Verify if the menu node has been registered
     */
    public function testConstructor()
    {
        $nodeMapping = $this->readAttribute($this->builder, 'nodeMapping');
        $this->assertArrayHasKey('menu', $nodeMapping);
        $this->assertEquals(
            'Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuNodeDefinition',
            $nodeMapping['menu']
        );
    }

    /**
     * Test if builder return a menu node
     */
    public function testMenuNode()
    {
        $nodeDefinition = $this->builder->menuNode('test');
        $this->assertInstanceOf(
            'Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuNodeDefinition',
            $nodeDefinition
        );
        $this->assertEquals('test', $nodeDefinition->getNode()->getName());
    }
}
