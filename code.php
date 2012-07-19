<?php
require_once('Smarty/Smarty.class.php');
require_once('code_sample_data.php');

$smarty = new Smarty;


$smarty->assign('site_title', 'Toews Web Site Development');
$smarty->assign('page_title', 'Code Samples');
$smarty->assign('samples', $code_samples);
$smarty->display('smarty/code_samples.tpl');
?>
