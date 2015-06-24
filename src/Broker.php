<?php
/**
 */

namespace Dspacelabs\Component\Queue;

/**
 */
class Broker implements BrokerInterface
{
    /**
     * @var array
     */
    protected $queues = array();

    /**
     * {@inheritDoc}
     */
    public function get($name)
    {
        if (isset($this->queues[$name])) {
            return $this->queues[$name];
        }

        throw new QueueException('Queue not found');
    }

    /**
     * {@inheritDoc}
     */
    public function addQueue(QueueInterface $queue)
    {
        if (isset($this->queues[$queue->getName()])) {
            throw new QueueException('Queue already exists');
        }

        $this->queues[$queue->getName()] = $queue;
    }
}
