<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests\Unit\Publisher;

use Facile\CrossbarHTTPPublisherBundle\Exception\PublishRequestException;
use Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * Class PublisherTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests\Unit\Publisher
 */
class PublisherTest extends TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;
    public function testPublishWillCatchAndRethrowExceptions()
    {
        $client = $this->prophesize(Client::class);
        $client->post(Argument::cetera())
            ->willThrow(new \Exception('Message'));
        
        $publisher = new Publisher($client->reveal(), 'key', 'secret');

        $this->expectException(PublishRequestException::class);
        $publisher->publish('topic', ['arguments']);
    }
}
