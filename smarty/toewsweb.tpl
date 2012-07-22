{if !$pic}
    {$pic = 'b'}
{/if}
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <title>{$site_title} - {$page_title}</title>
  <link rel="stylesheet" href="./css/style.css"/>
  <link rel="stylesheet" href="./css/home.css"/>
  <link rel="stylesheet" href="./css/portfolio.css"/>
  <link rel="stylesheet" href="./css/code_samples.css"/>
  <link rel="stylesheet" href="./css/bookshelf.css"/>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="./js/spin.min.js"></script>
  <script type="text/javascript" src="./js/toewsweb.js"></script>
  <script type="text/javascript" src="./js/fix.js"></script>
</head>
<body>
<!-- Page container : begin -->
<div id="page_container">

<!-- Left column : begin -->
  <div id="left_col">
    <img src="./images/int_{$pic}.jpg" />
    {$sidebar}
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
      <h1>{$page_title}</h1>
    </div>
    <!-- navigation : end -->


    <div id="content-wrap">
      <div id="content">
        {block name=content}{/block}
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

<div id="overlay">
  <div id="outer_exhibit">
    <div id="inner_exhibit">
      <iframe id="exhibit_frame" src="/exhibit.php?id=26"></iframe>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
/*
    For spin.js; code taken from http://fgnass.github.com/spin.js/
*/
var opts = {
  lines: 13, // The number of lines to draw
  length: 18, // The length of each line
  width: 10, // The line thickness
  radius: 24, // The radius of the inner circle
  rotate: 0, // The rotation offset
  color: '#999', // #rgb or #rrggbb
  speed: 1, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: 'auto', // Top position relative to parent in px
  left: 'auto' // Left position relative to parent in px
};
var target = document.getElementById('inner_exhibit');
var spinner = new Spinner(opts).spin(target);
});
</script>
</body>
</html>
