<?php

namespace Marek\Fraudator\Configuration;

use Marek\Fraudator\Configuration\Values\Jira;
use Marek\Fraudator\Configuration\Values\Jiras;
use Marek\Fraudator\Configuration\Values\Toggl;
use Marek\Fraudator\Configuration\Values\Worklog;
use Symfony\Component\Yaml\Yaml;

class Reader
{
    /**
     * @var string
     */
    protected $config;

    /**
     * Reader constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $this->parse($config);
    }

    protected function parse($config)
    {
        if (!file_exists($config)) {
            throw new \Exception('Config file does not exist');
        }

        $config = file_get_contents($config);

        return Yaml::parse($config);
    }

    public function getToggl()
    {
        return new Toggl(
            $this->config['fraudator']['toggl']['username'],
            $this->config['fraudator']['toggl']['password']
        );
    }

    public function getJira()
    {
        $jiras = $this->config['fraudator']['jiras'];

        $parsed = [];
        foreach ($jiras as $jira) {

            $parsed[] = new Jira(
                $jira['id'],
                $jira['url'],
                $jira['username'],
                $jira['password']
            );

        }

        return new Jiras($parsed);
    }

    public function getWorklog()
    {
        return new Worklog(
            $this->config['fraudator']['worklog']['start_date'],
            $this->config['fraudator']['worklog']['end_date']
        );
    }
}