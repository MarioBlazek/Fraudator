<?php

namespace Marek\Fraudator\Jira;

use Marek\Fraudator\Configuration\Values\Jiras;
use Marek\Fraudator\Http\Client;
use Marek\Fraudator\Http\Request;
use Marek\Fraudator\Toggl\Values\TimeEntry;
use Marek\Fraudator\Configuration\Values\Jira as JiraConfig;

class Jira
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Jiras
     */
    protected $jiras;

    public function __construct(Client $client, Jiras $jiras)
    {
        $this->client = $client;
        $this->jiras = $jiras;
    }

    public function handleWorklog(TimeEntry $entry)
    {
        /** @var \Marek\Fraudator\Configuration\Values\Jira $jira */
        $jira = $this->jiras->getJiraById($entry->getClientId());

        $result = $this->getJiraNameAndIssue($entry);
        $issue = $this->getIssue($jira, $result[1]);

        if ($issue) {
            throw new \Exception();
        }

        $this->postNewWorkLog($jira, $result[1], $result[2], $entry);
    }

    protected function getIssue(JiraConfig $jira, $issue)
    {
        $url = "/rest/api/2/issue/%issue_id%";
        $url = str_replace('%issue_id%', $issue, $url);

        $url = $jira->getUrl() . $url;

        $request = new Request(Request::GET, $url, null, "{$jira->getUsername()}:{$jira->getPassword()}");

        $response = $this->client->execute($request);

        if ($response->isOk()) {
            return false;
        }

        return true;
    }

    protected function postNewWorkLog(JiraConfig $jira, $issue, $comment, TimeEntry $entry)
    {
        $url = "/rest/api/2/issue/%issue_id%/worklog";
        $url = str_replace('%issue_id%', $issue, $url);

        $url = $jira->getUrl() . $url;

        var_dump($issue);
        var_dump($comment);

        $date = \DateTime::createFromFormat(\DateTime::ISO8601, $entry->start);

        $formatedDate = $date->format('Y-m-d').'T'.$date->format('h:i:s.vO');

        $data = [
            'comment' => $comment,
            'started' => $formatedDate,
            'timeSpentSeconds' => $entry->duration,
        ];

//        var_dump($data);
//        die;
        $request = new Request(Request::POST, $url, $data, "{$jira->getUsername()}:{$jira->getPassword()}");

        $response = $this->client->execute($request);

        var_dump($response);
    }

    protected function getJiraNameAndIssue(TimeEntry $timeEntry)
    {
        preg_match('/^([A-Za-z\-1-9]+)[ ]*([\w ]+)/sm', $timeEntry->description, $result);

        return $result;
    }
}