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
     * Returns a message from the queue
     *
     * If there are any messages in the queue it will return a MessageInterface
     * and if there are NO messages in the queue, this SHOULD return null
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

    /**
     * Purges ALL messages from the queue
     */
    //public function purge();
}
