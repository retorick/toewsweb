<?php
require_once('Smarty/Smarty.class.php');
require_once('includes/classes/Db.php');
require_once('includes/classes/Home.php');
require_once('includes/classes/PortfolioCollection.php');
require_once('code_sample_data.php');

$smarty = new Smarty;

$myHome = new Home;
$blog_posts = $myHome->get_recent_blogs();
$code_samples = $myHome->get_code_samples();
$portfolio_highlights = $myHome->get_portfolio_highlights();

$smarty->assign('site_title', 'Toews Web Site Development');
$smarty->assign('page_title', 'Home');
$smarty->assign('blog_posts', $blog_posts);
$smarty->assign('code_samples', $code_samples);
$smarty->assign('portfolio_highlights', $portfolio_highlights);
$smarty->assign('pic', 'c');
$smarty->display('smarty/home.tpl');
?>
