<?php
/**
 * @copyright 2017 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

use Predis\Client;

/**
 * Used for a Redis Queue
 */
class RedisQueue extends Queue
{
    /**
     * @var \Predis\Client
     */
    protected $client;

    /**
     * @param \Predis\Client $client
     *   Predis Client that is used to publish messages to queue
     * @param string $name
     *   The name of this queue
     */
    public function __construct(Client $client, $name)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function publish($message)
    {
        if (!$message instanceof MessageInterface) {
            $message = new Message($message);
        }

        $this->client->rpush($this->name, serialize($message));
    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
        $message = $this->client->lpop($this->name);
        if ($message) {
            $message = unserialize($message);
        }

        return $message;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(MessageInterface $message)
    {
        // Messages are removed by the receive method
    }
}
