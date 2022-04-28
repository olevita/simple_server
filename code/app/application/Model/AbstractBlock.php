<?php

namespace Model;

use Core\Loader;

abstract class AbstractBlock implements BlockInterface
{
    public function render(): string
    {
        $templateClass = explode('\\', get_class($this));
        unset($templateClass[0]);
        array_walk($templateClass, fn (&$item) => $item = strtolower($item));
        $templateClass = implode("/", $templateClass);
        return $this->loadTemplate($templateClass);
    }

    public function loadTemplate(string $path): string
    {
        ob_start();
        include ROOT_PATH . "app/application/Template/$path.html";
        return ob_get_clean();
    }
}