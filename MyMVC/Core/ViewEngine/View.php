<?php

namespace ViewEngine;

use Core\Mvc\MvcContext;

class View implements ViewInterface
{
    const VIEWS_FOLDER = 'views/';
    const VIEWS_EXTENSION = ".php";

    /**
     * @var MvcContext
     */
    private $mvcContext;

    /**
     * Application constructor.
     * @param MvcContext $mvcContext
     */
    public function __construct(MvcContext $mvcContext)
    {
        $this->mvcContext = $mvcContext;
    }

    public function render($model = null, $viewName = null)
    {
        if ($viewName !=null) {
            if (strstr($viewName, ".")) {
                include self::VIEWS_FOLDER. $viewName;
            } else {
                include self::VIEWS_FOLDER. $viewName . self::VIEWS_EXTENSION;
            }
        } else {
            $folder = strtolower($this->mvcContext->getControllerName());
            $name = strtolower($this->mvcContext->getActionName());
            $viewName = $folder . DIRECTORY_SEPARATOR . $name;
            include self::VIEWS_FOLDER . $viewName . self::VIEWS_EXTENSION;
        }
    }

}