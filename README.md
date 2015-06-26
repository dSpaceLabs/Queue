Queue Component
===============

[![Build Status](https://travis-ci.org/dSpaceLabs/Queue.svg?branch=master)](https://travis-ci.org/dSpaceLabs/Queue)

---

General queue library for PHP, ability to support various different queueing
systems.

## Installation

```
composer install dspacelabs/queue
```

## Usage

```php
<?php

$message = new Message($body);
$queue->publish($message);
```

## Using the SqsQueue

Install amazon php sdk.

```php
```

## Change Log

See [CHANGELOG.md].

## License

Copyright (c) 2015 dSpace Labs LLC

See [LICENSE] for full license.

[CHANGELOG.md]: https://github.com/dSpaceLabs/Queue/blob/master/CHANGELOG.md
[LICENSE]: https://github.com/dSpaceLabs/Queue/blob/master/LICENSE
