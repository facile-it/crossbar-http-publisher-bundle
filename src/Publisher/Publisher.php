<?php

namespace Facile\CrossbarHTTPPublisherBundle\Publisher;

use GuzzleHttp\Client;

/**
 * Class Publisher
 * @package Facile\CrossbarHTTPPublisherBundle\Publisher
 */
class Publisher
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $secret;

    /**
     * @param Client $client
     * @param $key
     * @param $secret
     */
    public function __construct(Client $client, $key, $secret)
    {
        $this->client = $client;
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @param $topic string
     * @param $args array
     * @param $kwargs
     */
    public function publish($topic, $args, $kwargs)
    {

    }
}