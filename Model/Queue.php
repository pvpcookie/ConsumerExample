<?php

namespace Pvpcookie\ConsumerExample\Model;

use Magento\MysqlMq\Model\QueueManagement;
use Magento\MysqlMq\Model\ResourceModel\Queue as MagentoQueue;
class Queue extends MagentoQueue
{
    public function getMessages($queueName, $limit = null)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from(
                ['queue_message' => $this->getMessageTable()],
                [
                    QueueManagement::MESSAGE_TOPIC => 'topic_name',
                    QueueManagement::MESSAGE_BODY => 'body'
                ]
            )->join(
                ['queue_message_status' => $this->getMessageStatusTable()],
                'queue_message.id = queue_message_status.message_id',
                [
                    QueueManagement::MESSAGE_QUEUE_RELATION_ID => 'id',
                    QueueManagement::MESSAGE_QUEUE_ID => 'queue_id',
                    QueueManagement::MESSAGE_ID => 'message_id',
                    QueueManagement::MESSAGE_STATUS => 'status',
                    QueueManagement::MESSAGE_UPDATED_AT => 'updated_at',
                    QueueManagement::MESSAGE_NUMBER_OF_TRIALS => 'number_of_trials'
                ]
            )->join(
                ['queue' => $this->getQueueTable()],
                'queue.id = queue_message_status.queue_id',
                [QueueManagement::MESSAGE_QUEUE_NAME => 'name']
            )->where('queue.name LIKE ?', '%'.$queueName.'%')
            ->order(['queue_message_status.updated_at ASC', 'queue_message_status.id ASC']);

        // Apply filters
        if (!empty($filters)) {
            foreach ($filters as $field => $value) {
                $select->where($field . ' LIKE ?', '%' . $value . '%');
            }
        }

        if ($limit) {
            $select->limit($limit);
        }

        return $connection->fetchAll($select);
    }
}
