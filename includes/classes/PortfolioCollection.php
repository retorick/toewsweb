<?php
global $connect;
require_once('/home/toewsweb/public_html/cgi-bin/wardrobe/connect.inc');

function format_textarea($ta) {
    $HORIZ_LINE = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td><img src='/images/spacer.gif' width='1' height='1' alt=''/></td></tr></table>";
    $ta = preg_replace("/<hr[^>]*>/", "$HORIZ_DIVIDER", $ta);
    $para = explode("\r\n\r\n", $ta);
    $text = "";
    while (list($n, $p) = each($para)) {
        $p = "<p>" . preg_replace("/\r\n/", "<br />", $p) . "</p>";
        $text .= $p . "\n";
    }
    return $text;
}

function imageHeight($img_name, $img_file) {
    $THUMB_WIDTH = 100;
  if (preg_match("/\.jpg/", $img_name)) {
    $im = imagecreatefromjpeg($img_file);
  }
  else {
    $im = imagecreatefromgif($img_file);
  }
  $original_width = imagesx($im);
  $original_height = imagesy($im);
  return intval($THUMB_WIDTH / $original_width * $original_height);
}

class Portfolio extends Application {
  function Portfolio($data) 
  {
    $PORTFOLIO_PATH = "/portfolio";
    $this->pc_id = $data->pc_id;
    $this->pc_category = $data->pc_category;
    $this->pc_description = $data->pc_description;
    $this->title = $data->p_title;
    $this->link = $data->p_link;
    $this->url = $data->p_url;
    $this->thumb = $data->p_thumb;
    $this->basename = substr($data->p_thumb, 0, strpos($data->p_thumb, '.'));
    $this->homeimg = $this->getBaseName($data->p_thumb) . '_home.jpg';
    $this->intimg = $this->getBaseName($data->p_thumb) . '_int.jpg';
    $this->comments = $data->p_comments;
    $this->entry = format_textarea($this->comments);
    $this->thumb_file = "$PORTFOLIO_PATH/$this->thumb";
    if (file_exists('/home/toewsweb/public_html' . $this->thumb_file)) {
      $this->THUMB_HEIGHT = imageHeight($this->thumb, '/home/toewsweb/public_html' . $this->thumb_file);
    }
  }

    private function getBaseName($filename) {
        $basename = substr($filename, 0, strpos($filename, '.'));
        return $basename;
    }
}

class PortfolioCollection extends Application {
    function __construct() {
        global $connect;
        $this->entries = array();
        $i = 0;
        $portfolio = array();
        $sql = "SELECT * FROM site_portfolio, site_portfolio_categories " .
               "WHERE p_categoryid=pc_id " .
               "ORDER BY pc_seq, p_seq";
        $result = mysql_query($sql, $connect);
        while ($row = mysql_fetch_object($result)) {
            $this->entries[] = new Portfolio($row);
        }
    }

    function get_collection()
    {
        global $connect;
        $this->entries = array();
        $i = 0;
        $portfolio = array();
        $sql = "SELECT * FROM site_portfolio, site_portfolio_categories " .
               "WHERE p_categoryid=pc_id " .
               "ORDER BY pc_seq, p_seq";
        $result = mysql_query($sql, $connect);
        while ($row = mysql_fetch_object($result)) {
            $this->entries[] = new Portfolio($row);
        }
    }

    function get_featured()
    {
        global $connect;
        $this->entries = array();
        $i = 0;
        $portfolio = array();
        $sql = "SELECT * FROM site_portfolio, site_portfolio_categories " .
               "WHERE p_categoryid=pc_id " .
               "  AND p_featured=1 " .
               "ORDER BY pc_seq, p_seq";
        $result = mysql_query($sql, $connect);
        while ($row = mysql_fetch_object($result)) {
            $this->entries[] = new Portfolio($row);
        }
    }
}

?>
