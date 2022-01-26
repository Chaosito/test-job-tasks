<?php
namespace core;

class View
{

    protected $data;
    protected $pageTitle;
    protected $pathToTemplates;
    protected $templateFile;
	protected $adminIsLogged;

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    public function __get($name)
    {
        return (isset($this->data[$name]) ? $this->data[$name] : '');
    }

    public function setPageTitle($title)
    {
        $this->pageTitle = $title;
    }

	protected function getPathToViews()
	{
		return implode(DIRECTORY_SEPARATOR, [
            $_SERVER['DOCUMENT_ROOT'],
            '..',
            'app',
            'views',
        ]);
	}
	
    public function render()
    {
        $stylesScriptsFileName = Context::getInstance()->getRouter()->getStylesScriptsFileName();
		
        $pageStylesheets = "css/{$stylesScriptsFileName}.css";
        $pageStylesheets = file_exists($pageStylesheets) ? "/{$pageStylesheets}" : "";
        $this->data['page_css'] = $pageStylesheets;
		
        $pageScripts = "js/{$stylesScriptsFileName}.js";
        $pageScripts = file_exists($pageScripts) ? "/{$pageScripts}" : "";
        $this->data['page_js'] = $pageScripts;
		
		$this->adminIsLogged = Context::getInstance()->adminIsLogged();

        $pathToViews = $this->getPathToViews();


        if (empty($this->templateFile)) {
            $this->templateFile =
                Context::getInstance()->getRouter()->getControllerName().
                DIRECTORY_SEPARATOR.
                Context::getInstance()->getRouter()->getActionToken().
                '.php';
        }

        ob_start();
		require_once($pathToViews.DIRECTORY_SEPARATOR.'header.php');
		require_once($pathToViews.DIRECTORY_SEPARATOR.$this->templateFile);
		require_once($pathToViews.DIRECTORY_SEPARATOR.'footer.php');
        return ob_get_clean();
    }
}
