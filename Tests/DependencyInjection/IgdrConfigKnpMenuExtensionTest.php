<?php

namespace Igdr\Bundle\PhumborBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Igdr\Bundle\ConfigKnpMenuBundle\DependencyInjection\IgdrConfigKnpMenuExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Test Extension
 */
class IgdrConfigKnpMenuExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test loading data from file
     */
    public function testLoading()
    {
        $menuConfiguration = self::loadConfiguration();

        $this->assertEquals($menuConfiguration['main']['tree']['second_item']['label'], 'Second Item Label');
        $this->assertEquals($menuConfiguration['main']['tree']['first_item']['label'], 'First Item Label');
        $this->assertEquals(count($menuConfiguration['main']['tree']['second_item']['children']), 1);
    }

    public static function loadConfiguration()
    {
        $containerBuilder = self::createContainer();
        $extension = new IgdrConfigKnpMenuExtension();
        $extension->load(array(), $containerBuilder);

        return $containerBuilder->getParameter('igdr_config_menu.menu.configuration');
    }

    /**
     * Create a container
     *
     * @param array $data
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected static function createContainer($data = array())
    {
        $container = new ContainerBuilder(new ParameterBag(array_merge(array(
            'kernel.bundles'     => array(
                'IgdrTest1Bundle' =>
                    'Igdr\\Bundle\\ConfigKnpMenuBundle\\Tests\\DependencyInjection\\Fixtures\\Bundle1\\IgdrTest1Bundle',
                'IgdrTest2Bundle' =>
                    'Igdr\\Bundle\\ConfigKnpMenuBundle\\Tests\\DependencyInjection\\Fixtures\\Bundle2\\IgdrTest2Bundle'
            ),
        ), $data)));

        return $container;
    }
}
