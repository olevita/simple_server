<?php

namespace Core;

use Controller\ActionInterface;
use Core\DiContainer\Container;
use Core\Request\Parser;

class Application
{
    public function run()
    {
        $request = Parser::getRequest();
        $container = new Container();
        $path = trim(parse_url($request->getUrl(), PHP_URL_PATH), "/");
        if ($path == '') {
            $path = "Home";
        } else {
            $path = explode('/', $path);
            array_walk($path, fn(&$item) => $item = ucfirst($item));
            $path = implode("\\", $path);
        }
        $path = "\\Controller\\$path";
        /** @var ActionInterface $action */
        $action = $container->get($path);
        if (!$action) {
            include ROOT_PATH . "pub/errors/404.html";
            return;
        }
        $response = $action->execute();
        $response->sendResponse();
    }
}