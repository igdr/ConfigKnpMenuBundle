<?php
namespace Igdr\Bundle\ConfigKnpMenuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 * This is the class that loads and manages your bundle configuration
 */
class JbConfigKnpMenuExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuredMenus = array();

        foreach ($container->getParameter('kernel.bundles') as $bundle) {
            $reflection = new \ReflectionClass($bundle);
            if (is_file($file = dirname($reflection->getFilename()) . '/Resources/config/navigation.yml')) {
                $bundleConfig = Yaml::parse(realpath($file));

                if (is_array($bundleConfig)) {
                    $configuredMenus = array_replace_recursive($configuredMenus, $bundleConfig);
                }
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // validate menu configurations
        foreach ($configuredMenus as $rootName => $menuConfiguration) {
            $configuration = new NavigationConfiguration();
            $configuration->setMenuRootName($rootName);
            $menuConfiguration[$rootName] = $this->processConfiguration(
                $configuration,
                array($rootName => $menuConfiguration)
            );
        }

        // Set configuration to be used in a custom service
        $container->setParameter('igdr_config_menu.menu.configuration', $configuredMenus);

        // Last argument of this service is always the menu configuration
        $container
            ->getDefinition('igdr_config_menu.menu.builder')
            ->addArgument($configuredMenus);

    }
}
