<?php
/**
 * Application abstract class for toewsweb.net.
 * Provides database connections and error handling required by other classes.
 *
 * @author Rick Toews <rick@toewsweb.net>
 */
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
