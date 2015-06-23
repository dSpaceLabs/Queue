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

    /**
     */
    public function test_headers()
    {
        $headers = array(
            'content/type' => 'application/json',
        );

        $message = new Message('', $headers);
        $this->assertCount(1, $message->getHeaders());
        $this->assertSame($headers, $message->getHeaders());

        $message->addHeader('exchange', 'testing');
        $this->assertCount(2, $message->getHeaders());
    }
}
