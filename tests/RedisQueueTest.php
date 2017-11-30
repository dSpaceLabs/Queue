<?php
/**
 * @copyright 2017 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\RedisQueue;
use Dspacelabs\Component\Queue\Message;

/**
 */
class RedisQueueTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    protected function setUp()
    {
        try {
            $this->client = new \Predis\Client();
            $this->client->connect();
        } catch (\Exception $e) {
            $this->markTestSkipped('No Redis Connection');
        }
    }

    protected function tearDown()
    {
        $this->client = null;
    }

    public function testAll()
    {
        $client = new \Predis\Client();
        $queue = new \Dspacelabs\Component\Queue\RedisQueue($client, 'test');
        $message = 'Hello World';
        $queue->publish($message);

        $message = $queue->receive();
        $this->assertNotNull($message);
        $this->assertInstanceOf('\Dspacelabs\Component\Queue\Message', $message);
        $this->assertSame('Hello World', $message->getBody());
    }
}
