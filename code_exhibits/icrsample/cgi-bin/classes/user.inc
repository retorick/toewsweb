<?php
/*
  UserObj:
    Contains methods and properties pertaining to visitors.

  Methods:
    checkLogin:  called from cgi-bin/includes/lib.inc
    getUser:  local
    setCss:  called from cgi-bin/includes/lib.inc

  Public Properties:
    first:  visitor first name.  Accessed from index.php.
    last:  visitor last name.  Accessed from index.php.
*/
class UserObj {
    function __construct()
    {
        global $connect;
        global $STYLES;
        global $DEFAULT_STYLE;
        $this->connect = $connect;

// Check cookie for returning user
        if ($_COOKIE['icr_im_back']) {
            $this->getUser($_COOKIE['icr_im_back']);
        }
// If no cookies, check to see if the visitor is in the midst of a session.
        elseif ($_SESSION['userid']) {
            $this->getUser($_SESSION['userid']);
        }
// If the visitor is not identified, check for a style sheet selection during this session.
        elseif (!$_SESSION['css']) {
            $_SESSION['css'] = $STYLES[$DEFAULT_STYLE];
        }
    }


/*
  checkLogin: 
    Checks the first and last name against the icr_users table.  If they're 
    found, the primary key (usr_id) is retrieved.  Otherwise, the name and 
    current style sheet file name are added to the table.
    In either case, the getUser method is called with the ID.

  Parameters:  
    $first: visitor's first name
    $last: visitor's last name
               
  Globals:
    $STYLES: associative array of CSS files, set in cgi-bin/includes/lib.inc.
    $DEFAULT_STYLE: index of default CSS file, set in cgi-bin/includes/lib.inc.
*/
    function checkLogin($first, $last)
    {
        global $STYLES;
        global $DEFAULT_STYLE;

        $sql = "SELECT usr_id FROM icr_users WHERE usr_first='$first' AND usr_last='$last'";
        $result = check_mysql($sql, $this->connect);
// If the first and last name combination is recognized, retrieve the ID from the table.
        if ($row = mysql_fetch_object($result)) {
            $userid = $row->usr_id;
        }
// Otherwise, insert the name into the table, with the currently selected CSS file name, or the default if none has been selected.
        else {
            $css = $_SESSION['css'] ? $_SESSION['css'] : $STYLES[$DEFAULT_STYLE];
            $sql = "INSERT INTO icr_users SET usr_first='$first', usr_last='$last', usr_css='$css'";
            check_mysql($sql, $this->connect);
            $userid = mysql_insert_id($this->connect);
        }
// Now, retrieve the User ID.
        $this->getUser($userid);
    }


/*
  getUser:
    If there is a record corresponding to the $userid value, retrieves visitor 
    information from the table.
    Stores the CSS file name in the "css" session variable.  If a visitor
    record was retrieved, the CSS file name comes from the record; otherwise,
    the CSS file name is the default.  NOTE:  this "otherwise" shouldn't
    happen, unless the record corresponding to a previously stored cookie
    is deleted from the table.
    Attempts to set a persistent cookie containing the $userid value.

  Parameters:
    $userid: primary key for table icr_users.

  Globals:
    $STYLES: associative array of CSS files, set in cgi-bin/includes/lib.inc.
    $DEFAULT_STYLE: index of default CSS file, set in cgi-bin/includes/lib.inc.
*/
    function getUser($userid)
    {
        global $STYLES;
        global $DEFAULT_STYLE;
        $sql = "SELECT * FROM icr_users WHERE usr_id='$userid'";
        $result = check_mysql($sql, $this->connect);
        if ($row = mysql_fetch_object($result)) {
            $this->first = $row->usr_first;
            $this->last = $row->usr_last;
            $_SESSION['userid'] = $userid;
            $_SESSION['css'] = $row->usr_css;
        }
        else {
            $_SESSION['css'] = $STYLES[$DEFAULT_STYLE];
        }
        setcookie('icr_im_back', $userid, time() + 3600*24*30, '/'); // Cookie persists for 30 days from most recent use.
    }


/*
  setCss:
    Called from cgi-bin/includes/lib.inc when a CSS file is selected from a 
    dropdown menu.  Stores the file name in a session variable and also in
    the icr_users table, if a record exists.  ( Session variable 'userid' was 
    set by getUser if a record was found.)
*/
    function setCss()
    {
        if ($_SESSION['userid']) {
            $sql = "UPDATE icr_users SET usr_css='{$_SESSION['css']}' WHERE usr_id='{$_SESSION['userid']}'";
            check_mysql($sql, $this->connect);
        }
    }
}
?>
