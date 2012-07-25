<?php
/*
  PageObj:
    Contains methods and properties pertaining to site pages.

  Methods:
    getPage:  called from cgi-bin/includes/lib.inc
    makeNav:  local

  Public Properties:
    htmlfile:  apparent HTML file name of current page.
    content:  HTML code for current page.
    navbar:  array of navigation bar configurations.  Accessed from cgi-bin/includes/lib.inc

  Global variables:
    $PAGEPATH: absolute server path to files containing HTML content.  Set in cgi-bin/includes/lib.inc
    $NAV:  array of file names and link labels to be used in constructing page navigation.
*/
class PageObj {
    function __construct($pg)
    {
        global $PAGEPATH;
        global $NAV;
        $this->PAGEPATH = $PAGEPATH;
        $this->NAV = $NAV;
        $this->htmlfile = "$pg.html";
        $this->getPage($pg);
        $this->makeNav();
    }


/*
  getPage:
    Retrieves HTML content from requested page and stores it in the "content"
    property.  If no such page exists, sets the "content" property to 
    "Not found."

  Parameters:
    $pg:  Name of page containing HTML content.  Example:  tenets.
*/
    function getPage($pg)
    {
        if ($pg && file_exists("$this->PAGEPATH/$pg.inc")) {
            $lines = file("$this->PAGEPATH/$pg.inc");
            $this->content = implode('', $lines);
        }
        else {
            $this->content = 'Not found';
        }
    }


/*
  makeNav:
    Builds the navbar array, using the global file/label array, defined in cgi-bin/includes/lib.inc.
    The navbar array has three elements:
        'h': top navigation, horizontal orientation
        'v': top navigation, vertical orientation
        'b': bottom navigation (only horizontal)
    The reason for both horizontal and vertical orientations on the top is to 
    allow either possibility in a style sheet.
    The "htmlfile" property is used to mark the current page within the navigation scheme.

  Globals:
    $ACCEPTS_COOKIES:  flag indicating whether the browser accepts cookies.  Defined in cgi-bin/includes/lib.inc.
*/
    function makeNav()
    {
        global $ACCEPTS_COOKIES;
        $nav = array();
        foreach ($this->NAV as $file => $label) {
// If the browser does not accept cookies, the PHP session ID must be passed in the URL.
            $link = $ACCEPTS_COOKIES ? "<a href=\"/$file\">$label</a>" : "<a href=\"/$file/" . session_id() . "\">$label</a>";
            if ($file == $this->htmlfile) {
                $link = "<span class=\"active\">$link</span>";
            }
            $nav[] = $link;
        }
        $this->navbar = array();
        $this->navbar['h'] = implode(' | ', $nav);
        $this->navbar['v'] = implode('<br /><br />', $nav);
        $this->navbar['b'] = implode(' | ', $nav);
    }
}
?>
