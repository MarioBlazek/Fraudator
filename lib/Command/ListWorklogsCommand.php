<?php

namespace Marek\Fraudator\Command;

use Symfony\Component\Console\Command\Command;

class ListWorklogsCommand extends Command
{
    protected function configure()
    {
        $this->setName("marek:fraudator:list");
    }
}