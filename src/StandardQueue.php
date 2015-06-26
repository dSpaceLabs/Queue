<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Standard Queue uses the SplQueue
 */
class StandardQueue extends Queue
{
    /**
     * @var \SplQueue
     */
    protected $queue;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name  = $name;
        $this->queue = new \SplQueue();
    }

    /**
     * {@inheritDoc}
     */
    public function publish(MessageInterface $message)
    {
        $this->queue->enqueue($message);
    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
        if (!$this->queue->isEmpty()) {
            return $this->queue->dequeue();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(MessageInterface $message)
    {
        // not used by this class
    }
}
