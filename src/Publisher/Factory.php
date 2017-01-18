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
     * @param string $protocol
     * @param string $host
     * @param int $port
     * @param string $path
     * @param string $key
     * @param string $secret
     * @param bool|string $hostname
     * @param bool $ignoreSsl
     * @return Publisher
     */
    public function createPublisher($protocol, $host, $port, $path, $key, $secret, $hostname, $ignoreSsl)
    {
        $config = array();

        $config['base_url'] = sprintf(
            '%s://%s:%s%s',
            $protocol,
            $host,
            $port,
            $path
        );

        $config['defaults']['headers']['Content-Type'] = 'application/json';

        if (null !== $hostname) {
            $config['defaults']['headers']['Host'] = $hostname;
        }

        if ($ignoreSsl) {
            $config['defaults']['verify'] = false;
        }

        $guzzleClient = new GuzzleClient($config);

        return new Publisher($guzzleClient, $key, $secret);
    }
}
