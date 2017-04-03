<?php

namespace Marek\Fraudator\Toggl;

use Marek\Fraudator\Configuration\Values\Toggl as TogglConfiguration;
use Marek\Fraudator\Configuration\Values\Worklog;
use Marek\Fraudator\Http\Client;
use Marek\Fraudator\Http\Request;
use Marek\Fraudator\Toggl\Values\TimeEntries;
use Marek\Fraudator\Toggl\Values\TimeEntry;

class Toggl
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var TogglConfiguration
     */
    protected $toggl;

    /**
     * Toggl constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client, TogglConfiguration $toggl)
    {
        $this->client = $client;
        $this->toggl = $toggl;
    }

    public function getTimeEntries(Worklog $worklog)
    {
        $url = "https://www.toggl.com/api/v8/time_entries?start_date=%start_date%&end_date=%end_date%";

        $url = str_replace("%start_date%", urlencode($worklog->getStart()->format('c')), $url);
        $url = str_replace("%end_date%", urlencode($worklog->getEnd()->format('c')), $url);

        $request = new Request(Request::GET, $url, null, $this->getAuth());


        $response = $this->client->execute($request);

        if ($response->isOk()) {

            return $this->parse($response->getData());

        }

        // 2017-03-27T11:00:24+00:00

        // 2017-03-26T22:00:00+0000
    }

    public function getClient(TimeEntry $timeEntry)
    {
        $url = "https://www.toggl.com/api/v8/projects/%project_id%";
        $url = str_replace("%project_id%", $timeEntry->pid, $url);

        $request = new Request(Request::GET, $url, null, $this->getAuth());

        $response = $this->client->execute($request);

        if (!$response->isOk()) {
            throw new \Exception();
        }

        $data = $response->getData();
        $clientId = $data['data']['cid'];

        $timeEntry->setClientId($clientId);

        return $timeEntry;

//        $url = "https://www.toggl.com/api/v8/clients/%client_id%";
//        $url = str_replace("%project_id%", $clientId, $url);
//
//        $request = new Request(Request::GET, $url, null, $this->getAuth());
//
//        $response = $this->client->execute($request);
//        var_dump($response);
//        if (!$response->isOk()) {
//            throw new \Exception();
//        }
//
//        var_dump($response->getData());
    }

    /**
     * @param array $result
     *
     * @return TimeEntries
     */
    protected function parse($result)
    {
        $entries = [];
        foreach ($result as $entry) {

            $entries[] = new TimeEntry($entry);

        }

        return new TimeEntries($entries);
    }

    protected function getAuth()
    {
        return "{$this->toggl->getUsername()}:{$this->toggl->getPassword()}";
    }
}