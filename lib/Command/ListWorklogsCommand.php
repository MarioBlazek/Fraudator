<?php

namespace Marek\Fraudator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Marek\Fraudator\Configuration\Reader;
use Marek\Fraudator\Http\Client;

use Marek\Fraudator\Jira\Jira;

class ListWorklogsCommand extends Command
{
    protected function configure()
    {
        $this->setName("marek:fraudator:list");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reader = new Reader(__DIR__ . "/../../config.yml");
        $client = new Client();

        $worklogConfig = $reader->getWorklog();

        $jira = new Jira($client, $reader->getJira());
        $worklogs = $jira->getWorklog();

        $issues = $worklogs->getAllNames();
        $issues = array_unique($issues);
        $issues = array_filter($issues);

        $headers = ['Issues'];
        $rows = [];

        foreach ($issues as $issue) {

            $dates = $worklogs->getDatesForIssue($issue);
            $dates = array_filter($dates);
            $dates = array_values($dates);

            $startDate = $worklogConfig->getStart();
            $startDateWhile = clone $startDate;
            $endDate = $worklogConfig->getEnd();

            $row = [$issue];

            while ($startDateWhile <= $endDate) {

                if (!in_array($startDateWhile->format('d.m.Y'), $headers)) {
                    $headers[] = $startDateWhile->format('d.m.Y');
                }

                $value = '';
                foreach ($dates as $date) {

                    $dateStarted = explode("T", $date);
                    $dateF = \DateTime::createFromFormat('Y-m-d', $dateStarted[0]);
                    $dateF->setTime(0,0);

                    if ($startDateWhile->format('y-m-d') === $dateF->format('y-m-d')) {
                        $value += $worklogs->getTimeForIssue($issue, $date);
                    }
                }

                $row[] = $value;

                $startDateWhile->modify("+1 day");
            }

            $startDateWhile = null;
            $rows[] = $row;
        }

        $startDate = $worklogConfig->getStart();
        $startDateWhile = clone $startDate;
        $endDate = $worklogConfig->getEnd();

        $row = ['Sum'];

        while ($startDateWhile <= $endDate) {

            $row[] = $worklogs->getSumForDay($startDateWhile);

            $startDateWhile->modify("+1 day");
        }

        $rows[] = new TableSeparator();
        $rows[] = $row;

        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows($rows);



        $table->render();
    }
}