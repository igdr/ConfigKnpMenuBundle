<?php
namespace Igdr\Bundle\ConfigKnpMenuBundle\Config\Definition\Builder;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * MenuTreeBuilder
 *
 * Register the new MenuNodeDefinition
 */
class MenuTreeBuilder extends NodeBuilder
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->nodeMapping['menu'] = __NAMESPACE__ . '\\MenuNodeDefinition';
    }

    /**
     * Creates a child menu node
     *
     * @param  string $name The name of the node
     * @return MenuNodeDefinition The child node
     */
    public function menuNode($name)
    {
        return $this->node($name, 'menu');
    }
}
