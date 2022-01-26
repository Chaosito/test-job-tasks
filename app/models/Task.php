<?php
namespace app\models;

use core\Database;

class Task
{
	const TASKS_PER_PAGE = 3;
	protected $rowid = 0;
	protected $username;
	protected $mail;
	protected $task_text;
	protected $is_complete = 0;
	protected $edited_by_admin = 0;
	
	public function __construct($taskId = 0)
	{
		if ($taskId > 0) {
			$curTask = Database::run("SELECT username, mail, task_text, is_complete, edited_by_admin FROM tasks WHERE rowid = ? LIMIT 1;", [$taskId])->fetch();
			if ($curTask) {
				$this->rowid = $taskId;
				$this->username = $curTask['username'];
				$this->mail = $curTask['mail'];
				$this->task_text = $curTask['task_text'];
				$this->is_complete = $curTask['is_complete'];
				$this->edited_by_admin = $curTask['edited_by_admin'];
			} else {
				throw new Exception('Task not found!');
			}
		}
	}
	
    public static function getTasks($curPage, $orderBy = 'username', $sorting = 'ASC')
    {
		$offset = ($curPage - 1) * self::TASKS_PER_PAGE;
		
		return Database::run("SELECT rowid, username, mail, task_text, is_complete, edited_by_admin FROM tasks ORDER BY `{$orderBy}` {$sorting} LIMIT ? OFFSET ?", [self::TASKS_PER_PAGE, $offset])->fetchAll();
    }
	
	public static function getMaxPages()
	{
		$records = (int)Database::run("SELECT COUNT(rowid) FROM tasks")->fetchColumn();
		return ($records > 0) ? ceil($records / self::TASKS_PER_PAGE) : 0;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setMail($mail)
	{
		$this->mail = $mail;
	}
	
	public function getMail()
	{
		return $this->mail;
	}
	
	public function setTaskText($taskText)
	{
		$this->task_text = $taskText;
	}
	
	public function getTaskText()
	{
		return $this->task_text;
	}
	
	public function setComplete($isComplete)
	{
		$this->is_complete = $isComplete;
	}
	
	public function getComplete()
	{
		return $this->is_complete;
	}
	
	public function setEditedByAdmin($flag)
	{
		$this->edited_by_admin = $flag;
	}
	
	public function getEditedByAdmin()
	{
		return $this->edited_by_admin;
	}
	
	public function saveTask()
	{
		if ((int)$this->rowid > 0) {
			Database::run(
				"UPDATE tasks SET username = ?, mail = ?, task_text = ?, is_complete = ?, edited_by_admin = ? WHERE rowid = ?",
				[$this->username, $this->mail, $this->task_text, $this->is_complete, $this->edited_by_admin, $this->rowid]
			);
		} else {
			Database::run(
				"INSERT INTO tasks (username, mail, task_text, is_complete, edited_by_admin) VALUES (?, ?, ?, ?, ?)",
				[$this->username, $this->mail, $this->task_text, $this->is_complete, $this->edited_by_admin]
			);
		}
	}
}
