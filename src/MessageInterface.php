<?php
/**
 */

namespace Dspacelabs\Component\Queue;

/**
 */
interface MessageInterface
{
    /**
     * Set the contents of the message
     *
     * @param string $body
     * @return self
     */
    public function setBody($body);

    /**
     * Retrieve the contents of the body
     *
     * @return string
     */
    public function getBody();

    /**
     * Retrieve all attributes
     *
     * @return array
     */
    public function getAttributes();

    /**
     * add a attribute
     *
     * @param string $attribute
     * @param string $value
     */
    public function addAttribute($attribute, $value);

    /**
     * Replace all attributes
     *
     * @param array $attributes
     * @return self
     */
    public function setAttributes($attributes);

    /**
     * @param string $attribute
     * @return string|null
     */
    public function getAttribute($attribute);
}
