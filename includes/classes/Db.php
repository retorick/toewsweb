<?php
class Db {
    private static $_instance;

    public static function getInstance($which_db = 'model') {
        if (self::$_instance == null) {
            self::$_instance = self::_connect($which_db);
        }
        return self::$_instance;
    }

    private static function _connect($which_db) {
        switch ($which_db) {
            case 'model' :
                $connect = mysql_connect('localhost', 'rick', 'toews');
                break;
            case 'webdev_blog' :
                $connect = mysql_connect('localhost', 'retorick', '153846');
                break;
        }
        mysql_select_db($which_db, $connect);
        return $connect;
    }

}
?>
