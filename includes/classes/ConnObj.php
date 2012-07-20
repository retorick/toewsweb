<?php
class ConnObj {
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new ConnObj();
        }
        return self::$_instance;
    }

    private function __construct() {
        $connect = mysql_connect('localhost', 'rick', 'toews');
        $db = mysql_select_db('model', $connect);
        return $db;
    }

}
?>
