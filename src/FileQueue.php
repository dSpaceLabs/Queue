<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Stores files on local disk for use as a queue
 */
class FileQueue extends Queue
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $name
     *   Name of the queue
     * @param string $path
     *   The path to where files are stored
     */
    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = realpath($path);
    }

    /**
     * {@inheritDoc}
     */
    public function publish($message)
    {
        if (!$message instanceof MessageInterface) {
            $message = new Message($message);
        }

        $content = serialize($message);
        $fname   = hash('sha256', $content.microtime());
        $path    = sprintf('%s/%s.%s.message', $this->path, $this->name, $fname);
        $file    = new \splFileObject($path, 'w');
        $file->fwrite($content);
    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
        // fetch from disk
        $paths = glob(sprintf('%s/%s.*.message', $this->path, $this->name));
        foreach ($paths as $path) {
            if (0 === filesize($path)) {
                // Nothing in this file, skip and move on
                unlink($path);
                continue;
            }
            $message = unserialize(file_get_contents($path));
            $message->addAttribute('path', $path);
            return $message;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(MessageInterface $message)
    {
        if (!$message->getAttribute('path')) {
            throw new QueueException('Message does not have the "path" attribute');
        }

        unlink($message->getAttribute('path'));
    }

    /**
     * {@inheritDoc}
     */
    public function purge()
    {
        throw new QueueException('Not Implemented');
    }

    /**
     * {@inheritDoc}
     */
    public function getNumberOfMessages()
    {
        throw new QueueException('Not Implemented');
    }
}
