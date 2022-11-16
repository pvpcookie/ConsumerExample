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
use Pvpcookie\ConsumerExample\Model\Message;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Push extends Command
{

    /**
     * @var string
     */
    const NAME_ARGUMENT = "size";

    /**
     * Queue topic for command
     */
    const TOPIC_NAME = 'pvpcookie.fibonacci.calculate';

    /**
     * @var Json
     */
    protected Json $_json;

    /**
     * @var PublisherInterface
     */
    protected PublisherInterface $_publisher;

    /**
     * @var RequestInterface $request
     */
    private RequestInterface $_request;

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
        Json $json,
        RequestInterface $request
    ){
        $this->_json = $json;
        $this->_request = $request;
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
            $size = (int) $input->getArgument(self::NAME_ARGUMENT);
            echo "Size: $size".PHP_EOL;
            $message = new Message();
            $message->setSequenceCount($size);
            $this->_publisher->publish(
                self::TOPIC_NAME,
                $message
            );
            $output->writeln("Sequence size: {$size} pushed to ". self::TOPIC_NAME );
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
        $this->setName("pvpcookie:fibonacci:push");
        $this->setDescription("Push fibonacci job to Queue");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::REQUIRED, "fibonacci sequence size"),
        ]);
        parent::configure();
    }
}

