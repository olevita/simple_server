<?php

namespace Controller;

use Core\DiContainer\Container;
use Core\Loader;
use Core\Response;
use Model\BlockInterface;

abstract class AbstractAction implements ActionInterface
{
    private Response $response;
    protected string $template;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function execute(): Response
    {
        if (!isset($this->template)) {
            $templateClass = explode('\\', get_class($this));
            unset($templateClass[0]);
            $templateClass = implode("\\", $templateClass);
        } else {
            $templateClass = $this->template;
        }
        $container = new Container();
        /** @var BlockInterface $model */
        $model = $container->get("\\Model\\$templateClass");
        $this->response->setContent($model->render());
        return $this->response;
    }
}