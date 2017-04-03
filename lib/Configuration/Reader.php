<?php

namespace Marek\Fraudator\Configuration;

use Marek\Fraudator\Configuration\Values\Jira;
use Marek\Fraudator\Configuration\Values\Jiras;
use Marek\Fraudator\Configuration\Values\Toggl;
use Marek\Fraudator\Configuration\Values\Worklog;
use Symfony\Component\Config\Definition\Processor;
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

    /**
     * @param string $config
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function parse($config)
    {
        if (!file_exists($config)) {
            throw new \Exception('Config file does not exist');
        }


        $configuration = Yaml::parse(file_get_contents($config));

        $yamlConfiguration = new Configuration();
        $procesor = new Processor();

        return $procesor->processConfiguration($yamlConfiguration, [$configuration]);
    }

    /**
     * @return Toggl
     */
    public function getToggl()
    {
        return new Toggl(
            $this->config['toggl']['username'],
            $this->config['toggl']['password']
        );
    }

    /**
     * @return Jiras
     */
    public function getJira()
    {
        $jiras = $this->config['jiras'];

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

    /**
     * @return Worklog
     */
    public function getWorklog()
    {
        return new Worklog(
            $this->config['worklog']['start_date'],
            $this->config['worklog']['end_date']
        );
    }
}