<?php

namespace Core\Console;

use Core\Loader;
use Exception;

class Parser
{
    public function parse(array $argv, int $argc)
    {
        if (!$argc) {
            throw new Exception("Command not specified");
        }

        $commandList = $this->getCommandList();
        $class = $commandList[$argv[1]];

        if (!$class) {
            throw new Exception("No such command");
        }

        /** @var CommandInterface $command */
        $command = Loader::loadClass($class);
        return $command->run($argv);
    }

    private function getCommandList(): array
    {
        return [
            "db:update" => "\Core\Console\Command\DbUpdate"
        ];
    }
}