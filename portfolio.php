<?php
require_once('Smarty/Smarty.class.php');

$smarty = new Smarty;

require_once('includes/classes/PortfolioCollection.php');

$portfolio = new PortfolioCollection();
$items = array();
$lastcat = -1;
$n = 0;
foreach ($portfolio->entries as $p) {
    $items[$n]['category'] = $p->pc_category;
    $items[$n]['description'] = $p->pc_description;
    $items[$n]['url'] = $p->url;
    $items[$n]['title'] = $p->title;
    $items[$n]['thumb_file'] = $p->thumb_file;
    $items[$n]['entry'] = $p->entry;
    $n++;
}                
//$smarty->assign('portfolio', $items);
$smarty->assign('site_title', 'Toews Web Site Development');
$smarty->assign('page_title', 'Portfolio');
$smarty->assign('portfolio', $items);
$smarty->display('smarty/portfolio.tpl');

?>
