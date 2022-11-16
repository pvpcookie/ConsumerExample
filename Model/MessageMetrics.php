<?php

namespace Pvpcookie\ConsumerExample\Model;

class MessageMetrics
{

    /**
     * @var int
     */
    private $startTime;

    /**
     * @var int
     */
    private $startMemory;

    /**
     * @var int
     */
    private $endTime;

    /**
     * @var int
     */
    private $endMemory;

    private function getPeakMemoryUsage()
    {
        return round(memory_get_peak_usage() / 1024, 2);
    }

    private function getMemoryUsage()
    {
        return round(memory_get_usage() / 1024, 2);
    }

    public function start(): void
    {
        $this->startTime = microtime(true);
        $this->startMemory = $this->getMemoryUsage();
    }

    public function stop(): void
    {
        $this->endTime = microtime(true);
        $this->endMemory = $this->getMemoryUsage();
    }

    private function getExecutionTime(): float
    {
        return round($this->endTime - $this->startTime, 2);
    }

    private function getMemoryUsageDelta()
    {
        return $this->endMemory - $this->startMemory;
    }

    private function getPeakMemoryUsageDelta()
    {
        return $this->getPeakMemoryUsage() - $this->startMemory;
    }

    public function getMetrics(): array
    {
           return [
                'execution_time' => $this->getExecutionTime(),
                'memory_usage' => $this->getMemoryUsageDelta(),
                'peak_memory_usage' => $this->getPeakMemoryUsageDelta()
            ];
    }

}
