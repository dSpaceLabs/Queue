<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\StandardQueue;

/**
 */
class StandardQueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StandardQueue
     */
    private $queue;

    /**
     */
    protected function setUp()
    {
        $this->queue = new StandardQueue('queue.test.standard');
    }

    /**
     */
    public function test_getName()
    {
        $this->assertSame('queue.test.standard', $this->queue->getName());
    }

    /**
     */
    public function test_publish()
    {
        $message = \Mockery::mock('Dspacelabs\Component\Queue\MessageInterface');
        $this->queue->publish($message);
        $this->assertSame($message, $this->queue->receive());
    }

    /**
     */
    public function test_receive()
    {
        $this->assertNull($this->queue->receive());

        $messageOne = \Mockery::mock('Dspacelabs\Component\Queue\MessageInterface')
            ->makePartial()
            ->shouldReceive('getBody')
            ->andReturn('one')
            ->getMock();
        $this->queue->publish($messageOne);

        $messageTwo = \Mockery::mock('Dspacelabs\Component\Queue\MessageInterface')
            ->makePartial()
            ->shouldReceive('getBody')
            ->andReturn('one')
            ->getMock();
        $this->queue->publish($messageTwo);

        $this->assertSame($messageOne, $this->queue->receive());
        $this->assertSame($messageTwo, $this->queue->receive());
        $this->assertNull($this->queue->receive());
    }

    /**
     */
    public function test_delete()
    {
        $message = \Mockery::mock('Dspacelabs\Component\Queue\MessageInterface');

        $this->assertNull($this->queue->delete($message));
    }
}
