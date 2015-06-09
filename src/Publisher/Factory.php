<?php

namespace Facile\CrossbarHTTPPublisherBundle\Publisher;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Factory
 * @package Facile\CrossbarHTTPPublisherBundle\Publisher
 */
class Factory
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var bool|string
     */
    private $hostname;

    /**
     * @param $host
     * @param $port
     * @param $key
     * @param $secret
     * @param bool $hostname
     */
    public function __construct($host, $port, $key, $secret, $hostname = false)
    {
        $this->host = $host;
        $this->port = $port;
        $this->key = $key;
        $this->secret = $secret;
        $this->hostname = $hostname;
    }

    /**
     * @return Publisher
     */
    public function createPublisher()
    {
        $guzzleClient = new GuzzleClient($this->getGuzzleConfigArray());
        return new Publisher($guzzleClient, $this->key, $this->secret);
    }

    /**
     * @return array
     */
    private function getGuzzleConfigArray()
    {
        $config = array();

        $config['base_url'] = $this->host . ':' . $this->port;

        if(isset($this->hostname)) {
            $config['defaults']['headers']['Host'] = $this->hostname;
        }

        return $config;
    }
}