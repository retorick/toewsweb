<?php
// Wordpress stuff needed to make blog data available throughout the site.
define('WP_USE_THEMES', false);
require_once('blog/wp-blog-header.php');

// Use the Smarty template engine, even though I dislike the name.  Maybe change to a different one later.
require_once('Smarty/Smarty.class.php');
$smarty = new Smarty;

// Exploit PHP's ability to automatically load classes as needed.
spl_autoload_register(function ($class) {
    require_once('includes/classes/'.$class.'.php');
});


// Beginning of layout stuff.  Probably should go in another file.
require_once('sidebar.php');

$smarty->assign('site_title', 'Toews Web Site Development');
?>
