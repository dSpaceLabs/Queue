<?php
/**
 * @copyright 2015-2016 dSpace Labs LLC
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
     * Add an attribute
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
     * Get value of attribute, if attribute does not exist on message this
     * returns null
     *
     * @param string $attribute
     * @return string|null
     */
    public function getAttribute($attribute);
}
