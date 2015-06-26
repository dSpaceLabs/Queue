<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Within this library a broker is used to keep track of queues that are added
 * and can be retrieved later.
 */
interface BrokerInterface
{
    /**
     * Retrieves the queue given the name
     *
     * @param string $name
     *   The name of the queue
     * @throws QueueException
     *   If the queue could not be found, an exception is thrown
     * @return QueueInterface
     */
    public function get($name);

    /**
     * Adds queue to a pool that can be used to get a queue out at a later
     * time
     *
     * @param QueueInterface $queue
     * @throws QueueException
     *   If queue already exists or could not be added for some other reason
     */
    public function addQueue(QueueInterface $queue);
}
