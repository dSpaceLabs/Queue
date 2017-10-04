<?php
/**
 * @copyright 2017 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 */
class RabbitQueue extends Queue
{
    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    protected $connection;

    /**
     * @var
     */
    protected $channel;

    /**
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     * @param string $name
     *   The name of this queue
     */
    public function __construct(AMQPStreamConnection $connection, $name)
    {
        $this->connection = $connection;
        $this->name       = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function publish($message)
    {
        if (!$message instanceof MessageInterface) {
            $message = new Message($message);
        }

    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function delete(MessageInterface $message)
    {
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
