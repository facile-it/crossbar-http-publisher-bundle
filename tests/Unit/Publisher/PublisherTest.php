<?php

namespace Facile\CrossbarHTTPPublisherBundle\Tests\Unit\Publisher;

use Facile\CrossbarHTTPPublisherBundle\Exception\PublishRequestException;
use Facile\CrossbarHTTPPublisherBundle\Publisher\Publisher;
use GuzzleHttp\Client;
use Prophecy\Argument;

/**
 * Class PublisherTest
 * @package Facile\CrossbarHTTPPublisherBundle\Tests\Unit\Publisher
 */
class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function testPublishWillCatchAndRethrowExceptions()
    {
        $client = $this->prophesize(Client::class);
        $client->post(Argument::cetera())
            ->willThrow(new \Exception('Message'));
        
        $publisher = new Publisher($client->reveal(), 'key', 'secret');
        $this->setExpectedException(PublishRequestException::class, 'Message');
    
        $publisher->publish('topic', ['arguments']);
    }
}
