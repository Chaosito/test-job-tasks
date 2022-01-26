<?php
namespace app\controllers;

use core\Context as CoreContext;
use core\models\CurUser;
use \core\Security as CoreSecurity;
use core\util\globals\AdapterPost;
use core\util\globals\AdapterSession;
use core\util\globals\GlobalsFactory as GF;

use app\models\User as UserModel;

class User extends \core\Controller
{
    public function indexAction()
    {
        $this->render = false;
        CoreContext::getInstance()->getRouter()->redirectTo('/');
    }

    public function loginAction()
    {
        $this->pageTitle = 'Login';

        if (CoreContext::getInstance()->adminIsLogged()) {
            CoreContext::getInstance()->getRouter()->redirectTo('/');
        }

        GF::init(new AdapterPost());

        if (empty(GF::get('from_login'))) {
            return false;
        }

        $this->view->viewErrors = [];
        $this->view->login = CoreSecurity::safeString(GF::get('login'));

        if (empty(GF::get('login')) || empty(GF::get('password'))) {
            $this->view->viewErrors = ['Login or password not filled!'];
            return false;
        }

		$user = new UserModel();
		if (strtolower(GF::get('login')) != 'admin' || !$user->matchPassword(GF::get('password'))) {
            $this->view->viewErrors = ['Login\password is wrong!'];
            return false;
		}			
		
        GF::init(new AdapterSession());
        GF::set(CurUser::KEY_USER_SESSION, 1);
        CoreContext::getInstance()->getRouter()->redirectTo('/');
    }
    

    public function logoutAction()
    {
        $this->render = false;
        GF::init(new AdapterSession());
        GF::remove(CurUser::KEY_USER_SESSION);
        session_regenerate_id(true);
        CoreContext::getInstance()->getRouter()->redirectTo('/');
    }

}
