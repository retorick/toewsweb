<?php
/**
 * Class to get cross domain content
 *
 * @author Rick Toews <rick@toewsweb.net>
 */
class Exhibit extends Application {

    public function __construct($url) 
    {
        $data = exec("wget $url");
echo $data;
    }

/**
 * @method 
 *
 * @param 
 * @return 
 */
    public function get_recent_blogs($how_many = 3)
    {
        return $this->_get_recent_blogs($how_many);
    }
}
?>
