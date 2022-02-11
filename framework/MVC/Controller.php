<?php

namespace Framework\MVC;

use Framework\Routing\Request;

abstract class Controller
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @param $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}
