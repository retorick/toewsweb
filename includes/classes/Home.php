<?php
/**
 * Class to get content for home page of toewsweb.net.
 *
 * @author Rick Toews <rick@toewsweb.net>
 */
class Home extends Application {

    public function __construct() 
    {
        parent::__construct();
    }

/**
 * @method get_recent_blogs($how_many) Retrieve the most recent blogs from the Wordpress wp_posts table for display on home page.
 *
 * @param int $how_many How many most recent blog posts to retrieve.
 * @return array
 */
    public function get_recent_blogs($how_many = 3)
    {
        return $this->_get_recent_blogs($how_many);
    }

/**
 * @method get_code_samples() Retrieve featured code samples to be highlighted on home page.
 *
 * @return array
 */
    public function get_code_samples()
    {
        return $this->_get_code_samples();
    }

/**
 * @method get_portfolio_highlights() Retrieve featured Web sites from portfolio for display on home page.
 *
 * @return array
 */
    public function get_portfolio_highlights()
    {
        return $this->_get_portfolio_highlights();
    }


/**
 * @method private _get_recent_blogs($how_many) Gory details for retrieving blog posts from wp_posts table.
 *
 * @param int $how_many Number of recent blog posts to retrieve
 * @return array
 */
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

/**
 * @method private _get_code_samples() 
 *
 * @return array
 *
 * @note:  get rid of global $code_samples and make an instance of a CodeSamples class, or somthing.
 */
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

/**
 * @method private _get_portfolio_highlights() Retrieve featured portfolio entries.
 *
 * @return array
 */
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
                    $items[$n]['id'] = $p->id;
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

/**
 * @method private _make_permalink($href) Create "read more" link for Wordpress blog post.
 *
 * @param string $href Permalink for Wordpress blog post URL
 * @return string
 */
    private function _make_permalink($href)
    {
        $link_template = ' (<a href="%HREF%">Read...</a>)';

        $link = str_replace('%HREF%', $href, $link_template);
        return $link;
    }

/**
 * @method private _get_excerpt($str, $href) Get excerpt of blog post.  Excerpt cut-off point is <!--more--> market, as per Wordpress convention.
 *
 * @param string $str String of Wordpress blog post.
 * @param string $href Wordpress permalink, needed to pass to _make_permalink method.
 * @return string
 */
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
