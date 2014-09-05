<?php
namespace Igdr\Bundle\ConfigKnpMenuBundle\Tests\Unit\Config\Definition\Builder;

use Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuNodeDefinition;

/**
 * Tests for Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuNodeDefinition
 */
class MenuNodeDefinitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $builder;

    /**
     * @var MenuNodeDefinition
     */
    protected $definition;

    /**
     * Init Mock
     */
    protected function setUp()
    {
        $this->builder = $this
            ->getMockBuilder('Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuTreeBuilder')
            ->setMethods(
                array(
                    'node',
                    'children',
                    'scalarNode',
                    'end',
                    'menuNode',
                    'menuNodeHierarchy',
                    'defaultTrue',
                    'prototype'
                )
            )
            ->getMock();
        $this->definition = new MenuNodeDefinition('test');
        $this->definition->setBuilder($this->builder);
    }

    /**
     * Test that if depth is 0, then the menu node definition is returned
     */
    public function testMenuNodeHierarchyZeroDepth()
    {
        $this->builder->expects($this->never())
            ->method('node');

        $this->assertInstanceOf(
            'Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuNodeDefinition',
            $this->definition->menuNodeHierarchy(0)
        );
    }

    /**
     * Test the recursive calls
     */
    public function testMenuNodeHierarchyNonZeroDepth()
    {
        $this->builder->expects($this->any())
            ->method('node')
            ->will($this->returnSelf());

        $this->builder->expects($this->any())
            ->method('children')
            ->will($this->returnSelf());

        $this->builder->expects($this->any())
            ->method('scalarNode')
            ->will($this->returnSelf());

        $this->builder->expects($this->any())
            ->method('end')
            ->will($this->returnSelf());

        $this->builder->expects($this->any())
            ->method('prototype')
            ->will($this->returnSelf());

        $this->builder->expects($this->once())
            ->method('menuNode')
            ->with('children')
            ->will($this->returnSelf());

        $this->builder->expects($this->once())
            ->method('menuNodeHierarchy')
            ->with(9)
            ->will($this->returnSelf());

        $this->builder->expects($this->any())
            ->method('defaultTrue')
            ->will($this->returnSelf());

        $this->definition->menuNodeHierarchy(10);
    }
}
