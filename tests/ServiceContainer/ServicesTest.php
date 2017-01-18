<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ServicesTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests
 */
class ServicesTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerInterface */
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
        /** @var ClientInterface $guzzleClient */
        $guzzleClient = $container->get('facile.crossbar.publisher.guzzlehttp.client');
        $this->assertInstanceOf('\GuzzleHttp\ClientInterface', $guzzleClient);
        $guzzleClient->getDefaultOption();
    }

    public function testConnectionsServicesAreDefinedInContainer()
    {
        /** @var ContainerInterface $container */
        $container = $this->container;
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);

        $this->assertTrue(
            $container->has('facile.crossbar.publisher.dummy_publisher')
        );
        $publisher = $container->get('facile.crossbar.publisher.dummy_publisher');
        $this->assertInstanceOf('\Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher', $publisher);
    }
}
