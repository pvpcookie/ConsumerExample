<?php

namespace Pvpcookie\ConsumerExample\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class ConnectorLogHandler extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::DEBUG;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/consumer.log';
}
