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
    private $protocol;

    /**
     * @var string
     */
    private $path;

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
     * @var bool
     */
    private $ignoreSsl;

    /**
     * @param $protocol
     * @param $host
     * @param $path
     * @param $port
     * @param $key
     * @param $secret
     * @param $hostname
     */
    public function __construct($protocol, $host, $port, $path, $key, $secret, $hostname, $ignoreSsl)
    {
        $this->protocol = $protocol;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->key = $key;
        $this->secret = $secret;
        $this->hostname = $hostname;
        $this->ignoreSsl = $ignoreSsl;
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

        $config['base_url'] = sprintf(
            '%s://%s:%s%s',
            $this->protocol,
            $this->host,
            $this->port,
            $this->path
        );

        $config['defaults']['headers']['Content-Type'] = 'application/json';

        if(!is_null($this->hostname)) {
            $config['defaults']['headers']['Host'] = $this->hostname;
        }
        if($this->ignoreSsl) {
            $config['defaults']['verify'] = false;
        }

        return $config;
    }
}