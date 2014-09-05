<?php
namespace Igdr\Bundle\ConfigKnpMenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder\MenuTreeBuilder;

/**
 * Configuration for the navigation
 */
class NavigationConfiguration implements ConfigurationInterface
{
    /**
     * The menu name
     *
     * @var string
     */
    protected $rootName = false;

    /**
     * Set the menu root name
     *
     * @param string $rootName the menu root name
     */
    public function setMenuRootName($rootName)
    {
        $this->rootName = $rootName;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root($this->rootName, 'array', new MenuTreeBuilder());

        // Tree node level added in order to keep the array keys for the first level of nodes
        $rootNode
            ->children()
                ->arrayNode('attributes')
                    ->children()
                        ->scalarNode('class')
                        ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->menuNode('tree')
                    ->menuNodeHierarchy()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
