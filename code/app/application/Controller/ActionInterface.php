<?php

namespace Controller;

use Core\Response;

interface ActionInterface
{
    public function execute(): Response;
}