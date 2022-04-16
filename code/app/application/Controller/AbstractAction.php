<?php

namespace Controller;

use Core\Loader;
use Model\BlockInterface;

abstract class AbstractAction implements ActionInterface
{
    protected string $template;

    public function execute(): ?bool
    {
        if (!isset($this->template)) {
            $templateClass = explode('\\', get_class($this));
            unset($templateClass[0]);
            $templateClass = implode("\\", $templateClass);
        } else {
            $templateClass = $this->template;
        }
        /** @var BlockInterface $model */
        $model = Loader::loadClass("\\Model\\$templateClass");
        $model->render();
        return true;
    }
}