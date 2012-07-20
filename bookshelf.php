<?php
require_once('layout.php');

$myBooks = new Bookshelf;

$booklist = $myBooks->parseBookData();
usort($booklist, 'Bookshelf::bookcmp');

$smarty->assign('site_title', 'Toews Web Site Development');
$smarty->assign('page_title', 'Bookshelf');
$smarty->assign('books', $booklist);
$smarty->display('smarty/bookshelf.tpl');
?>
