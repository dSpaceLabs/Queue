<?php
/**
 * @copyright 2015-2016 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\Broker;

/**
 */
class BrokerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddQueueMethod()
    {
        $queue = \Mockery::mock('Dspacelabs\Component\Queue\QueueInterface');
        $queue
            ->shouldReceive('getName')
            ->andReturn('unique.queue.name');
        $broker = new Broker();
        $broker->addQueue($queue);
        $this->assertSame($queue, $broker->get('unique.queue.name'));
    }

    /**
     * @expectedException Dspacelabs\Component\Queue\QueueException
     */
    public function testAddQueueWithSameName()
    {
        $queue = \Mockery::mock('Dspacelabs\Component\Queue\QueueInterface');
        $queue
            ->shouldReceive('getName')
            ->andReturn('unique.queue.name');
        $broker = new Broker();
        $broker->addQueue($queue);
        $broker->addQueue($queue); // Exception
    }

    /**
     * @expectedException Dspacelabs\Component\Queue\QueueException
     */
    public function testGetQueueNotFound()
    {
        $broker = new Broker();
        $broker->get('does.not.exist');
    }
}
