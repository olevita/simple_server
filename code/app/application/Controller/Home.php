<?php

namespace Controller;

use Core\DB\Mysql;

class Home extends AbstractAction
{
    private Mysql $mysql;

    public function __construct(
        Mysql $mysql
    ) {
        $this->mysql = $mysql;
    }

}