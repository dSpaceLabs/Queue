<?php
/**
 * @copyright 2015-2016 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\Message;

/**
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testBody()
    {
        // random string
        $body    = microtime();
        $message = new Message($body);
        $this->assertSame($body, $message->getBody());

        // Array
        $body = array(
            'k' => 'v'
        );
        $message = new Message($body);
        $this->assertSame($body, $message->getBody());

        // Send a serialized body
        $serializedBody = serialize($body);
        $message = new Message($serializedBody);
        $this->assertSame($serializedBody, $message->getBody());
        $this->assertSame($body, unserialize($message->getBody()));
    }

    public function testAttributes()
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
