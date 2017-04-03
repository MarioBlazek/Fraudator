<?php

namespace Marek\Fraudator\Http;

class Request
{
    const GET = 'GET';

    const POST = 'POST';

    /**
     * @var string
     */
    protected $auth;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $url;

    /**
     * Request constructor.
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param string $auth
     */
    public function __construct($method, $url, $data, $auth)
    {
        $this->method = $method;
        $this->url = $url;
        $this->data = $data;
        $this->auth = $auth;
    }

    /**
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->method === self::POST;
    }

    /**
     * @return bool
     */
    public function hasAuth()
    {
        return !is_null($this->auth);
    }
}