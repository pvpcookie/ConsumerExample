<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pvpcookie\ConsumerExample\Console\Command;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Pvpcookie\ConsumerExample\Model\RestRequestMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RestPush extends Command
{

    /**
     * @var string
     */
    const ENDPOINT_ARGUMENT = "endpoint";

    /**
     * Queue topic for command
     */
    const TOPIC_NAME = 'pvpcookie.rest.get';

    /**
     * @var Json
     */
    protected Json $_json;

    /**
     * @var PublisherInterface
     */
    protected PublisherInterface $_publisher;

    /**
     * Order constructor.
     *
     * @param PublisherInterface $publisher
     * @param Json $json
     * @param RequestInterface $request
     * @param Context $context
     */
    public function __construct(
        PublisherInterface $publisher,
        Json $json
    ){
        $this->_json = $json;
        $this->_publisher = $publisher;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {

        try {
            $endpoint = $input->getArgument(self::ENDPOINT_ARGUMENT);
            $message = new RestRequestMessage();
            $message->setEndpoint($endpoint);
            $this->_publisher->publish(
                self::TOPIC_NAME,
                $message
            );
            $output->writeln("Endpoint: {$endpoint} pushed to ". self::TOPIC_NAME );
            return;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            return;
        }

    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("pvpcookie:http:push");
        $this->setDescription("Push rest request job to Queue");
        $this->setDefinition([
            new InputArgument(self::ENDPOINT_ARGUMENT, InputArgument::REQUIRED, "Endpoint"),
        ]);
        parent::configure();
    }
}

