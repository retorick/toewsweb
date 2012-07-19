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
  <script type="text/javascript" src="./js/fix.js"></script>
</head>
<body>
<!-- Page container : begin -->
<div id="page_container">

<!-- Left column : begin -->
  <div id="left_col">
    <img src="./smarty/images/int_{$pic}.jpg" />
  </div>
  <!-- Left column : end -->

  <!-- Right column : begin -->
  <div id="right_col">

    <div id="nav-container">
      <ul class="nav">
        <li><a href="/">Home</a><li>
        <li><a href="/portfolio.php">Portfolio</a></li>
        <li><a href="/code.php">Samples</a></li>
        <li><a href="/bookshelf.php">Bookshelf</a></li>
        <li><a href="/blog">Blog</a>
          <ul>
            <li><a href="#">Item 1</a></li>
            <li><a href="#">Item 2</a></li>
            <li><a href="#">Item 3</a></li>
            <li><a href="#">Item 4</a></li>
          </ul>
        </li>
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

  <div id="page_footer">&nbsp;</div>

</div>
<!-- Page container: end -->

</body>
</html>
