<?php

namespace Pvpcookie\ConsumerExample\Api\Data;

interface RestRequestMessageInterface
{
    /**
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * @param string $endpoint
     * @return void
     */
    public function setEndpoint(string $endpoint): void;
}
