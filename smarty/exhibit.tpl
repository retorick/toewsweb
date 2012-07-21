<!DOCTYPE html>
<html>
<head>
  <title>Display</title>
  <meta charset="UTF-8"/>
  <style type="text/css">
    div.container {
        overflow:hidden;
    }
    div.container > div {
        float:left;
        padding-bottom:1000px;
        margin-bottom:-1000px;
    }
    .glass-case {
        width:70%;
    }
    .glass-case > iframe {
        width:100%;
        height:500px;
    }
    .description {
        width:25%;
        background:black;
        font:12px verdana;
        color:white;
        padding:10px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="glass-case">
    <iframe src="http://api.arithmophile.com"></iframe>
  </div>
  <div class="description">
    {$desc}
  </div>
</div>
</body>
</html>
