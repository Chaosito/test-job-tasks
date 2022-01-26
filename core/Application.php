<?php
namespace core;

use core\models\CurUser;

class Application
{
    /** @var Context */
    private $context;

    protected function initDb()
    {
		if (!file_exists(Settings::SQLITE_DB_FILE)) {
			Database::run("CREATE TABLE tasks (username TEXT NOT NULL, mail TEXT NOT NULL, task_text TEXT NOT NULL, is_complete INT DEFAULT 0, edited_by_admin INT DEFAULT 0);");
		}
    }


    protected function init()
    {
        $request = new Request();
        $router = new Router();
        $this->context = Context::getInstance();
        $this->context->setRequest($request);
        $this->context->setRouter($router);
        $this->initDb();
        $curUser = CurUser::init();
        if ($curUser) {
            $this->context->setIsLogged($curUser);
        }
    }
    
    public function run()
    {
        $this->init();

        $router = $this->context->getRouter();
        $router->route();
        $controllerFileName = $router->getControllerPath();

        if (!class_exists($controllerFileName)) {
            throw new \Exception("Контроллер `{$controllerFileName}` не найден!");
        }

        /** @var Controller $controllerObj */
        $controllerObj = new $controllerFileName();
        $actionMethodName = $router->getActionName();

        if (!method_exists($controllerObj, $actionMethodName)) {
            throw new \Exception("Метод `{$actionMethodName}` не найден в контроллере `{$controllerFileName}`!");
        }

        $view = new View();

        $controllerObj->view = $view;
        $controllerObj->doFirst();
        $controllerObj->$actionMethodName();

        $view->setPageTitle($controllerObj->getPageTitle());

        if ($controllerObj->needRender()) {
            echo $view->render();
        }
    }
}
