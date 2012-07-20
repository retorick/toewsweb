<?php
define('WP_USE_THEMES', false);
require_once('blog/wp-blog-header.php');
require_once('Db.php');

abstract class Application {
    protected $_blog_conn;
    protected $_site_conn;

    protected function __construct()
    {
        $this->_db();
    }

    protected function _db()
    {
        $this->_blog_conn = Db::getInstance('webdev_blog');
        $this->_site_conn = Db::getInstance('model');
    }

    protected function _errorHandler($e)
    {
        print $e->getMessage() . '<br/>';
    }
}
?>
