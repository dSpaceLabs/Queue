<?php
/**
 * @copyright 2015-2016 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Message
 */
class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @param string $body
     * @param array  $attributes
     */
    public function __construct($body = '', array $attributes = array())
    {
        $this->setBody($body);
        $this->setAttributes($attributes);
    }

    /**
     * {@inheritDoc}
     */
    public function setBody($body)
    {
        $this->body = serialize($body);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody()
    {
        return unserialize($this->body);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function addAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * {$inheritDoc}
     */
    public function getAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function hasAttribute($attribute)
    {
        return isset($this->attributes[$attribute]);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(
            array(
                $this->body,
                $this->attributes
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($message)
    {
        list(
            $this->body,
            $this->attributes
        ) = unserialize($message);
    }
}
