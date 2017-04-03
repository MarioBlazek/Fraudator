<?php

namespace Marek\Fraudator\Configuration\Values;

class Worklog
{
    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var \DateTime
     */
    protected $end;

    /**
     * Worklog constructor.
     *
     * @param string $start
     * @param string $end
     */
    public function __construct($start, $end)
    {
        $timeZone = new \DateTimeZone('UTC');
        $this->start = \DateTime::createFromFormat('d-m-Y', $start);
        $this->start->setTime(0,0);
        $this->start->setTimezone($timeZone);
        $this->end = \DateTime::createFromFormat('d-m-Y', $end);
        $this->end->setTime(0,0);
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}