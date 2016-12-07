<?php
/**
 * @copyright 2015 dSpace Labs LLC
 * @license MIT
 */

namespace Dspacelabs\Component\Queue;

/**
 * Message Interface
 *
 * Messages are sent to a queue and a queue will return messages
 */
interface MessageInterface extends \Serializable
{
    /**
     * Set the contents of the message
     *
     * @param mixed $body
     * @return self
     */
    public function setBody($body);

    /**
     * Retrieve the contents of the body
     *
     * @return mixed
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
