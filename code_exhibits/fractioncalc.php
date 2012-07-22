<?php
include("path.inc");
$PIC = 'b';
$HEADER = 'playground';

ob_start();
?>
<script language="JavaScript">
function calculate(f) {
  var f = document.forms["fraction"];
  f.submit();
}
</script>
<h1>Fraction Calculator</h1>

<form name="fraction" method="post" action="fractioncalcresults.php">
<div align="center">
<table bgcolor="<?php echo $borcol; ?>" border="0" cellpadding="3" cellspacing="1">
  <tr bgcolor="<?php echo $bg1; ?>">
    <th class="fg1">Numerator</th>
    <th class="fg1">Denominator</th>
    <th class="fg1">Base</th>
    <th></th>
  </tr>
  <tr bgcolor="<?php echo $bg5; ?>">
    <td class="fg5"><input type="text" name="numerator" size="9"></td>
    <td class="fg5"><input type="text" name="denominator" size="9"><input type="hidden" name="base_x" value="8" /></td>
    <td class="fg5">
      <select name="base">
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option selected>10</option>
      </select>
    </td>
    <td align="center" colspan="3" class="fg5"><input type="button" name="Calculate" value="Calculate" onclick="calculate(this.form)"></td>
  </tr>
</table>
</div>
</form>
<div class="general">
<p>There are interesting and unexpected patterns to be observed in the decimal equivalents of many fractions.  Unfortunately, most calculators are limited to fewer than 16 digits, which makes it difficult to study the properties of decimals that have longer periods.  In general, one must simply calculate the decimal by hand, which can be tedious and inaccurate at times.</p>

<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td background="<?php echo $PATH; ?>/images/dot_horiz.gif"><img src="<?php echo $PATH; ?>/images/spacer.gif" width="1" height="1"></td></tr></table>

<img src="<?php echo $PATH; ?>/images/spacer.gif" width="1" height="6"><br>

<p>Decimals come in a variety of flavors.</p>

<ul>
<li>There are those that have a single, non-repeating pattern.  Examples include 1/2 (.5), 1/4 (.25), 5/8 (.625), 1/1000 (.001).</li>
<li>There are those that have a simple repeating pattern, which can be one or more digits in length.  Examples include 1/3 (.<font color="#262A46">3</font>), 1/31 (.<font color="#262A46">032258064516129</font>), 1/27 (.<font color="#262A46">037</font>).  I use <font color="#262A46">dark blue</font> to indicate that the digits repeat.)</li>
<li>Among those that have a repeating pattern, many exhibit a characteristic to which I refer as <i>9s complement</i>:  the pattern has an even number of digits; and the digits in the first half, added to the digits in the second half, equals a number composed of all 9s.  Examples include 1/7 (.<font color="#262A46">142</font><font color="#ff9900">857</font>), 3/11 (.<font color="#262A46">2</font><font color="#ff9900">7</font>), 1/17 (.<font color="#262A46">05882352</font><font color="#ff9900">94117647</font>).  (<font color="#262A46">Dark blue</font> or <font color="#ff9900">orange</font> indicates that the digits repeat.  The digits in the first half of the decimal are <font color="#262A46">dark blue</font>, and the digits in the second half are <font color="#ff9900">orange</font>.  Add the two halves, and the result is all 9s.)</li>
<li>There are also hybrids:  decimals in which a non-repeating pattern is followed by a pattern that repeats.  Examples include 1/6 (.1<font color="#262A46">6</font>), 5/12 (.41<font color="#262A46">6</font>), 3/28 (.10<font color="#262A46">714</font><font color="#ff9900">285</font>).</li>
</ul>

<p>To use this application, fill in the numerator and the denominator in the form above, make sure the base set to the one you want to use, and click the <b>Calculate</b> button.  Currently, the application does not check your entry, so make sure the numbers you enter are consistent with the base (e.g., 0-9 for base 10).</p>

<p>You can use a hyphen to enter a range of numbers for the numerator.</p>
</div>

<?php
$page_content = ob_get_clean();

ob_start();
require_once('../includes/toewsweb_template.php');
$page_template = ob_get_clean();

print $page_template;
?>
