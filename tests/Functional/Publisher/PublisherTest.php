<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests\Functional\Publisher;

use Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher;
use Facile\CrossbarHTTPPublisherBundle\Tests\BaseFunctionalTest;

/**
 * Class PublisherTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests\DependencyInjection
 */
class PublisherTest extends BaseFunctionalTest
{
    public function testPublish()
    {
        /** @var Publisher $publisher */
        $publisher = $this->container->get('facile.crossbar.publisher.integration_test_publisher');

        $response = $publisher->publish('topic', null, ['someData' => 'payload']);

        $this->assertArrayHasKey('id', $response);
    }
}
