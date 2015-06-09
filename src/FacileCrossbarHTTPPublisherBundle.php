<?php

namespace Facile\CrossbarHTTPPublisherBundle;

use Facile\CrossbarHTTPPublisherBundle\DependencyInjection\Compiler\RegisterPusherPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class FacileCrossbarHTTPPublisherBundle
 * @package Facile\CrossbarHTTPPublisherBundle
 */
class FacileCrossbarHTTPPublisherBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterPusherPass());
    }
}