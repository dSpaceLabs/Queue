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
    public function test_attributes()
    {
        $attributes = array(
            'content-type' => 'application/json',
        );

        $message = new Message('', $attributes);
        $this->assertCount(1, $message->getAttributes());
        $this->assertSame($attributes, $message->getAttributes());

        $message->addAttribute('exchange', 'testing');
        $this->assertCount(2, $message->getAttributes());

        $this->assertSame('application/json', $message->getAttribute('content-type'));
        $this->assertSame('testing', $message->getAttribute('exchange'));
        $this->assertNull($message->getAttribute('doesNotExist'));
    }
}
