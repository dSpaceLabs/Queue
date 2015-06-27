<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

use Aws\Sqs\SqsClient;

/**
 * Amazon SQS Queue
 *
 * Requires:
 * - Amazon PHP SDK
 */
class SqsQueue extends Queue
{
    /**
     * @var SqsClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $queueUrl;

    /**
     * @param SqsClient $client
     *   The SqsClient comes from the Amazon PHP SDK, see the documentation that
     *   comes from amazon on how to configure you SQS Client
     * @param string $queueUrl
     *   Each SQS Queue is given a unique URL, this must be passed in
     * @param string $name
     *   Anything that you wish to name this queue, it does not have to match
     *   the name in amazon
     */
    public function __construct(SqsClient $client, $queueUrl, $name)
    {
        $this->client   = $client;
        $this->queueUrl = $queueUrl;
        $this->name     = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function publish(MessageInterface $message)
    {
        $result = $this->client->sendMessage(array(
            'MessageBody' => $message->getBody(),
            'QueueUrl'    => $this->queueUrl,
        ));

        $message->addAttribute('MD5OfMessageAttributes', $result['MD5OfMessageAttributes']);
        $message->addAttribute('MD5OfMessageBody', $result['MD5OfMessageBody']);
        $message->addAttribute('MessageId', $result['MessageId']);

        return $message;
    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
        $result = $this->client->receiveMessage(array(
            'QueueUrl' => $this->queueUrl,
        ));

        if ($result) {
            return new Message($result['Messages'][0]['Body'], array(
                'ReceiptHandle' => $result['Messages'][0]['ReceiptHandle'],
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(MessageInterface $message)
    {
        if (null === $message->getAttribute('ReceiptHandle')) {
            throw new QueueException('Message does not contain ReceiptHandle');
        }

        $result = $this->client->deleteMessage(array(
            'ReceiptHandle' => $message->getAttribute('ReceiptHandle'),
            'QueueUrl'      => $this->queueUrl,
        ));
    }
}
