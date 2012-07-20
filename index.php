<?php
require_once('layout.php');

require_once('code_sample_data.php');

$myHome = new Home;
$code_samples = $myHome->get_code_samples();
$portfolio_highlights = $myHome->get_portfolio_highlights();

$smarty->assign('pic', 'c');
$smarty->assign('page_title', 'Home');
$smarty->assign('code_samples', $code_samples);
$smarty->assign('portfolio_highlights', $portfolio_highlights);

$smarty->display('smarty/home.tpl');
?>
