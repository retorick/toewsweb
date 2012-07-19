<?php
require_once('Smarty/Smarty.class.php');

$smarty = new Smarty;

class Goodreads {
    private $_shelf;

    public function __construct($shelf = 'professional-development')
    {
        $this->_shelf = $shelf;
    }

    public static function bookcmp($a, $b) {
        if ($a['sort_val'] == $b['sort_val']) {
            $result = 0;
        }
        else {
            $result = ($a['sort_val'] < $b['sort_val']) ? -1 : 1;
        }
        return $result;
    }

    private function _getBookFeed() {
        $url = 'http://www.goodreads.com/review/list_rss/4175880-retorick?key=78190c41cfafe61b23163e7c15f39669dcf0ae14&shelf=' . $this->_shelf;
        $rss = file_get_contents($url);
        $p = xml_parser_create();
        xml_parse_into_struct($p, $rss, $vals, $index);
        return $vals;
    }


    private function _processArticle($str) {
        $processedStr = $str;

        if (substr($str, 0, 4) == 'The ') {
            $processedStr = substr($str, 4) . ', The';
        }
        elseif (substr($str, 0, 3) == 'An ') {
            $processedStr = substr($str, 3) . ', An';
        }
        elseif (substr($str, 0, 2) == 'A ') {
            $processedStr = substr($str, 2) . ', A';
        }
        return $processedStr;
    }


    private function _intro($str, $ndx) {
        $minlength = 0;
        $maxlength = 200;

        $intro = substr($str, 0, $maxlength); 
        $chr = substr($intro, strlen($intro) - 1, 1);
        while (strlen($intro) >= $minlength && preg_match('/\w/', $chr)) {
            $intro = substr($intro, 0, strlen($intro) - 1);
            $chr = substr($intro, strlen($intro) - 1, 1);
        }
        if (strlen($intro) < strlen($str)) {
            return $intro . ' <span id="more_'.$ndx.'" class="more">[more...]</span>';
        }
        else {
            return $intro;
        }
    }


    public function parseBookData() {
        $data = $this->_getBookFeed();
        $booklist = array();
        $ndx = 0;
        foreach ($data as $v) {
            if ($v['level'] == 2) {
                $ndx_increment = 1;
            }
            if ($v['level'] == 3) {
                $bookdata = $v['tag'] == 'ITEM';
            }
            if ($v['level'] == 4 && $bookdata) { 
                $tag = $v['tag'];
                $value = trim($v['value']);
                switch ($tag) {
                    case 'TITLE':
                        $booklist[$ndx]['sort_val'] = $this->_processArticle($value);
                        $booklist[$ndx]['title'] = $value;
                        break;
                    case 'BOOK_IMAGE_URL':
                        $booklist[$ndx]['image'] = $value;
                        break;
                    case 'AUTHOR_NAME':
                        $booklist[$ndx]['author'] = $value;
                        break;
                    case 'USER_REVIEW':
                        $booklist[$ndx]['thoughts_intro'] = $this->_intro($value, $ndx);
                        $booklist[$ndx]['thoughts'] = $value;
                        $booklist[$ndx]['ndx'] = $ndx;
                        break;
                    case 'BOOK_DESCRIPTION':
                        $booklist[$ndx]['description'] = $value;
                        break;
                    case 'ISBN':
                        $booklist[$ndx]['isbn'] = $value;
                        break;
                }
                $ndx += $ndx_increment;
                $ndx_increment = 0;
            }
        }
        return $booklist;
    }
}


$myGr = new Goodreads;

$booklist = $myGr->parseBookData();
usort($booklist, 'Goodreads::bookcmp');
/*
print '<pre>';
print_r($booklist);
print '</pre>';
*/
$smarty->assign('site_title', 'Toews Web Site Development');
$smarty->assign('page_title', 'Bookshelf');
$smarty->assign('books', $booklist);
$smarty->display('smarty/bookshelf.tpl');
?>
