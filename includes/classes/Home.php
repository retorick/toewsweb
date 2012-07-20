<?php
class Home extends Application {

    public function __construct() 
    {
        parent::__construct();
    }

    public function get_recent_blogs($how_many = 3)
    {
        return $this->_get_recent_blogs($how_many);
    }

    public function get_code_samples()
    {
        return $this->_get_code_samples();
    }

    public function get_portfolio_highlights()
    {
        return $this->_get_portfolio_highlights();
    }

    private function _get_recent_blogs($how_many)
    {
        $rows = array();
        try {
            if ($this->_blog_conn) {
                $sql = "SELECT ID, post_date, post_title, post_content, post_excerpt FROM wp_posts WHERE post_status='publish' and post_type='post' ORDER BY post_date DESC LIMIT $how_many"; 
                $result = mysql_query($sql, $this->_blog_conn);
                while ($row = mysql_fetch_assoc($result)) {
                    $row['date'] = date('F j', strtotime($row['post_date']));
                    $row['link'] = get_permalink($row['ID']);
                    $row['content'] = apply_filters('the_content', $this->_get_excerpt($row['post_content'], $row['link']));
                    $rows[] = $row;
                }
            }
            else {
                throw new Exception('Not connected with blog database.');
            }
        }
        catch (Exception $e) {
            $this->_errorHandler($e);
        }
        return $rows;
    }

    private function _get_code_samples()
    {
        global $code_samples;
        $samples = array();
        foreach ($code_samples as $item) {
            if ($item['featured']) {
                $samples[] = $item;
            }
        }
        return $samples;
    }

    private function _get_portfolio_highlights()
    {
        $items = array();
        try {
            if (class_exists('PortfolioCollection')) {
                $portfolio = new PortfolioCollection();
                $portfolio->get_featured();
                $lastcat = -1;
                $n = 0;
                foreach ($portfolio->entries as $p) {
                    $items[$n]['category'] = $p->pc_category;
                    $items[$n]['description'] = $p->pc_description;
                    $items[$n]['link'] = $p->link;
                    $items[$n]['title'] = $p->title;
                    $items[$n]['url'] = $p->url;
                    $items[$n]['thumb_file'] = $p->thumb_file;
                    $items[$n]['entry'] = $p->entry;
                    $n++;
                }                
            }
            else {
                throw new Exception('PortfolioCollection class not loaded.');
            }
        }
        catch (Exception $e) {
            error_log($e->getMessage());
        }
        return $items;
    }

    private function _make_permalink($href)
    {
        $link_template = ' (<a href="%HREF%">Read...</a>)';

        $link = str_replace('%HREF%', $href, $link_template);
        return $link;
    }

    private function _get_excerpt($str, $href)
    {
        // use the full string as the default excerpt.
        $excerpt = $str;
        // search for string's content preceding "more" marker.  DOTALL modifier prevents exclusion of newlines from match.
        if (preg_match('/^(.*)<!--\s*more\s*-->/s', $str, $matches)) {
            $excerpt = $matches[1];
        }

        $excerpt = $excerpt . $this->_make_permalink($href);
        return $excerpt;
    }
}
?>
