<!DOCTYPE html>
<html>
<head>
  <title>MasterMind - Computer Solves</title>
  <meta charset="UTF-8"/>
  <link rel="stylesheet" href="master.css"/>
  <script src="/jquery/jquery-1.3.2.js"></script>
  <script src="master.js"></script>
</head>
<body>
<div id="mm_container">
  <h1>MasterMind - Computer Solves</h1>
  <div id="mycode"></div>
<div id="centeredmenu">
  <ul id="colored-peg-wrapper">
    <li id="red" class="colored_peg red"></li>
    <li id="orange" class="colored_peg orange"></li>
    <li id="yellow" class="colored_peg yellow"></li>
    <li id="green" class="colored_peg green"></li>
    <li id="blue" class="colored_peg blue"></li>
    <li id="purple" class="colored_peg purple"></li>
  </ul>
  <br style="clear:both"/>
</div>
  <p>Select a four-color code.  You can click on the colors above to provide yourself with a representation.  I promise not to peak; however, if you don't trust me, you can write down your code or just remember it as the game progresses.</p>
  <div id="controls">
    <div id="score_pegs">
      <div id="black" class="score_peg"></div>
      <div id="white" class="score_peg"></div>
      <div id="score" style="cursor:pointer">score</div>
      <div id="undo" style="cursor:pointer">undo</div>
    </div>
    <div id="set_reset" style="float:left">
      <div id="set" style="cursor:pointer; text-align:center; margin-bottom:3px; padding-bottom:3px; height:16px; width:50px; background:#ff9900; font-weight:bold; color:white; border:1px solid gray">Go</div>
<!--            <div id="solved" style="cursor:pointer; text-align:center; margin-bottom:3px; padding-bottom:3px; height:16px; width:50px; background:#ff9900; font-weight:bold; color:white; border:1px solid gray">solved</div>-->
      <div id="reset" style="cursor:pointer; text-align:center; margin-bottom:3px; padding-bottom:3px; height:16px; width:50px; background:#ff9900; font-weight:bold; color:white; border:1px solid gray">reset</div>
      <div id="test" style="display:none;cursor:pointer; text-align:center; margin-bottom:3px; padding-bottom:3px; height:16px; width:50px; background:#ff9900; font-weight:bold; color:white; border:1px solid gray">test</div>
    </div>
  </div>

  <br/>
  <div id="board" style="clear:left; float:left; width:170px; height:340px; padding-right:50px; background:url(./mastermind/board.png) repeat-y;"></div>
  <div id="output" style="float:left; width:300px; height:340px; padding:3px; border:1px dashed gray; overflow-y:scroll">Running Commentary</div>
</div>
<br style="clear:left"/>
</body>
</html>
