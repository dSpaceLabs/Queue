Queue Component [![Build Status](https://travis-ci.org/dSpaceLabs/Queue.svg?branch=master)](https://travis-ci.org/dSpaceLabs/Queue)
===============

General queue library for PHP, ability to support various different queue
systems.

## Installation

```
composer require dspacelabs/queue
```

## Usage

```php
<?php

use Dspacelabs\Component\Queue\Message;

// Publishing messages to a queue
$message = new Message($body);
$queue->publish($message);
/**
 * This will publish a message to the queue you created, the $body can be
 * anything you want.
 */

// Receive messages
$message = $queue->receive();
$body    = $message->getBody();
// ... Process Data ...
/**
 * $message will be the message that was published. `->receive()` can be put
 * into a foreach loop if you want to continue to process the queue until
 * all the messages are processed, use a for loop in you only want to process
 * a small number of the messages
 */

/**
 * Once you are done processing a message, it needs to be deleted from the queue
 */
$queue->delete($message);
```

## Messages, Queues, Broker

Messages are published to queues. When you receive a message from a queue, you
will be interacting with this class.

Queues are where you publish your messages to. For example, a Queue could be an
AWS SQS, RabbitMQ, or any other queue you can think of.

The Broker helps you keep track of queues. So instead of having 100 different
queue objects all over, you just add all those to the Broker and let the Broker
sort them out. You just get the ones you need.

## Using the FileQueue

The FileQueue will store messages on disk and is good to use for local
development.

Messages are stored on disk in the file naming format "name.timestamp.message"
so you can have multiple file queues share the same directory.


```php
<?php

use Dspacelabs\Component\Queue\FileQueue;
use Dspacelabs\Component\Queue\Message;

$queue = new FileQueue('queue.name', '/tmp/');
$queue->publish(new Message('Hello World!'));

// ...

$message = $queue->receive();
$body = $message->getBody(); // $body === "Hello World!"
$queue->delete($message);
```

## Using the SqsQueue

Requires Amazon PHP SDK.

```bash
php composer.phar require aws/aws-sdk-php
```

```php
<?php

use Aws\Credentials\Credentials;
use Aws\Sqs\SqsClient;
use Dspacelabs\Component\Queue\SqsQueue;

$credentials = new Credentials($accessKey, $secretKey);
$client = new SqsClient(
    array(
        'version'     => 'latest',
        'region'      => 'us-east-1',
        'credentials' => $credentials,
    )
);

$queue  = new SqsQueue($client, $queueUrl, $name);
```

## Using the StandardQueue

The standard queue is mainly used for testing. Once this is setup you
can quickly test your workflow. Keep in mind that this has some drawbacks
mainly that the messages are not persisted.

```php
<?php

// First you need to setup the Queue
$queue = new \Dspacelabs\Component\Queue\StandardQueue('queue.name');

// Create a message that will be sent to the queue
$message = new \Dspacelabs\Component\Queue\Message('Hello World A');

// Publish the message
$queue->publish($message);

// Consume all messages
/** @var Message $msg **/
while ($msg = $queue->receive()) {
    // process message
    // ...
    // Delete the Message from the queu
    $queue->delete($msg);
}
```

NOTE: When using the StandardQueue, you do not need to delete the message like
in this example `$queue->delete($msg);` HOWEVER there are some queues out there
that support this.

## Using the Broker

If you have multiple queues, you can use the Broker which will just help you
manage the various queues you have. For example, you could be using multiple
SQS queues and want a single point to access those at. The Broker will help you
with this.

It's also important to point out that the broker supports all queue types in
this library. So you can use the SQS Queue, Standard Queue, or a custom queue
that you made.

```php
<?php

use Dspacelabs\Component\Queue\Broker;

$broker = new Broker();

// I assume you already have a queue
$broker->addQueue($queue);

// `queue.name` is the name given to the queue you created
// I assume you already have a `$message` created
$broker->get('queue.name')->publish($message);
$broker->get('queue.other')->publish($messageOther);
```

## Change Log

See [CHANGELOG.md].

## License

Copyright (c) 2015-2016 dSpace Labs LLC

See [LICENSE] for full license.

[CHANGELOG.md]: https://github.com/dSpaceLabs/Queue/blob/master/CHANGELOG.md
[LICENSE]: https://github.com/dSpaceLabs/Queue/blob/master/LICENSE
