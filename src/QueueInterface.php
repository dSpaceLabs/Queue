<?php
/**
 */

namespace Dspacelabs\Component\Queue;

/**
 */
interface QueueInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param MessageInterface $message
     */
    public function publish(MessageInterface $message);

    /**
     * @return MessageInterface|null
     */
    public function receive();

    /**
     * @param MessageInterface $message
     */
    public function delete(MessageInterface $message);
}
