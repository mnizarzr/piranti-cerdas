<?php

namespace Src\Handler;


class ViewHandler
{
    public function __invoke()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/src/View/index.php';
    }
}
