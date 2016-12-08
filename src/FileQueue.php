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
    public function publish(MessageInterface $message)
    {
        $fname = time();
        $path  = sprintf('%s/%s.%s.message', $this->path, $this->name, $fname);
        $file  = new \splFileObject($path, 'w');
        $file->fwrite(serialize($message));
    }

    /**
     * {@inheritDoc}
     */
    public function receive()
    {
        // fetch from disk
        $paths = glob(sprintf('%s/%s.*.message', $this->path, $this->name));
        foreach ($paths as $path) {
            $file = new \splFileObject($path);
            if (0 === $file->getSize()) {
                // Nothing in this file, skip and move on
                unlink($path);
                continue;
            }
            $message = unserialize($file->fread($file->getSize()));
            $message->addAttribute('path', $path);
            return $message;
        }
    }

    /**
     * {@inheirDoc}
     */
    public function delete(MessageInterface $message)
    {
        if (!$message->getAttribute('path')) {
            throw new QueueException('Message does not have the "path" attribute');
        }

        unlink($message->getAttribute('path'));
    }
}
