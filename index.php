<?php

require_once __DIR__ . "/vendor/autoload.php";

$reader = new \Marek\Fraudator\Configuration\Reader(__DIR__ . "/config.yml");

$client = new Marek\Fraudator\Http\Client();

//$toggl = new \Marek\Fraudator\Toggl\Toggl($client, $reader->getToggl());
//$entries = $toggl->getTimeEntries($reader->getWorklog());

//$timeEntry = $toggl->getClient($entries->getTimeEntries()[0]);

$jira = new \Marek\Fraudator\Jira\Jira($client, $reader->getJira());
$jira->getWorklog();