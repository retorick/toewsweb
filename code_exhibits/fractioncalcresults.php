<?php
include("path.inc");
$PIC = 'b';
$HEADER = 'playground';
require_once('./classes/fractioncalc.php');

ob_start();

$numerator = $_REQUEST['numerator'];
$denominator = $_REQUEST['denominator'];
$base = $_REQUEST['base'];
$fractObj = new FractionListObj($numerator, $denominator, $base);
?>
<style type="text/css">
.non_repeating { color:#666666; }
.initial_repeat { color:#000066; }
.complement_repeat { color:#ff9900; }
</style>
<h1>Fraction Calculator</h1>

<p class="general">
Numerator: <?= $numerator; ?><br />
Denominator: <?= $denominator; ?><br />
Number base: <?= $base; ?><br />
</p>

<table bgcolor="<?= $borcol; ?>" border="0" cellpadding="3" cellspacing="1" width="100%">
  <tr bgcolor="<?= $bg1; ?>">
    <th class="fg1">Fraction</th>
    <th class="fg1">Decimal</th>
    <th class="fg1">Length</th>
    <th class="fg1">Repeat</th>
  </tr>
<?php 
foreach ($fractObj->fraction as $fraction) {
?>
  <tr bgcolor="<?= $bg5; ?>" valign="top">
    <td class="fg5"><?= $fraction->fraction; ?></td>
    <td class="fg5" style="max-width:350px"><?= $fraction->decimal; ?></td>
    <td class="fg5" align="center"><?= $fraction->decimal_length; ?></td>
    <td class="fg5" align="center"><?= $fraction->repeating; ?></td>
  </tr>
<?php
}
?>
</table>
<p class="cell"><a href="fractioncalc.php">Return to the Fraction Calculator</a></p>

<?php
$page_content = ob_get_clean();

ob_start();
require_once('../includes/toewsweb_template.php');
$page_template = ob_get_clean();

print $page_template;
?>
