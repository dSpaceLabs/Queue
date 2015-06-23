Meta Document
=============

## Summary

Queueing allows a developer to send a message to a queue and then have a
consumer pull down that message for processing.

## Examples

```
# Publishing a message
$message = new Message($body);
$queue->publish($message);
```

```
# Receiving a message
$message = $queue->receive();
```

```
# Get the queue that you want
$queue = $broker->getQueue('resize.image');

# Create a message
$message = new Message($body);

# Publish message
$queue->publish($message);

# Receive message
$message = $queue->receive();
```
