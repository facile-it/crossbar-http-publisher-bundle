<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BaseFunctionalTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests
 */
abstract class BaseFunctionalTest extends TestCase
{
    /** @var ContainerInterface */
    protected $container;

    protected function setUp(): void
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }
}
