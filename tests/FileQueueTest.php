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
}
