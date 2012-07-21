
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <title>Toews Web Site Development - Home</title>
  <link rel="stylesheet" href="./css/style.css"/>
  <link rel="stylesheet" href="./css/home.css"/>
  <link rel="stylesheet" href="./css/portfolio.css"/>
  <link rel="stylesheet" href="./css/code_samples.css"/>
  <link rel="stylesheet" href="./css/bookshelf.css"/>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="./js/toewsweb.js"></script>
  <script type="text/javascript" src="./js/fix.js"></script>
</head>
<body>
<!-- Page container : begin -->
<div id="page_container">

<!-- Left column : begin -->
  <div id="left_col">
    <img src="./images/int_c.jpg" />
    <div id="sidebar">
  <h2 class="sidebartitle">Recent Posts</h2>
  <ul class="recent-titles" style="margin:0 0 10px 0;padding:0; list-style:none">
<li style="margin-top:10px;"><a style="color:#ccc;" href="http://www.toewsweb.net/blog/the-joy-of-scss/" title="Look The Joy of SCSS" >The Joy of SCSS</a> </li> <li style="margin-top:10px;"><a style="color:#ccc;" href="http://www.toewsweb.net/blog/php-regular-expressions-dotall-modifier/" title="Look PHP Regular Expressions: DOTALL modifier" >PHP Regular Expressions: DOTALL modifier</a> </li> <li style="margin-top:10px;"><a style="color:#ccc;" href="http://www.toewsweb.net/blog/javascript-string-slice/" title="Look JavaScript String.slice()" >JavaScript String.slice()</a> </li> <li style="margin-top:10px;"><a style="color:#ccc;" href="http://www.toewsweb.net/blog/setting-of-this/" title="Look Setting of this" >Setting of this</a> </li>   </ul>
  <h2 class="sidebartitle">Categories</h2>
  <ul class="list-cat">
        <li class="cat-item cat-item-4"><a href="http://www.toewsweb.net/blog/category/css/" title="View all posts filed under CSS">CSS</a> (1)
</li>
    <li class="cat-item cat-item-5"><a href="http://www.toewsweb.net/blog/category/front-end/" title="View all posts filed under Front-end">Front-end</a> (3)
</li>
    <li class="cat-item cat-item-3"><a href="http://www.toewsweb.net/blog/category/javascript/" title="View all posts filed under JavaScript">JavaScript</a> (2)
</li>
    <li class="cat-item cat-item-6"><a href="http://www.toewsweb.net/blog/category/php/" title="View all posts filed under PHP">PHP</a> (1)
</li>
  </ul>
 
  <h2 class="sidebartitle">Archives</h2>
  <ul class="list-archives">
        <li><a href='http://www.toewsweb.net/blog/2012/07/' title='July 2012'>July 2012</a></li>
  </ul>
</div>

  </div>
  <!-- Left column : end -->

  <!-- Right column : begin -->
  <div id="right_col">

    <div id="nav-container">
      <div id="site-title"><img src="./images/title.png"/></div>
      <ul class="nav">
        <li><a href="/">Home</a><li>
        <li><a href="/portfolio.php">Portfolio</a></li>
        <li><a href="/code.php">Samples</a></li>
        <li><a href="/bookshelf.php">Bookshelf</a></li>
        <li><a href="/blog">Blog</a></li>
      </ul>
    </div>

    <div id="title-container">
      <h1>Home</h1>
    </div>
    <!-- navigation : end -->


    <div id="content-wrap">
      <div id="content">
        
<script type="text/javascript" src="./js/code_samples.js"></script>

<!--
<div id="recent-blogs-box">
  <div class="tab-label">Recent Blogs</div>
  <div class="tab-content">
      </div>
</div>
-->

<div id="portfolio-highlights-box">
  <div class="tab-label">Portfolio Highlights</div>
  <div class="tab-content">
        <div class="portfolio-item">
      <p><a href="http://www.roadtripnation.org/roadtrip-project/roadtrip.php?roadtrip_id=4666" data-id="26"><img src="/portfolio/roadtripnation.jpg"/></a></p>
      <p>Roadtrip Nation</p>
    </div>
        <div class="portfolio-item">
      <p><a href="http://rtoews.gomangosteen.com/index-p2.html" data-id="18"><img src="/portfolio/gomangosteen.jpg"/></a></p>
      <p>GoMangosteen</p>
    </div>
        <div class="portfolio-item">
      <p><a href="http://cimensa.toewsweb.net" data-id="12"><img src="/portfolio/cimensa.jpg"/></a></p>
      <p>Channel Islands Mensa</p>
    </div>
        <div class="portfolio-item">
      <p><a href="http://slochurc.toewsweb.net" data-id="14"><img src="/portfolio/slochurch.jpg"/></a></p>
      <p>San Luis Obispo SDA Church</p>
    </div>
        <br style="clear:both"/>
  </div>
</div>

<div id="code-samples-box">
  <div class="tab-label">Code Samples</div>
  <div class="tab-content">
    <p>Some of this is on Github, some on my own server.  Examples of code include PHP, JavaScript, CSS, Ruby, and Python.</p>
    <div id="code_samples">
      <dl id="exhibits">
                <dt id="0"><a href="/playground/viewcode.php?which=decimal_python">Python code</a></td>
        <dd>Code for decimal calculator
          <div class="details">
            Displays Python class for decimal calculator.
          </div>
        </dd>
                <dt id="1"><a href="/playground/viewcode.php?which=fract_php">PHP Code</a></td>
        <dd>Code for Fraction Calculator
          <div class="details">
            Code for the above.  PHP does the work.
          </div>
        </dd>
                <dt id="2"><a href="/playground/jsfractioncalc.php">JavaScript</a></td>
        <dd>Fraction Calculator
          <div class="details">
            Very similar to the calculator above, except done in JavaScript.
          </div>
        </dd>
              </dl>
      <br style="clear:both"/>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#exhibits dt a").click(function() { 
        CS.openSample(this.href);
        return false; 
    });
    
    $(".portfolio-item a").click(function() { 
        CS.openSample(this.href, $(this).attr('data-id'));
        return false; 
    });
    
});
</script>

      </div>
    </div>
  </div>
  <!-- Right column : end -->

  <div id="page-footer">&nbsp;</div>

</div>
<!-- Page container: end -->

<div id="copyright">
<a href="mailto:rick@toewsweb.net">rick@toewsweb.net</a>
</div>

<style type="text/css">
</style>
<div id="overlay">
  <div id="outer_exhibit">
    <div id="inner_exhibit">
      <div id="close_exhibit"></div>
      <iframe src="/exhibit.php?id=18"></iframe>
    </div>
  </div>
</div>

</body>
</html>

