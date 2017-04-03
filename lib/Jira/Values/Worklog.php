<?php

namespace Marek\Fraudator\Jira\Values;

use Marek\Fraudator\Toggl\Values\TimeEntry;

class Worklog
{
    /**
     * @var string
     */
    protected $issue;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var int
     */
    protected $duration;

    /**
     * Worklog constructor.
     *
     * @param TimeEntry $entry
     */
    public function __construct(TimeEntry $entry)
    {
        $this->parseDescription($entry->description);
        $this->start = $entry->start;
        $this->duration = $entry->duration;
    }

    /**
     * @param string $description
     */
    protected function parseDescription($description)
    {
        preg_match('/^([A-Za-z\-1-9]+)[ ]*([\w ]+)/sm', $description, $result);

        $this->issue = $result[1];
        $this->comment = $result[2];
    }

    /**
     * @return string
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getStart()
    {
        $date = \DateTime::createFromFormat(\DateTime::ISO8601, $this->start);

        return $date->format('Y-m-d').'T'.$date->format('h:i:s.vO');
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'comment' => $this->comment,
            'started' => $this->getStart(),
            'timeSpentSeconds' => $this->duration,
        ];
    }
}