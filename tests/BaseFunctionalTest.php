<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BaseFunctionalTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests
 */
abstract class BaseFunctionalTest extends \PHPUnit_Framework_TestCase 
{
    /** @var ContainerInterface */
    protected $container;

    protected function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }
}
