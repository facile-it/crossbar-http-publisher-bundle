<?php

namespace Facile\CrossbarHTTPPublisherBundle\DependencyInjection;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
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
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $this->loadConnections($container, $config);
    }

    /**
     * Registers publisher services in container
     * @param ContainerBuilder $container
     * @param array $config
     */
    protected function loadConnections(ContainerBuilder $container, array $config)
    {
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

            $factoryDefinition = new Definition(
                'Facile\CrossbarHTTPPublisherBundle\Publisher\Factory',
                array($protocol, $host, $port, $path, $auth_key, $auth_secret, $hostname, $ignoreSsl)
            );
            $factoryDefinition->setPublic(false);
            $factoryName = sprintf('facile.crossbar.publisher.factory.%s', $key);
            $container->setDefinition($factoryName, $factoryDefinition);

            $definition = new Definition('Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher');
            if (method_exists($definition, 'setFactory')) {
                $definition->setFactory(array(new Reference($factoryName), 'createPublisher'));
            } else {
                $definition->setFactoryService($factoryName);
                $definition->setFactoryMethod('createPublisher');
            }
            $container->setDefinition(sprintf('facile.crossbar.publisher.%s', $key), $definition);
        }
    }
}
