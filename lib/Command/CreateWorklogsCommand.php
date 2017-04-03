<?php

namespace Marek\Fraudator\Command;

use Symfony\Component\Console\Command\Command;

class CreateWorklogsCommand extends Command
{
    protected function configure()
    {
        $this->setName("marek:fraudator:create");
    }
}