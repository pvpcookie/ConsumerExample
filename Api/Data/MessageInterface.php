<?php

namespace Pvpcookie\ConsumerExample\Api\Data;

interface MessageInterface
{
    /**
     * @return int
     */
    public function getSequenceCount(): int;

    /**
     * @param int $sequenceCount
     * @return void
     */
    public function setSequenceCount(int $sequenceCount): void;
}
