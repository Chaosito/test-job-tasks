<?php
namespace core;

abstract class Controller
{
    /** @var View */
    public $view;
    public $adminIsLogged;
    protected $render = true;
    protected $jsonData = [];
    protected $pageTitle = '';

    public function __construct()
    {
        $this->adminIsLogged = Context::getInstance()->adminIsLogged();
        $this->pageTitle = 'Untitiled';
    }

    public function doFirst()
    {
        $this->view->adminIsLogged = $this->adminIsLogged;
    }
    
    abstract public function indexAction();

    public function needRender()
    {
        return $this->render;
    }

    public function getPageTitle()
    {
        return $this->pageTitle;
    }
}
