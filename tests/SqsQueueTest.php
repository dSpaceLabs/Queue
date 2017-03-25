<?php
/**
 * @copyright 2016 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue\Tests;

use Dspacelabs\Component\Queue\SqsQueue;
use Dspacelabs\Component\Queue\Message;

/**
 */
class SqsQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testPublish()
    {
        $sqsClient = \Mockery::mock('Aws\Sqs\SqsClient');
        $sqsClient
            ->shouldReceive('sendMessage')
            ->andReturn(array(
                'MD5OfMessageAttributes' => 'testMD5OfMessageAttributes',
                'MD5OfMessageBody'       => 'testMD5OfMessageBody',
                'MessageId'              => 'testMessageId',
            ));
        $queue = new SqsQueue($sqsClient, 'http://dspace.com', 'queue.test');

        $message = \Mockery::mock('Dspacelabs\Component\Queue\Message')->makePartial();
        $message
            ->shouldReceive('addAttribute')
            ->with('MD5OfMessageAttributes', 'testMD5OfMessageAttributes');
        $message
            ->shouldReceive('addAttribute')
            ->with('MD5OfMessageBody', 'testMD5OfMessageBody');
        $message
            ->shouldReceive('addAttribute')
            ->with('MessageId', 'testMessageId');

        $queue->publish($message);

        \Mockery::close();
    }

    public function testReceive()
    {
        $message = new Message();

        $sqsClient = \Mockery::mock('Aws\Sqs\SqsClient');
        $sqsClient
            ->shouldReceive('receiveMessage')
            ->andReturn(
                array(
                    'Messages' => array(
                        array(
                            'Body'          => base64_encode(serialize($message)),
                            'ReceiptHandle' => 'testReceiptHandle',
                        ),
                    )
                )
            );
        $queue   = new SqsQueue($sqsClient, 'http://dspace.com', 'queue.test');
        $message = $queue->receive();

        \Mockery::close();
    }

    public function testReceiveWithNoMessages()
    {
        $sqsClient = \Mockery::mock('Aws\Sqs\SqsClient');
        $sqsClient
            ->shouldReceive('receiveMessage')
            ->andReturn(null);
        $queue     = new SqsQueue($sqsClient, 'http://dspace.com', 'queue.test');
        $message   = $queue->receive();
        $this->assertNull($message);
        \Mockery::close();
    }

    public function testDelete()
    {
        $sqsClient = \Mockery::mock('Aws\Sqs\SqsClient');
        $sqsClient->shouldReceive('deleteMessage');
        $queue = new SqsQueue($sqsClient, 'http://dspace.com', 'queue.test');

        $message = new Message();
        $message->addAttribute('ReceiptHandle', 'testReceiptHandle');

        $queue->delete($message);
    }
}
