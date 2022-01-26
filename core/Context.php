<?php
namespace core;

use core\models\CurrentUser;

class Context
{
    private static $instance;
    private $request;
    private $router;
	private $adminIsLogged;

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function getRequest(): Request
    {
        return $this->request;
    }
    
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
    
    public function getRouter(): Router
    {
        return $this->router;
    }
    
    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }
	
	public function setIsLogged($isLogged = false)
	{
		$this->adminIsLogged = $isLogged;
	}
	
	public function adminIsLogged()
	{
		return $this->adminIsLogged;
	}

    public function getProjectPath()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
    }
}
