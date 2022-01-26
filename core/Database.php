<?php
namespace core;

use \PDO;

class Database
{
    protected static $instance = null;
	protected static $dbExists;

    public function __construct() {}
    public function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT, // or "PDO::ERRMODE_EXCEPTION" for dev
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            );
            self::$instance = new PDO('sqlite:'.Settings::SQLITE_DB_FILE, null, null, $opt);
        }
        return self::$instance;
    }
    
    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = array())
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}