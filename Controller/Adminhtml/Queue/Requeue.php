<?php


namespace Pvpcookie\ConsumerExample\Controller\Adminhtml\Queue;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Pvpcookie\ConsumerExample\Model\Queue;

class Requeue extends Action
{
    protected $queueModel;

    public function __construct(
        Context $context,
        Queue $queueModel
    ) {
        $this->queueModel = $queueModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $messageId = $this->getRequest()->getParam('id');
        $this->queueModel->pushBackForRetry($messageId);
        $this->messageManager->addSuccessMessage(__(
            "Message {$messageId} has been successfully requeued."
        ));

        return $this->resultRedirectFactory->create()
            ->setPath('pvpcookie_consumerexample/queue/status');
    }
}
