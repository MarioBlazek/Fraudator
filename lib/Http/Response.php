<?php

namespace Marek\Fraudator\Http;

class Response
{
    const HTTP_OK = 200;

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