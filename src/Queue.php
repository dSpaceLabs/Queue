<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 */
abstract class Queue implements QueueInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
