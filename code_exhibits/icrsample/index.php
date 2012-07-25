<?php
require_once('cgi-bin/includes/lib.inc');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
  <title><?= $TITLE; ?></title>
  <link id="css" rel="stylesheet" type="text/css" href="/<?= $_SESSION['css']; ?>" />
  <script language="JavaScript" src="/includes/icrjs.js"></script>
</head>
<body>
<form id="frmStyle" method="post">
<div id="greeting">
<? if ($USER->first) { ?>
Hi, <?= $USER->first; ?>! Welcome back. (If you're not <?= $USER->first; ?> <?= $USER->last; ?>, <a href="<?= $ID_LINK; ?>">click here</a>.)
<? } else { ?>
First time here?  Please <a href="<?= $ID_LINK; ?>">introduce yourself</a>.
<? } ?>
</div>
<div id="selectstyle">
Style:
<select name="style" onchange="chooseStyle(this.options[this.selectedIndex].value)">
<?php
foreach ($STYLES as $k => $v) {
    $selected = $v == $_SESSION['css'] ? 'selected' : '';
    print "<option $selected value='$v'>$k</option>\n";
}
?>
</select>
</div>
</form>
<div id="content">
<div id="topnavHoriz">
<?= $NAVBAR['h']; ?>
</div>
<div id="topnavVert">
<?= $NAVBAR['v']; ?>
</div>
<?= $CONTENT; ?>
<div id="bottomnav">
<?= $NAVBAR['b']; ?>
</div>
</div>
<div id="extra1"><span></span></div>
</body>
</html>
