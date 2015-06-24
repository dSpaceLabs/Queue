<?php
/**
 */

namespace Dspacelabs\Component\Queue;

/**
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
        $this->body = $body;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody()
    {
        return $this->body;
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

    public function getAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }
    }
}
