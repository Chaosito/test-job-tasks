<?php
namespace app\controllers;

use core\Context as CoreContext;
use core\util\globals\AdapterGet;
use core\util\globals\AdapterPost;
use core\util\globals\GlobalsFactory as GF;
use \core\Security as CoreSecurity;

class Main extends \core\Controller
{
	const MIN_LENGTH_USERNAME = 3;
	const MIN_LENGTH_EMAIL = 6;
	const MIN_LENGTH_TASK_TEXT = 5;
	
    public function indexAction()
    {
        $this->pageTitle = 'Main page';
        GF::init(new AdapterGet());
        $sort = GF::get('sort');
        $offset = GF::get('offset');
        $orderBy = GF::get('orderby');
		$curPage = (int)GF::get('cur_page');
		$this->view->maxPages = \app\models\Task::getMaxPages();
		
		if ($curPage < 1) {
			$curPage = 1;
		}
		
		if ($curPage > $this->view->maxPages) {
			$curPage = $this->view->maxPages;
		}
		
		if (!in_array(strtolower($orderBy), ['username', 'mail', 'task_text', 'is_complete'])) {
			$orderBy = 'username';
		}
		
		$sorting = (empty($sort) || !in_array(strtoupper($sort), ['ASC', 'DESC'])) ? 'ASC' : $sort;
		$orderBy = ($orderBy == '') ? 'username' : $orderBy;
		
		$tasksList = \app\models\Task::getTasks($curPage, $orderBy, $sorting);
		foreach($tasksList as $key => $value) {
			$tasksList[$key]['username'] = CoreSecurity::safeString($value['username']); 
			$tasksList[$key]['mail'] = CoreSecurity::safeString($value['mail']); 
			$tasksList[$key]['task_text'] = CoreSecurity::safeString($value['task_text']); 
		}
		
		$this->view->tasks = $tasksList;
        $this->view->sorting = $sorting;
		$this->view->curPage = $curPage;
		$this->view->orderBy = $orderBy;
    }

	protected function validateForm()
	{
        GF::init(new AdapterPost());
        $username = GF::get('username');
        $mail = GF::get('mail');
        $task_text = GF::get('task_text');
		
		$errors = [];
		if (mb_strlen($username) < self::MIN_LENGTH_USERNAME) {
            $errors[] = 'Username too short!';
		}
		if (mb_strlen($mail) < self::MIN_LENGTH_EMAIL || !CoreSecurity::checkAddress($mail)) {
			$errors[] = 'Incorrect E-mail!';
		}
		if (mb_strlen($task_text) < self::MIN_LENGTH_TASK_TEXT) {
			$errors[] = 'Task description too short!';
		}
		return $errors;
	}

	public function task_createAction()
	{
        $this->pageTitle = 'Create Task';

        GF::init(new AdapterPost());

        if (empty(GF::get('from_create'))) {
            return false;
        }
		
        $username = GF::get('username');
        $mail = GF::get('mail');
        $task_text = GF::get('task_text');
		
        $this->view->username = CoreSecurity::safeString($username);
        $this->view->mail = CoreSecurity::safeString($mail);
        $this->view->task_text = CoreSecurity::safeString($task_text);
		
        $this->view->viewErrors = $this->validateForm();
		if (count($this->view->viewErrors)) {
			return false;
		}
		
		$task = new \app\models\Task();
		$task->setUsername($username);
		$task->setMail($mail);
		$task->setTaskText($task_text);
		$task->setComplete(0);
		$task->saveTask();
		
        CoreContext::getInstance()->getRouter()->redirectTo('/');
	}


	public function task_editAction()
	{
        $this->pageTitle = 'Edit Task';
		
        GF::init(new AdapterGet());
		$taskId = GF::get('task_id');
		$task = new \app\models\Task($taskId);
		$this->view->username = $task->getUsername();
		$this->view->mail = $task->getMail();
		$this->view->task_text = $task->getTaskText();
		$this->view->is_complete = $task->getComplete();
		$this->view->edited_by_admin = $task->getEditedByAdmin();
	
        GF::init(new AdapterPost());
        if (empty(GF::get('from_edit'))) {
            return false;
        }
	
        $username = GF::get('username');
        $mail = GF::get('mail');
        $task_text = GF::get('task_text');
		$isComplete = (GF::get('is_complete') != '') ? 1 : 0;
		
		$errors = $this->validateForm();
		
		if (!(int)$this->adminIsLogged) {
			$errors[] = 'Access Denied: Authorization Required!';
		}
		
		if ($isComplete && $this->view->task_text !== $task_text) {
			$task->setEditedByAdmin(1);
		}
			
		$this->view->viewErrors = $errors;
		
        $this->view->username = CoreSecurity::safeString($username);
        $this->view->mail = CoreSecurity::safeString($mail);
        $this->view->task_text = CoreSecurity::safeString($task_text);
		$this->view->is_complete = $isComplete;
		
		if (count($this->view->viewErrors)) {
			return false;
		}
		
		$task->setUsername($username);
		$task->setMail($mail);
		$task->setTaskText($task_text);
		$task->setComplete($isComplete);
		$task->saveTask();
		
        CoreContext::getInstance()->getRouter()->redirectTo('/');
	}



}
