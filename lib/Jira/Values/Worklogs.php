<?php

namespace Marek\Fraudator\Jira\Values;

class Worklogs
{
    /**
     * @var array
     */
    protected $worklogs;

    public function __construct(array $worklogs)
    {
        $this->worklogs = $worklogs;
    }

    public function getAllNames()
    {
        return array_map(
            function($worklog) {
                return $worklog['issue']['key'];
            },
            $this->worklogs
        );
    }

    public function getDatesForIssue($issue)
    {
        return array_map(
            function($worklog) use ($issue) {

                if ($issue === $worklog['issue']['key']) {
                    return $worklog['dateStarted'];
                }

            },
            $this->worklogs
        );
    }

    public function getTimeForIssue($issue, $date)
    {
        $times = array_map(
            function($worklog) use ($issue, $date) {

                if ($issue === $worklog['issue']['key'] && $date === $worklog['dateStarted']) {
                    return $worklog['billedSeconds'];
                }

            },
            $this->worklogs
        );

        $times = array_filter($times);

        if (empty($times)) {
            return 0;
        }

        $time = array_values($times)[0];

        return $time / 60 / 60;
    }

    public function getSumForDay(\DateTime $date)
    {
        $times = array_map(
            function($worklog) use ($date) {

                $dateStarted = $worklog['dateStarted'];
                $dateStarted = explode("T", $dateStarted);
                $dateStarted = \DateTime::createFromFormat('Y-m-d', $dateStarted[0]);
                $dateStarted->setTime(0,0);

                if ($dateStarted->format('y-m-d') === $date->format('y-m-d')) {
                    return $worklog['billedSeconds'];
                }

            },
            $this->worklogs
        );

        $times = array_filter($times);
        $times = array_values($times);
        $time = array_sum($times);

        return $time / 60 / 60;
    }
}