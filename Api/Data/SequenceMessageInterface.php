<?php

namespace Pvpcookie\ConsumerExample\Api\Data;

interface SequenceMessageInterface
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
