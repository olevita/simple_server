<?php

namespace Core\Console\Command;

use Core\Console\AbstractCommand;

class DbUpdate extends AbstractCommand
{
    protected static string $command = 'db:update';

    public function run($args)
    {
        $file = $args[2] ?? throw new \Exception("Please specify file");

    }
}