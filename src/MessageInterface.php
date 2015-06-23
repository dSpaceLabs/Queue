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
     * Retrieve all headers
     *
     * @return array
     */
    public function getHeaders();

    /**
     * add a header
     *
     * @param string $header
     * @param string $value
     */
    public function addHeader($header, $value);

    /**
     * Replace all headers
     *
     * @param array $headers
     * @return self
     */
    public function setHeaders($headers);
}
