<?php

namespace Controller;

use Core\Connection\Connection;
use Core\DB\Mysql;
use Core\Hash;
use Core\Request\Parser;

class Check extends AbstractAction
{
    protected string $template = 'SuccessLogin';
    private Mysql $mysql;

    public function __construct(Mysql $mysql)
    {
        $this->mysql = $mysql;
    }

    public function execute(): ?bool
    {
        $postParams = Parser::getRequest()->getPostParams();
        $login = $postParams['login'];
        $password = Hash::encode($postParams['password']);
        $result = $this->mysql->select("user", "login = '$login' and password = '$password'");
        if (!$result) {
            $this->template = 'FailedLogin';
        }
        parent::execute();
        return true;
    }
}