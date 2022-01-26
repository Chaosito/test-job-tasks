<?php
namespace core\models;

use core\util\globals\GlobalsFactory;

final class CurUser extends \app\models\User
{
    const KEY_USER_SESSION = 'user_id';

    public static function init()
    {
        GlobalsFactory::init(new \core\util\globals\AdapterSession());
        return GlobalsFactory::get(self::KEY_USER_SESSION);
    }
}
