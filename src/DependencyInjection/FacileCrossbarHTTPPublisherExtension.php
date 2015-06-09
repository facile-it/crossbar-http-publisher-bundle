<?php

namespace Facile\CrossbarHTTPPublisherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class FacileCrossbarHTTPPublisherExtension
 * @package Facile\CrossbarHTTPPublisherBundle\DependencyInjection
 */
class FacileCrossbarHTTPPublisherExtension extends Extension
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var array
     */
    private $config = array();

    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->container = $container;

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $this->config = $this->processConfiguration($configuration, $config);

        $this->loadConnections();
    }

    /**
     * Registers publisher services in container
     */
    protected function loadConnections()
    {
        foreach ($this->config['connections'] as $key => $connection) {

            var_dump($connection);

            $definition = new Definition(
                "Facile\CrossbarHTTPPublisherBundle\Publisher\Factory",
                array($connection)
            );
            $definition->setPublic(false);
            $factoryName = sprintf('facile.crossbar.publisher.factory.%s', $key);
            $this->container->setDefinition($factoryName, $definition);

            $definition = new Definition("Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher");
            if (method_exists($definition, 'setFactory')) {
                // to be inlined in services.xml when dependency on Symfony DependencyInjection is bumped to 2.6
                $definition->setFactory(array(new Reference($factoryName), 'createPublisher'));
            } else {
                // to be removed when dependency on Symfony DependencyInjection is bumped to 2.6
                $definition->setFactoryService($factoryName);
                $definition->setFactoryMethod('createPublisher');
            }
            $this->container->setDefinition(sprintf('facile.crossbar.publisher.%s', $key), $definition);
        }
    }
}