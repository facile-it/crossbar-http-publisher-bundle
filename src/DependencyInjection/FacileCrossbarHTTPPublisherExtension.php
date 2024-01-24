<?php

namespace Facile\CrossbarHTTPPublisherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher;
use Facile\CrossbarHTTPPublisherBundle\Publisher\Factory;

/**
 * Class FacileCrossbarHTTPPublisherExtension
 * @package Facile\CrossbarHTTPPublisherBundle\DependencyInjection
 * @see \Facile\CrossbarHTTPPublisherBundle\Tests\DependencyInjection\FacileCrossbarHTTPPublisherExtensionTest
 */
class FacileCrossbarHTTPPublisherExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $this->loadConnections($container, $config);
    }

    /**
     * Registers publisher services in container
     * @param ContainerBuilder $container
     * @param array $config
     */
    private function loadConnections(ContainerBuilder $container, array $config)
    {
        $factoryName = $this->addFactoryToContainer($container);
        $genericDefinition = new Definition(Publisher::class);
        $genericDefinition->setFactory([new Reference($factoryName), 'createPublisher']);

        foreach ($config['connections'] as $key => $connection) {
            $protocol = $connection['protocol'];
            $host = $connection['host'];
            $port = $connection['port'];
            $path = $connection['path'];
            $auth_key = $connection['auth_key'];
            $auth_secret = $connection['auth_secret'];
            $hostname = $connection['hostname'];
            $ignoreSsl = $connection['ssl_ignore'];

            if ($path[0] !== '/') {
                $path = '/' . $path;
            }

            $definition = clone $genericDefinition;
            $definition->setArguments([$protocol, $host, $port, $path, $auth_key, $auth_secret, $hostname, $ignoreSsl]);
            $definition->setPublic(true);
            $container->setDefinition(sprintf('facile.crossbar.publisher.%s', $key), $definition);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @return string The factory service name inside the container
     */
    private function addFactoryToContainer(ContainerBuilder $container)
    {
        $factoryDefinition = new Definition(Factory::class);
        $factoryDefinition->setPublic(false);
        $factoryName = 'facile.crossbar.publisher.factory';
        $container->setDefinition($factoryName, $factoryDefinition);

        return $factoryName;
    }
}
