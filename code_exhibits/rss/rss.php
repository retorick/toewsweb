<?php
$url = 'http://www.goodreads.com/review/list_rss/4175880-retorick?key=78190c41cfafe61b23163e7c15f39669dcf0ae14&shelf=professional-development';
$rss = file_get_contents($url);

$p = xml_parser_create();
xml_parse_into_struct($p, $rss, $vals, $index);
foreach ($vals as $v) {
    $indent = $v['level'] * 20;
    $space = str_repeat('&nbsp;', $indent);
    print $space . $v['tag'] . '<br/>';
}
/*
foreach ($vals as $v) {
    if (1||$v['level'] == 4) {
        $tag = $v['tag'];
        $value = $v['value'];
        if ($tag == 'TITLE') {
            print '<br/>';
        }
        switch ($tag) {
            case 'TITLE':
                print "<b>$value</b><br/>";
                break;
            case 'BOOK_IMAGE_URL':
                print "<img src='$value' /><br/>";
                break;
            case 'AUTHOR_NAME':
                print "<i>$value</i><br/>";
                break;
            case 'USER_REVIEW':
                print "Thoughts: $value<br/>";
                break;
            case 'ISBN':
                break;
        }
        foreach ($v as $key => $val) {
            print "$key: $val<br/>";
        }
    }
}
*/
?>
