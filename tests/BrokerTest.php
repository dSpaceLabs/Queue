<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\Broker;

/**
 */
class BrokerTest extends \PHPUnit_Framework_TestCase
{
    private $broker;

    protected function setUp()
    {
        $this->queue  = \Mockery::mock('Dspacelabs\Component\Queue\QueueInterface');
        $this->broker = new Broker();
    }

    /**
     * @expectedException Dspacelabs\Component\Queue\QueueException
     */
    public function test_addQueue()
    {
        $this->queue
            ->shouldReceive('getName')
            ->andReturn('unique.queue.name');

        // Make sure queue is added correctly
        $this->broker->addQueue($this->queue);
        $this->assertSame($this->queue, $this->broker->get('unique.queue.name'));

        // SHOULD throw an exception
        $this->broker->addQueue($this->queue);
    }

    /**
     * @expectedException Dspacelabs\Component\Queue\QueueException
     */
    public function test_getQueue()
    {
        $this->queue
            ->shouldReceive('getName')
            ->andReturn('unique.queue.name');
        $this->broker->addQueue($this->queue);
        $this->assertSame($this->queue, $this->broker->get('unique.queue.name'));

        // SHOULD throw an exception
        $this->broker->get('does.not.exist');
    }
}
