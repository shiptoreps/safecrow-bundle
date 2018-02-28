<?php

namespace SafeCrowBundle\DependencyInjection;

use SafeCrow\Config;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class SafeCrowExtension
 * @package SafeCrowBundle\DependencyInjection
 */
class SafeCrowExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('safe_crow', $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->addClients($config['clients'], $container);
    }

    /**
     * @param array            $clients
     * @param ContainerBuilder $container
     */
    protected function addClients(array $clients, ContainerBuilder $container)
    {
        foreach ($clients as $name => $client) {
            $config = new Config($client['key'], $client['secret'], $client['dev']);

            $definition = new Definition('%safe_crow.client.class%');
            $definition->addMethodCall('authenticate', [$config]);

            $container->setDefinition(
                sprintf('safe_crow.client.%s', $name),
                $definition
            );
        }
    }
}
