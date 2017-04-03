<?php

namespace Marek\Fraudator\Configuration\Values;

class Jiras
{
    /**
     * @var Jira[]
     */
    protected $jiras;

    /**
     * Jiras constructor.
     *
     * @param array $jiras
     */
    public function __construct(array $jiras)
    {
        $this->jiras = $jiras;
    }

    /**
     * @return Jira[]
     */
    public function getJiras()
    {
        return $this->jiras;
    }

    /**
     * @param int $clientId
     *
     * @return Jira
     *
     * @throws \Exception
     */
    public function getJiraById($clientId)
    {
        $jira = array_filter(
            $this->jiras,
            function(Jira $jira) use ($clientId){
                if ($clientId == $jira->getId()) {
                    return true;
                }
            }
        );

        if (empty($jira)) {
            throw new \Exception();
        }

        return $jira[0];
    }
}