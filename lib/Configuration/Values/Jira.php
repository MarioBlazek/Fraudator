<?php

namespace Marek\Fraudator\Configuration\Values;

class Jira extends Toggl
{
    /**
     * @var string
     */
    protected $url;

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
        parent::__construct($username, $password);
        $this->url = $url;
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}