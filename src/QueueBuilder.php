<?php
/**
 * @copyright 2016 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Used to initialize a new queue
 *
 * Usage:
 * ```php
 * $builder = new QueueBuilder();
 * $queue = $builder
 *   ->setType(QueueBuilder::TYPE_FILE)
 *   ->setName('test')
 *   ->setArguments(array('path' => '/tmp'))
 *   ->getQueue();
 * ```
 */
class QueueBuilder
{
    const TYPE_SQS      = 'sqs';
    const TYPE_STANDARD = 'standard';
    const TYPE_FILE     = 'file';

    protected $queueType;
    protected $arguments;
    protected $name;

    public function setQueueType($type)
    {
        $this->queueType = $type;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function getQueue()
    {
        if (empty($this->name)) {
            throw new QueueException('Must set queue name');
        }
        if (empty($this->type)) {
            throw new QueueException('Must set queue type');
        }
        switch ($this->type) {
        case (self::TYPE_SQS):
            if (empty($this->arguments['client'])) {
                throw new QueueException('Must include "client" argument');
            }
            if (empty($this->arguments['queue_url'])) {
                throw new QueueException('Must include "queue_url" argument');
            }
            return new SqsQueue(
                $this->arguments['client'],
                $this->arguments['queue_url'],
                $this->name
            );
            break;
        case (self::TYPE_STANDARD):
            return new StandardQueue($this->name);
            break;
        case (self::TYPE_FILE):
            if (empty($this->arguments['path'])) {
                throw new QueueException('Must include "path" argument');
            }
            return new FileQueue(
                $this->name,
                $this->arguments['path']
            );
            break;
        }
    }
}
