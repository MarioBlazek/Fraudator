<?php

namespace Marek\Fraudator\Toggl\Values;

class TimeEntries
{
    /**
     * @var TimeEntry[]
     */
    protected $timeEntries;

    /**
     * TimeEntries constructor.
     *
     * @param array $timeEntries
     */
    public function __construct(array $timeEntries)
    {
        $this->timeEntries = $timeEntries;
    }

    /**
     * @return TimeEntry[]
     */
    public function getTimeEntries()
    {
        return $this->timeEntries;
    }

    public function getCount()
    {
        return count($this->timeEntries);
    }

    public function getBillableTimeEntries()
    {
        return array_filter(
            $this->timeEntries,
            function (TimeEntry $timeEntry) {
                if ($timeEntry->billable) {
                    return $timeEntry;
                }
            }
        );
    }

    public function getBillableCount()
    {
        $billable = array_filter(
            $this->timeEntries,
            function (TimeEntry $timeEntry) {
                if ($timeEntry->billable) {
                    return $timeEntry;
                }
            }
        );

        return count($billable);
    }
}