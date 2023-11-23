<?php

namespace Pvpcookie\ConsumerExample\Controller\Adminhtml\Queue;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\MysqlMq\Model\QueueManagement;
use Pvpcookie\ConsumerExample\Model\Queue;

class Delete extends Action
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
        // Get the message ID from the request
        $messageId = $this->getRequest()->getParam('id');
        $this->queueModel->changeStatus([$messageId],QueueManagement::MESSAGE_STATUS_TO_BE_DELETED );
        $this->queueModel->deleteMarkedMessages();
        $this->messageManager->addSuccessMessage(__(
            "Message {$messageId} has been successfully marked for deleted."
        ));

        return $this->resultRedirectFactory->create()
            ->setPath('pvpcookie_consumerexample/queue/status');
    }
}
