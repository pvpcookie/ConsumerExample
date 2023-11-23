<?php

namespace Pvpcookie\ConsumerExample\Model;

use Pvpcookie\ConsumerExample\Api\Data\SequenceMessageInterface;

class SequenceMessage implements SequenceMessageInterface
{

    /**
     * @var int
     */
    private int $sequenceCount;

    /**
     * @return int
     */
    public function getSequenceCount(): int
    {
       return $this->sequenceCount;
    }

    /**
     * @param int $sequenceCount
     * @return void
     */
    public function setSequenceCount(int $sequenceCount): void
    {
        $this->sequenceCount = $sequenceCount;
    }
}
