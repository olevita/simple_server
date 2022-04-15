<?php

namespace Core;

use Core\Request\Parser;

class Application
{
    public function run()
    {
        $request = Parser::getRequest();
        $path = trim(parse_url($request->getUrl(), PHP_URL_PATH), "/");
        if ($path == '') {
            $path = "Home";
        } else {
            $path = explode('/', $path);
            array_walk($path, fn(&$item) => $item = ucfirst($item));
            $path = implode("\\", $path);
        }
        $path = "\\Controller\\$path";
        $result = Loader::loadClass($path, 'execute');
        if (!$result) {
            include ROOT_PATH . "pub/errors/404.html";
            return;
        }
    }
}