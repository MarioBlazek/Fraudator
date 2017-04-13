<?php

namespace Marek\Fraudator\Jira;

use Marek\Fraudator\Configuration\Values\Jiras;
use Marek\Fraudator\Http\Client;
use Marek\Fraudator\Http\Request;
use Marek\Fraudator\Jira\Values\Worklog;
use Marek\Fraudator\Jira\Values\Worklogs;
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

    /**
     * Jira constructor.
     *
     * @param Client $client
     * @param Jiras $jiras
     */
    public function __construct(Client $client, Jiras $jiras)
    {
        $this->client = $client;
        $this->jiras = $jiras;
    }

    public function handleWorklog(TimeEntry $entry)
    {
        /** @var \Marek\Fraudator\Configuration\Values\Jira $jira */
        $jira = $this->jiras->getJiraById($entry->getClientId());

        $worklog = new Worklog($entry);

        $issue = $this->getIssue($jira, $worklog);

        if ($issue) {
            throw new \Exception();
        }

        $this->postNewWorkLog($jira, $worklog);
    }

    public function getWorklog()
    {
        $baseUrl = "jira_url";
        $url = "/rest/tempo-timesheets/3/worklogs?dateFrom=%date_from%&dateTo=%date_to%&username=mario.b@netgen.hr";

        $dateFrom = \DateTime::createFromFormat('d-m-Y', '27-03-2017');
        $dateTo = \DateTime::createFromFormat('d-m-Y', '31-03-2017');

        $url = str_replace('%date_from%', $dateFrom->format('Y-m-d'), $url);
        $url = str_replace('%date_to%', $dateTo->format('Y-m-d'), $url);

        $url = $baseUrl . $url;

        $request = new Request(Request::GET, $url, null, "user:password");

        $response = $this->client->execute($request);

        return new Worklogs($response->getData());
    }

    /**
     * @param JiraConfig $jira
     * @param Worklog $worklog
     *
     * @return bool
     */
    protected function getIssue(JiraConfig $jira, Worklog $worklog)
    {
        $url = "/rest/api/2/issue/%issue_id%";
        $url = str_replace('%issue_id%', $worklog->getIssue(), $url);

        $url = $jira->getUrl() . $url;

        $request = new Request(Request::GET, $url, null, "{$jira->getUsername()}:{$jira->getPassword()}");

        $response = $this->client->execute($request);

        if ($response->isOk()) {
            return false;
        }

        return true;
    }

    /**
     * @param JiraConfig $jira
     * @param Worklog $worklog
     *
     */
    protected function postNewWorkLog(JiraConfig $jira, Worklog $worklog)
    {
        $url = "/rest/api/2/issue/%issue_id%/worklog";
        $url = str_replace('%issue_id%', $worklog->getIssue(), $url);

        $url = $jira->getUrl() . $url;


        $request = new Request(Request::POST, $url, $worklog->toArray(), "{$jira->getUsername()}:{$jira->getPassword()}");

        $response = $this->client->execute($request);
    }
}
