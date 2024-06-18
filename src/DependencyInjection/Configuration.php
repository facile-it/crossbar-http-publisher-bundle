<?php

namespace Facile\CrossbarHTTPPublisherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Facile\CrossbarHTTPPublisherBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tree = new TreeBuilder('facile_crossbar_http_publisher');
        $rootNode = $tree->getRootNode();
        $this->addConnections($rootNode);

        return $tree;
    }

    protected function addConnections(ArrayNodeDefinition $node): void
    {
        $node
            ->fixXmlConfig('connection')
            ->children()
            ->arrayNode('connections')
            ->canBeUnset()
            ->prototype('array')
            ->children()
            ->scalarNode('protocol')->defaultValue('http')->end()
            ->scalarNode('host')->defaultValue('127.0.0.1')->end()
            ->scalarNode('path')->defaultValue('/publish')->end()
            ->scalarNode('port')->defaultValue(8080)->end()
            ->scalarNode('auth_secret')->defaultValue(null)->end()
            ->scalarNode('auth_key')->defaultValue(null)->end()
            ->scalarNode('hostname')->defaultValue(null)->end()
            ->booleanNode('ssl_ignore')->defaultFalse()->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }
}
