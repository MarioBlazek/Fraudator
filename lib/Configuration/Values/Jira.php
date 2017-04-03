<?php

namespace Marek\Fraudator\Configuration\Values;

class Jira
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var int
     */
    protected $id;

    /**
     * Jira constructor.
     *
     * @param int $id
     * @param string $url
     * @param string $username
     * @param string $password
     */
    public function __construct($id, $url, $username, $password)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}