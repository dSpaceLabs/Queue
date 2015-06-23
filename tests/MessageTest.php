<?php
/**
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\Message;

/**
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function test_setBody_and_getBody()
    {
        $body    = microtime();
        $message = new Message($body);
        $this->assertSame($body, $message->getBody());
    }
}
