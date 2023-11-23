<?php
// File: app/code/Pvpcookie/ConsumerExample/Ui/DataProvider/QueueStatsDataProvider.php

namespace Pvpcookie\ConsumerExample\Ui\DataProvider;

use Magento\MysqlMq\Model\QueueManagement;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Pvpcookie\ConsumerExample\Model\Queue;

class QueueStatsDataProvider extends AbstractDataProvider
{
    protected $queueModel;
    protected $statusModel;

    public function __construct(
        Queue $queueModel,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->queueModel = $queueModel;
    }

    public function getCollection()
    {
        $data = [
            ...$this->queueModel->getMessages('ddg'),
            ...$this->queueModel->getMessages('')
        ];
        return array_map(function ($item) {
            return [
                'message_id' => $item['message_id'],
                'name' => $item['topic_name'],
                'message' => $item['body'],
                'status' => $this->formateStatus($item['status']),
                'tries' => $item['retries']
            ];
        }, $data);
    }

    public function getData()
    {
        $collection = $this->getCollection();
        return [
            'totalRecords' => count($collection),
            'items' => $collection,
        ];
    }

    public function formateStatus($status)
    {
        switch ($status) {
            case QueueManagement::MESSAGE_STATUS_NEW:
                return 'Pending';
            case QueueManagement::MESSAGE_STATUS_IN_PROGRESS:
                return 'Processing';
            case QueueManagement::MESSAGE_STATUS_COMPLETE;
                return 'Complete';
            case QueueManagement::MESSAGE_STATUS_ERROR:
                return 'Error';
            case QueueManagement::MESSAGE_STATUS_RETRY_REQUIRED:
                return 'Retry Required';
            case QueueManagement::MESSAGE_STATUS_TO_BE_DELETED:
                return 'To Be Deleted';
            default:
                return 'Unknown';
        }
    }
}
