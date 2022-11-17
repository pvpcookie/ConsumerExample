<?php

namespace Pvpcookie\ConsumerExample\Controller\Adminhtml\Queue;


use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Pvpcookie\ConsumerExample\Api\Data\MessageMetricsInterface;
use Pvpcookie\ConsumerExample\Model\SequenceSequenceMessage;

class Fibonacci implements ActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Pvpcookie_ConsumerExample::config_consumer';

    const TOPIC_NAME = 'pvpcookie.fibonacci.calculate';

    const SIZE = 5000;


    /* @var Json  */
    protected Json $_json;

    /* @var PublisherInterface  */
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
     * @param Context $context
     */
    public function __construct(
        PublisherInterface $publisher,
        Json $json,
        RequestInterface $request,
        Context $context,
    ){
        $this->_json = $json;
        $this->_request = $request;
        $this->_publisher = $publisher;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        if ($this->_request->isAjax()) {
            try {
                $message = new SequenceSequenceMessage();
                $message->setSequenceCount(self::SIZE);
                $this->_publisher->publish(
                    self::TOPIC_NAME,
                    $message
                );
                return;
            } catch (Exception $e) {
                $this->_request->setBody($this->_json->serialize([
                    'error' => 0,
                    'message' => __('Something went wrong while adding record(s) to queue. Error: '.$e->getMessage())
                ]));
                return;
            }
        }
        return die('Not allowed');
    }

}
