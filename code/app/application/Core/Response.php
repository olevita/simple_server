<?php

namespace Core;

use Exception;

class Response
{
    private string $content;

    /**
     * @param $content
     * @return Response
     */
    public function setContent($content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string
    {
        if (!isset($this->content)) {
            #Todo send 404
            throw new Exception("No response content");
        }

        return $this->content;
    }

    public function sendResponse()
    {
        echo $this->getContent();
    }
}