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
     * @param bool|string $hostname
     */
    public function createPublisher(
        string $protocol,
        string $host,
        int $port,
        string $path,
        ?string $key,
        ?string $secret,
        $hostname,
        bool $ignoreSsl = false
    ): Publisher {
        $config = [];

        $config['base_url'] = sprintf(
            '%s://%s:%s%s',
            $protocol,
            $host,
            $port,
            $path
        );
        $config['base_uri'] = $config['base_url']; // Guzzle 6 compat

        $config['headers']['Content-Type'] = 'application/json';

        if (null !== $hostname) {
            $config['headers']['Host'] = $hostname;
        }

        if ($ignoreSsl) {
            $config['verify'] = false;
        }

        if (defined('GuzzleHttp\ClientInterface::VERSION')) {
            @trigger_error('Guzzle versions before 7 are deprecated.', E_USER_DEPRECATED);
        }

        $guzzleClient = new GuzzleClient($config);

        return new Publisher($guzzleClient, $key, $secret);
    }
}
