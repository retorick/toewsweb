<?php
require_once('layout.php');

$id = $_GET['id'];

$portfolio = new PortfolioCollection($id);

$template = file_get_contents('exhibit.template');

$replace_tags = array(
    '%URL%' => $portfolio->item->url,
    '%DESC%' => $portfolio->item->comments,
    '%TITLE%' => $portfolio->item->title,
    '%LINK%' => $portfolio->item->link,
);

$output = str_replace(array_keys($replace_tags), array_values($replace_tags), $template);

echo $output;
?>
