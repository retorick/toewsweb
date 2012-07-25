<?php
include("path.inc");
include("$PATH/lab/spellchecker.inc");

// Get word list from text.
class Wordlist {
    function Wordlist($pos, $word) {
        $this->pos = $pos;
        $this->word = $word;
        $this->len = strlen($word);
        $this->misspelled = "";
    }
}


function strip_punct($str) {
    $punct = "\.:,;\?!\"'-()[]\r\n";
    $str = preg_replace("/(\w)'(\w)/", "\\1*\\2", $str);
    $str = preg_replace("/(\w)-(\w)/", "\\1~\\2", $str);
    $str = preg_replace("/[-\.\",:;\?!'()\[\]]/", " ", $str);
    $str = preg_replace("/\*/", "'", $str);
    $str = preg_replace("/\~/", "-", $str);
    return ($str);
}


function word_list($str) {
    $pos = 0;
    $i = 0;
    $words = array();
    while (strlen($str) > 0 && $i < 1000) {
        if (preg_match("/^(\s*)([^\s]+)/", $str, $matches)) {
            $spaces = $matches[1];
            $pos += strlen($spaces);
            $words[$i] = new Wordlist($pos, $matches[2]);
            $discard = strlen($spaces) + strlen($words[$i]->word);
            $pos += strlen($words[$i]->word);
            $str = substr($str, $discard, strlen($str) - $discard);
            $i++;
        }
        else {
            $str = "";
        }
    }
    return $words;
}



$text = stripslashes($_REQUEST['text']);
// This is to deal with the fact that IE receives two characters (\r, \n) for every line break.
// This was throwing off the positions of words to be corrected.  The positions were off by
// one character for each line break entered in the textarea field.
$text = preg_replace("/\r/", "", $text);

if ($text) {
    $xml = '<?xml version="1.0" ?>';
/*    $xml = '<?xml-stylesheet type="text/xsl" href="spellchecker.xsl" ?>'; */
    $xml .= '<spellcheck>';
    $xml .= "<originaltext>$text</originaltext>";
    $spell_checker = new SpellChecker();

    $textwords = strip_punct($text);
    $textwordsArray = word_list($textwords); 

    $list = "";
    foreach ($textwordsArray as $n => $w) {
        $xml .= "<word>";
        $xml .= "<original pos=\"$w->pos\" len=\"$w->len\">$w->word</original>";
        if (!$spell_checker->check($w->word)) {
            $xml .= '<status>-1</status>';
            $suggestions = $spell_checker->suggest($w->word);
            if (sizeof($suggestions) > 0) {
                $xml .= '<suggestions>';
                foreach ($suggestions as $s) {
                    $xml .= "<sugword>$s</sugword>";
                }
                $xml .= '</suggestions>';
            }
        }
        $xml .= "</word>";
    }
    $spell_checker->close();
    $xml .= '</spellcheck>';
    header('Content-type: text/xml');
    print($xml);
}
?>
