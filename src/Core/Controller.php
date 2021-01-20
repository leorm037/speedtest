<?php

namespace PaginaEmConstrucao\Core;

abstract class Controller
{
    /** @var View */
    protected $view;
    
    public function __construct(string $pathToViews = null)
    {
        if($pathToViews) {
            $this->view = new View($pathToViews);
        } else {
            $this->view = new View();
        }
    }
}
