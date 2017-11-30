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
    protected static $queue;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;

        if (!self::$queue) {
            self::$queue = new \SplQueue();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function publish($message)
    {
        if (!$message instanceof MessageInterface) {
            $message = new Message($message);
        }

        self::$queue->enqueue($message);
    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
        if (!self::$queue->isEmpty()) {
            return self::$queue->dequeue();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(MessageInterface $message)
    {
        // not used by this class
    }

    /**
     * {@inheritDoc}
     */
    public function purge()
    {
        throw new QueueException('Not Implemented');
    }

    /**
     * {@inheritDoc}
     */
    public function getNumberOfMessages()
    {
        throw new QueueException('Not Implemented');
    }
}
