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
        $this->client->sendMessage(array(
            'MessageBody' => $message->getBody(),
            'QueueUrl'    => $this->queueUrl,
        ));
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
        if (null === $message->getHeader('ReceiptHandle')) {
            throw new CacheException('Message does not contain ReceiptHandle');
        }

        $result = $this->client->deleteMessage(array(
            'ReceiptHandle' => $message->getHeader('ReceiptHandle'),
            'QueueUrl'      => $this->queueUrl,
        ));
    }
}
