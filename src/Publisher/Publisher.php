<?php

namespace Facile\CrossbarHTTPPublisherBundle\Publisher;

use Facile\CrossbarHTTPPublisherBundle\Exception\PublishRequestException;
use GuzzleHttp\Client;

/**
 * Class Publisher
 * @package Facile\CrossbarHTTPPublisherBundle\Publisher
 */
class Publisher
{
    private Client $client;
    private ?string $key;
    private ?string $secret;

    public function __construct(Client $client, ?string $key, ?string $secret)
    {
        $this->client = $client;
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @return array JSON decoded response
     * @throws \Exception
     */
    public function publish(string $topic, ?array $args = null, ?array $kwargs = null): array
    {
        $jsonBody = $this->prepareBody($topic, $args, $kwargs);

        try {
            $response = $this->client->post(
                '',
                [
                    'json' => $jsonBody,
                    'query' => $this->prepareSignature($jsonBody)
                ]
            );
        } catch (\Exception $e) {
            throw new PublishRequestException($e->getMessage(), 500, $e);
        }

        return json_decode($response->getBody(), true);
    }

    private function prepareBody(string $topic, ?array $args, ?array $kwargs): array
    {
        $body = [];

        $body['topic'] = $topic;

        if (null !== $args) {
            $body['args'] = $args;
        }

        if (null !== $kwargs) {
            $body['kwargs'] = $kwargs;
        }

        return $body;
    }

    private function prepareSignature(array $body): array
    {
        $query = [];

        $seq = mt_rand(0, 2 ** 12);
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $timestamp = $now->format("Y-m-d\TH:i:s.u\Z");

        $query['seq'] = $seq;
        $query['timestamp'] = $timestamp;

        if (null !== $this->key && null !== $this->secret) {

            $nonce = mt_rand(0, 2 ** 53);
            $signature = hash_hmac(
                'sha256',
                $this->key . $timestamp . $seq . $nonce . json_encode($body),
                $this->secret,
                true
            );

            $query['key'] = $this->key;
            $query['nonce'] = $nonce;
            $query['signature'] = strtr(base64_encode($signature), '+/', '-_');
        }

        return $query;
    }
}
