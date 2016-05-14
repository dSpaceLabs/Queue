Queue Component
===============

[![Build Status](https://travis-ci.org/dSpaceLabs/Queue.svg?branch=master)](https://travis-ci.org/dSpaceLabs/Queue)

---

General queue library for PHP, ability to support various different queueing
systems.

## Installation

```
composer require dspacelabs/queue "^0.1@dev"
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
/**
 * $message will be the message that was published. `->receive()` can be put
 * into a foreach loop if you want to continue to process the queue until
 * all the messages are processed, use a for loop in you only want to process
 * a small number of the messages
 */
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

## Using the Broker

If you have multiple queues, you can use the Broker which will just help you
manage the various queues you have.

```php
<?php

use Dspacelabs\Component\Queue\Broker;

$broker = new Broker();

// I assume you already have a queue
$broker->addQueue($queue);

// `quque.name` is the name given to the queue you created
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
