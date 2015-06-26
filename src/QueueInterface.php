<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Queue Interface
 */
interface QueueInterface
{
    /**
     * Returns the name of the Queue
     *
     * @return string
     */
    public function getName();

    /**
     * Publishes a message to the queue
     *
     * @param MessageInterface $message
     */
    public function publish(MessageInterface $message);

    /**
     * Returns a message from the queue to be processed
     *
     * @return MessageInterface|null
     */
    public function receive();

    /**
     * If the queue supports this, it will delete the message from
     * queue
     *
     * @param MessageInterface $message
     */
    public function delete(MessageInterface $message);
}
