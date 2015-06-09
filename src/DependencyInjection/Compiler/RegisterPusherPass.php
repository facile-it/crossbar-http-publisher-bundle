<?php

namespace Facile\CrossbarHTTPPublisherBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RegisterPusherPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
//        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
//            $definition->addMethodCall('addPart', array($tag, new Reference($id)));
//        }
    }
}