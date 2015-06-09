<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ServicesTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    protected function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    public function testServicesAreDefinedInContainer()
    {
        /** @var ContainerInterface $container */
        $container = $this->container;
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);

        $this->assertTrue(
            $container->has('facile.crossbar.publisher.guzzlehttp.client')
        );
        $guzzleClient = $container->get('facile.crossbar.publisher.guzzlehttp.client');
        $this->assertInstanceOf('\GuzzleHttp\Client', $guzzleClient);

        $this->assertTrue(
            $container->has('facile.crossbar.publisher.factory')
        );
        $factory = $container->get('facile.crossbar.publisher.factory');
        $this->assertInstanceOf('\Facile\CrossbarHTTPPublisherBundle\Publisher\Factory', $factory);
    }

    public function testConnectionsServicesAreDefinedInContainer()
    {
        /** @var ContainerInterface $container */
        $container = $this->container;
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);
    }
}