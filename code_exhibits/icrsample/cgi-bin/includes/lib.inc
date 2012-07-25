<?php
// Initiate session
session_start();

// Check for cookies
setcookie('icr_test', '1');
$ACCEPTS_COOKIES = $_COOKIE['icr_test'];

// Database connection
require_once('/home/toewsweb/www/cgi-bin/wardrobe/connect.inc');

// Pre-defined variables
$STYLES = array('Generic' => 'generic.css', 'Style A' => 'style1.css', 'Style B' => 'style2.css');
$DEFAULT_STYLE = 'Generic';

$NAV = array('tenets.html' => 'Tenets', 'heritage.html' => 'Our Heritage');
$PAGEPATH = '/home/toewsweb/www/icrsample/cgi-bin/pg';

// Class files
require_once($_SERVER['DOCUMENT_ROOT'] . '/cgi-bin/classes/page.inc');
require_once($_SERVER['DOCUMENT_ROOT'] . '/cgi-bin/classes/user.inc');

// Processing for all pages.
$page = !isset($_GET['page']) ? 'heritage' : $_GET['page'];  // $page might equal 'tenets' or 'heritage'

// Instantiate objects
// The 'css' session variable is set by the UserObj constructor, if it doesn't already have a value.
$USER = new UserObj();
$HTML = new PageObj($page);

// See if style selection has changed
if (isset($_POST['style'])) {
    $_SESSION['css'] = $_POST['style'];
    $USER->setCss();
}

$ID_LINK = $ACCEPTS_COOKIES ? '/identify.html' : '/identify.html/' . session_id();
$TITLE = $NAV[$HTML->htmlfile] . ' - Institute for Creation Research';
$CONTENT = $HTML->content;
$NAVBAR = $HTML->navbar;


function check_mysql($sql, $connect) {
    $result = mysql_query($sql, $connect);
// Attempt the MySQL query.  If there's an error, display it.
    if ($errno = mysql_errno($connect)) {
        $error = mysql_error($connect);
        print "MySQL error: $error ($errno)<br />";
        print "SQL statement: $sql<br />";
    }
    return $result;
}
?>
