<?php

require_once __DIR__ . "/vendor/autoload.php";

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new \Marek\Fraudator\Command\ListWorklogsCommand());
$application->add(new \Marek\Fraudator\Command\CreateWorklogsCommand());

$application->run();