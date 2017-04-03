<?php

namespace Marek\Fraudator\Http;

class Response
{
    const HTTP_OK = 200;

    const HTTP_SERVER_ERROR = 500;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $code;

    /**
     * Response constructor.
     *
     * @param string $code
     * @param string $data
     */
    public function __construct($code, $data)
    {
        $this->code = $code;
        $this->data = empty($data) ? [] : json_decode($data, true);
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        return $this->code == self::HTTP_OK;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}