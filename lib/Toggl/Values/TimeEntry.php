<?php

namespace Marek\Fraudator\Toggl\Values;

/**
 * @property int $id
 * @property int $wid
 * @property int $pid
 * @property boolean $billable
 * @property \DateTime $start
 * @property \DateTime $stop
 * @property int $duration
 * @property string $description
 * @property boolean $duronly
 * @property \DateTime $at
 * @property int $uid
 */
class TimeEntry
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $wid;

    /**
     * @var int
     */
    protected $pid;

    /**
     * @var boolean
     */
    protected $billable;

    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var \DateTime
     */
    protected $stop;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var boolean
     */
    protected $duronly;

    /**
     * @var \DateTime
     */
    protected $at;

    /**
     * @var int
     */
    protected $uid;

    /**
     * @var int
     */
    protected $clientId;

    /**
     * TimeEntry constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $property => $value) {

//            if (in_array($property, ['start', 'end', 'at'])) {
//                $this->$property = \DateTime::createFromFormat('c', $value);
//            } else {
                $this->$property = $value;
//            }
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new \Exception("property not found");
    }

    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }
}
