<?php

namespace Controller;

use Core\Connection\Connection;
use Core\DB\Mysql;
use Core\Hash;
use Core\Request\Parser;
use Core\Response;
use PDOException;

class Save extends AbstractAction
{
    private Mysql $mysql;
    protected string $template = 'SuccessRegister';

    public function __construct(
        Response $response,
        Mysql $mysql
    ) {
        parent::__construct($response);
        $this->mysql = $mysql;
    }

    public function execute(): Response
    {
        $postParams = Parser::getRequest()->getPostParams();
        $data = [
            'login' => $postParams['login'],
            'password' => Hash::encode($postParams['password'])
        ];
        try {
            $this->mysql->insert('user', $data);
        } catch (PDOException) {
            $this->template = 'DuplicateEntry';
        }
        return parent::execute();
    }
}