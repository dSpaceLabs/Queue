<?php
/**
 */

namespace Dspacelabs\Component\Queue;

use Aws\Sqs\SqsClient;

/**
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
     * @param string $queueUrl
     * @param string $name
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
            throw new CacheException('Message does not contain ReceiptHandle');
        }

        $result = $this->client->deleteMessage(array(
            'ReceiptHandle' => $message->getAttribute('ReceiptHandle'),
            'QueueUrl'      => $this->queueUrl,
        ));
    }
}
