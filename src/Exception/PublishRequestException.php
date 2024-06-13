<?php

namespace Facile\CrossbarHTTPPublisherBundle\Exception;

/**
 * Class PublishRequestException
 * @package Facile\CrossbarHTTPPublisherBundle\Exception
 */
class PublishRequestException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, ?\Exception $previous = null)
    {
        $finalMessage = sprintf(
            'Error POSTing request to Crossbar: %s',
            $message
        );

        parent::__construct($finalMessage, $code, $previous);
    }
}
