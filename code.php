<?php
require_once('layout.php');

require_once('code_sample_data.php');
$smarty->assign('page_title', 'Code Samples');
$smarty->assign('samples', $code_samples);
$smarty->display('smarty/code_samples.tpl');
?>
