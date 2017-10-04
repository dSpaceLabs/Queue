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
    public function publish($message)
    {
        if (!$message instanceof MessageInterface) {
            $message = new Message($message);
        }

        $parameters = [
            'MessageBody' => base64_encode(serialize($message)),
            'QueueUrl'    => $this->queueUrl,
        ];

        /**
         * Fixes issues for SQS FIFO queues
         * @see https://github.com/dSpaceLabs/Queue/issues/5
         */
        if ($message->hasAttribute('MessageDeduplicationId') && $message->hasAttribute('MessageGroupId')) {
            $parameters['MessageDeduplicationId'] = $message->getAttribute('MessageDeduplicationId');
            $parameters['MessageGroupId']         = $message->getAttribute('MessageGroupId');
        }

        $result = $this->client->sendMessage($parameters);

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

        if (!empty($result['Messages'][0])) {
            $message = unserialize(base64_decode($result['Messages'][0]['Body']));
            $message->addAttribute('ReceiptHandle', $result['Messages'][0]['ReceiptHandle']);

            return $message;
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
