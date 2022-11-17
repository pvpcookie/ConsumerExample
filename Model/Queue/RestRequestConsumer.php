<?php

namespace Pvpcookie\ConsumerExample\Model\Queue;

use Psr\Log\LoggerInterface;
use Pvpcookie\ConsumerExample\Api\Data\RestRequestMessageInterface;
use Laminas\Http\Client;
use Pvpcookie\ConsumerExample\Logger\Logger;
use Pvpcookie\ConsumerExample\Model\MessageMetrics;

class RestRequestConsumer
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
     * @var Client
     */
    private Client $_client;

    /**
     * @param Logger $logger
     * @param MessageMetrics $messageMetrics
     * @param Client $client
     */
    public function __construct(
        Logger $logger,
        MessageMetrics $messageMetrics,
        Client $client
    ) {
        $this->_logger = $logger;
        $this->_messageMetrics = $messageMetrics;
        $this->_client = $client;
    }

    /**
     * @param RestRequestMessageInterface $message
     * @return void
     */
    public function process(RestRequestMessageInterface $message)
    {
        try{
            $this->_messageMetrics->start();
            $this->execute($message->getEndpoint());
            $this->_messageMetrics->stop();
            $this->_logger->info(
                sprintf(
                    'RestRequestConsumer Endpoint: %s',
                    $message->getEndpoint()
                )
            );
            $this->_logger->info(
                sprintf(
                    'RestRequestConsumer Metrics: %s',
                    json_encode($this->_messageMetrics->getMetrics())
                )
            );

        }catch (\Exception $e){
            //logic to catch and log errors
            $this->_logger->critical($e->getMessage());
        }
    }

    /**
     * @param $endpoint
     * @return void
     */
    private function execute($endpoint)
    {

        $client = new Client();
        $client->setUri('https://webhook.site/71656c47-a9d1-47c2-8bcf-efbd72a6df7a');
        $client->setOptions([
            'maxredirects' => 0,
            'timeout'      => 30,
        ]);
        $response = $client->send();
        $this->_logger->info(
            sprintf(
                'RestRequestConsumer Response: %s',
                $response->getBody()
            )
        );
    }


}
