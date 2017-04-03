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

    public function getJiraById($clientId)
    {
        var_dump($this->jiras);
        $jira = array_filter(
            $this->jiras,
            function(Jira $jira) use ($clientId){
                if ($clientId == $jira->getId()) {
                    return true;
                }
            }
        );
        var_dump($jira);
        if (empty($jira)) {
            throw new \Exception();
        }

        return $jira[0];
    }
}