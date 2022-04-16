<?php

namespace Controller;

use Core\Connection\Connection;
use Core\DB\Mysql;
use Core\Hash;
use Core\Request\Parser;
use PDOException;

class Save extends AbstractAction
{
    private Mysql $mysql;
    protected string $template = 'SuccessRegister';

    public function __construct(Mysql $mysql) {
        $this->mysql = $mysql;
    }

    public function execute(): ?bool
    {
        $postParams = Parser::getRequest()->getPostParams();
        $data = [
            'login' => $postParams['login'],
            'password' => Hash::encode($postParams['password'])
        ];
        try {
            $result = $this->mysql->insert('user', $data);
        } catch (PDOException) {
            $this->template = 'DuplicateEntry';
        }
        parent::execute();
        return true;
    }
}