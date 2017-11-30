<?php
/**
 * @copyright 2016 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\FileQueue;
use Dspacelabs\Component\Queue\Message;

/**
 */
class FileQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $message = new Message('Hello World');
        $queue   = new FileQueue('test', sys_get_temp_dir());
        $queue->publish($message);
        while ($message = $queue->receive()) {
            $queue->delete($message);
        }
    }

    public function testZeroSizeMessage()
    {
        $file = sprintf('%s/%s.0000.message', sys_get_temp_dir(), 'test');
        touch($file);
        $queue = new FileQueue('test', sys_get_temp_dir());
        $msg = $queue->receive();
        $this->assertNull($msg);
    }

    /**
     * This will test to make sure that you can publish a string without having to
     * wrap it in a Message object
     */
    public function testPublishString()
    {
        $message = 'Hello World';
        $queue   = new FileQueue('test', sys_get_temp_dir());
        $queue->publish($message);
        $message = $queue->receive();
        $this->assertNotNull($message);
        $this->assertInstanceOf('\Dspacelabs\Component\Queue\Message', $message);
        $this->assertSame('Hello World', $message->getBody());
        $queue->delete($message);
    }
}
