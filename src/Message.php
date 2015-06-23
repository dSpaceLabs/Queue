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
    protected $headers;

    /**
     * @param string $body
     * @param array  $headers
     */
    public function __construct($body = '', array $headers = array())
    {
        $this->setBody($body);
        $this->setHeaders($headers);
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
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }
}
