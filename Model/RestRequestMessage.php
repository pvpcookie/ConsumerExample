<?php

namespace Pvpcookie\ConsumerExample\Model;

use Pvpcookie\ConsumerExample\Api\Data\RestRequestMessageInterface;

class RestRequestMessage implements RestRequestMessageInterface
{

    /**
     * @var string
     */
    private string $endpoint;


    public function getEndpoint(): string
    {
         return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
}
