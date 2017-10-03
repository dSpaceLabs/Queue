<?php
/**
 * @copyright 2015-2016 dSpace Labs LLC
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
     * @api
     * @return string
     */
    public function getName();

    /**
     * Publishes a message to the queue
     *
     * @api
     * @param MessageInterface|string $message
     */
    public function publish($message);

    /**
     * Returns a message from the queue
     *
     * If there are any messages in the queue it will return a MessageInterface
     * and if there are NO messages in the queue, this SHOULD return null
     *
     * @api
     * @return MessageInterface|null
     */
    public function receive();

    /**
     * If the queue supports this, it will delete the message from
     * queue
     *
     * @api
     * @param MessageInterface $message
     * @throws QueueException
     *   If the message cannot be deleted, an exception is thrown
     */
    public function delete(MessageInterface $message);

    /**
     * Purges ALL messages from the queue
     *
     * @throws QueueException
     *   If the queue cannot be purged, this exception is thrown
     */
    //public function purge();
}
