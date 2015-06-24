Component\Queue
===============

## Goals

I want to be able to use job queues for a small project and scale it out once my
application needs it without too much hassle. I would like to use MySQL as a
queue for messages and have a AWS SQS queue as well that can both use the same
consumers.

## Definitions

* Publisher - Sends messages to a queue
* Consumer  - Processes messages from a queue
* Message   - Is sent to a queue, is pulled from a queue
* Queue     - Where messages are stored
* Broker    - Contains 0 to n queues, factory for queues

## Key Concepts

## Interfaces

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 * Any exceptions that are thrown must throw this exception
 */
class QueueException extends \Exception
{
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 * Used when a name is invalid
 */
class InvalidArgumentException extends QueueException
{
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 * Broker keeps a collection of various queues, brokers do not care the type
 * of queue (database, rabbit, SQS, etc). It just keeps track of the known
 * queues.
 */
interface BrokerInterface
{
    /**
     * @param string $name
     *   The name of the queue.
     * @return QueueInterface
     */
    public function get($name);

    /**
     * @param QueueInterface $queue
     */
    public function addQueue(QueueInterface $queue);
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 * Queue can be any type of queue, for example a SQS queue, we don't
 * really care, we just want the name of the queue and we want to be
 * able publish messages to the queue and to receive a message from
 * the queue
 */
interface QueueInterface
{
    /**
     * @return string
     *   Returns the name of the queue
     */
    public function getName();

    /**
     * Publishes a message to the queue
     *
     * @param MessageInterface $message
     * @return boolean
     */
    public function publish(MessageInterface $message);

    /**
     * @return MessageInterface|null
     *   Returns a MessageInterface if there is a message in the the queue or
     *   if no messages in the queue, it returns null
     */
    public function receive();

    /**
     * @param MessageInterface $message
     */
    public function delete(MessageInterface $message);
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 * Messages are used to send to a queue and are returned from a queue object.
 * Messages can have attributes, as an example, SQS calls these attributes, but
 * in some other systems, they are called headers. When using AMQP you can set
 * headers such as Content-Type, which within this library are attributes.
 */
interface MessageInterface
{
    /**
     * What is stored in the database
     *
     * @param string $body
     * @return self
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @param string $header
     * @param string $value
     * @return self
     */
    public function addAttribute($attribute, $value);

    /**
     * @param array $headers
     * @return self
     */
    public function setAttributes(array $attribute);
}
```
