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

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

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

            $protocol = $connection['protocol'];
            $host = $connection['host'];
            $port = $connection['port'];
            $path = $connection['path'];
            $auth_key = $connection['auth_key'];
            $auth_secret = $connection['auth_secret'];
            $hostname = $connection['hostname'];
            $ignoreSsl = $connection['ssl_ignore'];

            if($path[0] != '/') {
                $path = '/'.$path;
            }

            $definition = new Definition(
                "Facile\CrossbarHTTPPublisherBundle\Publisher\Factory",
                array($protocol, $host, $port, $path, $auth_key, $auth_secret, $hostname, $ignoreSsl)
            );
            $definition->setPublic(false);
            $factoryName = sprintf('facile.crossbar.publisher.factory.%s', $key);
            $this->container->setDefinition($factoryName, $definition);

            $definition = new Definition("Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher");
            if (method_exists($definition, 'setFactory')) {
                $definition->setFactory(array(new Reference($factoryName), 'createPublisher'));
            } else {
                $definition->setFactoryService($factoryName);
                $definition->setFactoryMethod('createPublisher');
            }
            $this->container->setDefinition(sprintf('facile.crossbar.publisher.%s', $key), $definition);
        }
    }
}