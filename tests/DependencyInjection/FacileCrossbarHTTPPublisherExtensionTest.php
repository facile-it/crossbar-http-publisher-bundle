<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FacileCrossbarHTTPPublisherExtensionTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests
 */
class FacileCrossbarHTTPPublisherExtensionTest extends \PHPUnit_Framework_TestCase
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

        $this->assertFalse(
            $container->has('facile.crossbar.publisher.factory'), 
            'Factory present as a public service'
        );

        $this->assertFalse(
            $container->has('facile.crossbar.publisher.guzzlehttp.client'), 
            'Old, unneeded Guzzle client service present'
        );
    }

    public function testConnectionsServicesAreDefinedInContainer()
    {
        /** @var ContainerInterface $container */
        $container = $this->container;
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);

        $this->assertTrue(
            $container->has('facile.crossbar.publisher.dummy_publisher'),
            'Publisher missing from container'
        );

        $publisher = $container->get('facile.crossbar.publisher.dummy_publisher');
        $this->assertInstanceOf('\Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher', $publisher);
    }
}
