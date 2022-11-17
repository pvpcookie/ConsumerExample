<?php

namespace Pvpcookie\ConsumerExample\Model\Queue;

use \Psr\Log\LoggerInterface;
use Pvpcookie\ConsumerExample\Api\Data\SequenceMessageInterface;
use Pvpcookie\ConsumerExample\Logger\Logger;
use Pvpcookie\ConsumerExample\Model\MessageMetrics;

class FibonacciCalculationConsumer
{

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $_logger;

    /**
     * @var MessageMetrics
     */
    private MessageMetrics $_messageMetrics;

    /**
     * @param LoggerInterface $logger
     * @param MessageMetrics $messageMetrics
     */
    public function __construct(
        Logger $logger,
        MessageMetrics $messageMetrics
    ) {
        $this->_logger = $logger;
        $this->_messageMetrics = $messageMetrics;
    }

    /**
     * @param SequenceMessageInterface $message
     * @return void
     */
    public function process(SequenceMessageInterface $message)
    {
        try{
            $this->_messageMetrics->start();
            $this->execute($message->getSequenceCount());
            $this->_messageMetrics->stop();
            $this->_logger->info(
                sprintf(
                    'FibonacciCalculationConsumer Count: %s',
                    $message->getSequenceCount()
                )
            );
            $this->_logger->info(
                sprintf(
                    'FibonacciCalculationConsumer Metrics: %s',
                    json_encode($this->_messageMetrics->getMetrics())
                )
            );

        }catch (\Exception $e){
            //logic to catch and log errors
            $this->_logger->critical($e->getMessage());
        }
    }

    /**
     * @param $sequence
     * @return void
     */
    private function execute($sequence)
    {
        for ($counter = 0; $counter < $sequence; $counter++){
            $this->fibonacci($counter);
        }
    }

    /**
     * @param $n
     * @return int
     */
    private function fibonacci($n): int
    {
        if ($n == 0) {
            return 0;
        } else if ($n == 1) {
            return 1;
        } else {
            return ($this->fibonacci($n-1) +
                    $this->fibonacci($n-2));
        }
    }

}
