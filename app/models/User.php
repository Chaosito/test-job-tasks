<?php
namespace app\models;

class User
{
	protected $passHash = '202cb962ac59075b964b07152d234b70';
	
    public function matchPassword($password)
    {
		return ($this->passHash == md5($password));
    }
}
