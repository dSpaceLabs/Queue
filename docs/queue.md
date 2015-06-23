Component\Queue
===============

## Definitions

* Publisher - Sends messages to a queue
* Consumer - Processes messages from a queue
* Message - Is sent to a queue, is pulled from a queue
* Queue - Where messages are stored
* Exchange
* Broker - Contains 0 to n queues, factory for queues

## Key Concepts

## Interfaces

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 */
class QueueException
{
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 */
interface BrokerInterface
{
    public function getQueue($name);
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 */
interface QueueInterface
{
    public function getName();
    public function publish(MessageInterface $message);
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 */
interface ConsumerInterface
{
    public function process(MessageInterface $message);
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 */
interface PublisherInterface
{
}
```

```php
<?php

namespace Dspacelabs\Component\Queue;

/**
 */
interface MessageInterface
{
    public function setBody($body);

    public function getBody();

    public function getHeaders();

    public function setHeader($header, $value);

    public function setHeaders($headers);
}
```
