<?php

namespace Facile\CrossbarHTTPPublisherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class FacileCrossbarHTTPPublisherExtension
 * @package Facile\CrossbarHTTPPublisherBundle\DependencyInjection
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
        $genericDefinition = new Definition('Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher');
        if (method_exists($genericDefinition, 'setFactory')) {
            $genericDefinition->setFactory([new Reference($factoryName), 'createPublisher']);
        } else {
            $genericDefinition->setFactoryService($factoryName);
            $genericDefinition->setFactoryMethod('createPublisher');
        }

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
            $container->setDefinition(sprintf('facile.crossbar.publisher.%s', $key), $definition);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @return string The factory service name inside the container
     */
    private function addFactoryToContainer(ContainerBuilder $container)
    {
        $factoryDefinition = new Definition('Facile\CrossbarHTTPPublisherBundle\Publisher\Factory');
        $factoryDefinition->setPublic(false);
        $factoryName = 'facile.crossbar.publisher.factory';
        $container->setDefinition($factoryName, $factoryDefinition);

        return $factoryName;
    }
}
