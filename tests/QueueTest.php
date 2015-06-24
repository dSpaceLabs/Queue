<?php
/**
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\Queue;

/**
 */
class QueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function test_getName()
    {
        $queue = \Mockery::mock('Dspacelabs\Component\Queue\Queue')
            ->makePartial();
        $this->assertNull($queue->getName());
    }
}
