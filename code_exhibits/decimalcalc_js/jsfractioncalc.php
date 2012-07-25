<?php
$PIC = 'b';
$HEADER = 'playground';

ob_start();
?>
<style type="text/css">
table#decimals {
    font-family:verdana;
    font-size:8pt;
    border:2px solid gray;
    border-collapse:collapse;
}

table#decimals th {
    font-weight:bold;
    border:1px solid green;
    background-color:#dddddd;
}

table#decimals td {
    border:1px solid gray;
}
table#decimals td span.non_repeating { color:#666666; }
table#decimals td span.initial_repeat { color:#000066; }
table#decimals td span.complement_repeat { color:#ff9900; }

#results {
    overflow:auto;
}
</style>
<script type="text/javascript" src="/jquery/jquery-1.3.2.js"></script>
<script type="text/javascript" src="fractioncalc.js"></script>
<script language="JavaScript">
</script>
<script type="text/javascript">
String.prototype.isPalindrome = function() {
    var str = this.replace('<br/>', '');
    if (str.length < 2) { return false; }
    var half = Math.floor(str.length / 2);
    var result = true;
    for (var i = 0; result && i < half; i++) {
        if (str.charAt(i) != str.substr(-1*(i+1), 1)) {
            result = false;
        }
    }
    return result;
}


var key_const = new function() {
    this.digit_0 = 48;
    this.digit_9 = 57;
    this.tab = 9;
    this.hyphen_pc = 109;
    this.hyphen_mac = 189;
};

function digitsOnly(e) {
    var key = e.keyCode;
//$("#output").html(key);
$("#debug").html(key);
    if (typeof digitsOnly.lastkey == "undefined") {
        digitsOnly.lastkey = null;
    }
    if ((key < key_const.digit_0 || key > key_const.digit_9) 
      && key != key_const.tab
      && key != key_const.hyphen_pc
      && key != key_const.hyphen_mac
      &&(key < 33 || key > 40) 
      && key != 12 
      && key != 45 
      && key != 8
      && digitsOnly.lastkey != 17 && digitsOnly.lastkey != 93) {
        digitsOnly.lastkey = key;
        return false;
    }
    return true;
}


$(document).ready(function() {
    $("#denominator")
        .focus(function() {
            $("#numerator").val("");
        })
        .focus();
    $("#numerator")
        .focus(function() {
            if ($("#denominator").val() && !$("#numerator").val()) {
                var numRange = "1-" + ($("#denominator").val() - 1);
                $("#numerator").val(numRange);
            }
        });
    $("#calcBtn")
        .click(function() {
            var f = document.forms["fraction"];
            var denominator = f.elements["denominator"].value;
            var numerator = f.elements["numerator"].value || "1-" + (denominator-1);

            var base = f.elements["base"].value || 10;
            var fractObj = new FractionListObj(numerator, denominator, base);
            var results = "";
            for (var num in fractObj.fraction) {
                var data = fractObj.fraction[num].decimal_data;
                results += num + "/" + denominator + " len: " + data.decimal_length + "; repeating: " + data.repeating + "; decimal: " + data.decimal + "<br/>";
            }
            $("#results").html(fractObj.formattedTable);
        });
});
</script>
<div id="output"></div>
<h1>Fraction Calculator</h1>
<form name="fraction">
<table id="fractform">
  <tr>
    <th>Numerator</th>
    <th>Denominator</th>
    <!-- th class="fg1">Base</th -->
    <th></th>
  </tr>
  <tr>
    <td><input id="numerator" type="text" name="numerator" size="9"/></td>
    <td><input id="denominator" type="text" name="denominator" size="4"/><input type="hidden" name="base" value="10"/></td>
    <td><input id="calcBtn" type="button" name="calcBtn" value="Calculate"/></td>
  </tr>
</table>
</form>
<output id="debug"></output>
<div id="results">

</div>
<div class="general">
<p>I developed this calculator so I could explore properties of fractions with prime denominators.  Conventional calculators don't provide enough decimal places to be of much use, and I don't enjoy doing this sort of thing manually.  Besides, writing a program to essentially perform long division, while also analyzing the decimal period, presented me with an interesting challenge.</p>

<p>If you want to play with this, I suggest experimenting mainly with prime denominators.  Take the 7ths, for instance.  Notice that the period length (third column) is 6 and that the number of repeating digits (fourth column) is also 6.  Though all periods of prime fractions don't have a length that's one less than the denominator, many do; and it is always true that the entire period repeats.  It can be shown that the maximum period length is one less than the denominator, and prime numbers with the maximum period length are called <em>full reptend primes</em>.</p>

<p>The period length of a prime fraction can be even or odd.  If it's even, the digits in the period can always be split into two equal groups, which are colored for convenient identification.  Try adding the two groups; e.g., for 1/7, add 142 + 857.</p>

<p>The prime numbers up to 109 are: 3, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109.  (I purposely omitted 2 and 5, since, though prime, they're both factors of the default number base of 10.)</p>

<p>A bit of trivia:  Except for 3, the length of the period for a prime fraction is the smallest string of 1s that the prime number will divide.  For instance the 13ths have a period length of 6, since the smallest such number that 13 divides is 111,111.</p>
</div>

<?php
$page_content = ob_get_clean();

ob_start();
require_once('../includes/toewsweb_template.php');
$page_template = ob_get_clean();

print $page_template;
?>
