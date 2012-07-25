<?php
include("path.inc");
$PIC = 'b';
$HEADER = 'code_samples';
$HORIZ_LINE = "<table bgcolor='#656e85' border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td background='$PATH/images/dots_horiz.gif'><img src='$PATH/images/spacer.gif' width='1' height='1'></td></tr></table>";

ob_start();
?>
<style type="text/css">
textarea {
    font-family:arial;
    font-size:10pt;
    color:#666666;
}
#check {
    width:450px;
    font-family:verdana;
    font-size:8pt;
    line-height:200%;
    color:#003399;
}
.misspelled {
    background-color:#cccccc;
    cursor:pointer;
}
</style>
<script language="JavaScript">
function getXMLAttributeValue(obj, tag, attrib) {
    var val;
    var node;
    var coll = obj.getElementsByTagName(tag);
    if (coll.length > 0) {
        val = coll[0].getAttribute(attrib);;
    }
    else {
        val = "";
    }
    return val;
}        


function getXMLElementValue(obj, tag) {
    var val;
    var node;
    var coll = obj.getElementsByTagName(tag);
    if (coll.length > 0) {
        node = coll[0].firstChild;
        val = node ? node.nodeValue : "";
    }
    else {
        val = "";
    }
    return val;
}        


function getXMLElementList(obj, tag) {
    var list = new Array();
    var node;
    var coll = obj[0].getElementsByTagName(tag);
    if (coll.length > 0) {
        for (var i = 0; i < coll.length; i++) {
            node = coll.item(i).firstChild;
            list[i] = node ? node.nodeValue : "";
        }
    }
    return list;
}        


function getSuggestions(obj) {
    var suggElem = obj.getElementsByTagName("suggestions");
    if (suggElem.length > 0) {
        suggList = getXMLElementList(suggElem, "sugword");
    }
    else {
        suggList = new Array();
    }
    return suggList;
}


function Word(o, p, l, stat, s) {
    this.original = o;
    this.pos = p;
    this.len = l;
    this.status = stat;
    this.suggestions = s;
}


function getWords(obj) {
    var wordElem = obj.getElementsByTagName("word");
    var wordList = new Array();
    var original, pos, status, suggestions;
    for (var i = 0; i < wordElem.length; i++) {
        original = getXMLElementValue(wordElem[i], "original");
        pos = getXMLAttributeValue(wordElem[i], "original", "pos");
        len = getXMLAttributeValue(wordElem[i], "original", "len");
        status = getXMLElementValue(wordElem[i], "status");
        suggestions = getSuggestions(wordElem[i]);
        wordList[i] = new Word(original, pos, len, status, suggestions);
    }
    return wordList;
}


function SpellCheckResults(xmlobj) {
    this.originaltext = getXMLElementValue(xmlobj, "originaltext");
    this.words = getWords(xmlobj);
    this.show = show;
}


function getCorrection(fld) {
    document.getElementById("correctiontool").style.display = "none";
    var correction;
    var i = fld.word;
    var lastplace = 0;
    if (fld.name == "textCorrection") {
        correction = fld.value;
    }
    else if (fld.name == "menuCorrection") {
        correction = fld.options[fld.selectedIndex].value;
    }
    else {
        correction = results.words[i].original;
    }
    before = results.originaltext.substring(lastplace, results.words[i].pos);
    lastplace = 1*results.words[i].pos + 1*results.words[i].len;
    after = results.originaltext.substr(lastplace, results.originaltext.length);
    text = before + correction + after;
    var f = document.forms["data"];
    f.text.value = text;
    spellCheck();
}


function correct(i, w) {    
    var f = document.forms["correction"];
    var menu = f.menuCorrection;
    var txt = f.textCorrection;
    txt.word = i;
    menu.word = i;
    txt.value = "";
    menu.options.length = 0;
    var list = "";
    for (var n = 0; n < results.words[i].suggestions.length; n++) {
        suggest = results.words[i].suggestions[n];
        menu.options[n] = new Option(suggest,suggest);
    }
    document.getElementById("unrecognized").innerHTML = w;
    document.getElementById("correctiontool").style.display = "";
}


function show() {
    var text = "";
    var lastplace = 0;
    for (var i = 0; i < this.words.length; i++) {
        if (this.words[i].status == -1) {
            newword = "<span class='misspelled' onclick='correct(" + i + ", \"" + this.words[i].original + "\")'>" + this.words[i].original + "</span>";
            before = this.originaltext.substring(lastplace, this.words[i].pos);
            text += before + newword;
            lastplace = 1*this.words[i].pos + 1*this.words[i].len;
        } 
    }
    var rest = this.originaltext.substr(lastplace, this.originaltext.length);
    text += rest;

    var para = text.split("\n");
    var text = "";
    for (var i = 0; i < para.length; i++) {
        if (para[i]) {
            text += "<p>" + para[i] + "</p>";
        }
    }
    document.getElementById("check").innerHTML = text;
}
</script>
<script language="JavaScript">
function useHttpResponse() {
    var xml;
    if (http.readyState == 4) {
document.getElementById("loading").style.display = "none";
        xml = http.responseXML;
        results = new SpellCheckResults(xml);
        results.show();
    }
}


function retrieveInfo(string) {
    if (navigator.appName == "Microsoft Internet Explorer") {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        http = new XMLHttpRequest();
    }
document.getElementById("loading").style.display = "";
    http.open("GET", "spellchecker.php?text=" + escape(string), true);
    http.onreadystatechange = useHttpResponse;
    http.send(null);
}


function spellCheck() {
    var string = document.forms["data"].text.value;
    retrieveInfo(string);
}


function showXML(xml) {
    var f = document.forms["data"];
    var xmlwin = open("spellchecker.php?text=" + escape(f.text.value), "xmlwin", "top=50,left=50,width=800,height=600,scrollbars");
}


sample = "It was the best of times, it was the worst of times, it was the age of wisdom, it was the age of foolishness, it was the epoch of beleif, it was the epoch of incredulity, it was the season of Light, it was the season of Darkness, it was the spring of hope, it was the winter of dispair, we had everything before us, we had nothing before us, we were all going direct to Heaven, we were all going direct the other way -- in short, the period was so far like the present period, that some of its noisiest authorities insisted on its being recieved, for good or for evil, in the superlative degree of comparison only.";

function sampleText()
{
    var f = document.forms["data"];
    f.text.value = sample;
}


function initFocus() {
    document.forms["data"].text.focus();
}

onload = initFocus;
</script>
<div class="cell">
<form name="data" method="post" action="spellchecker.php">
<h1>Spell Checker</h1>
<p>Enter some text in the field below, and click the Spell Check button.  Your text will be spell checked and displayed below the form area.  (If you'd like to see this work but would rather not bother typing, <a href="" onclick="sampleText(); return false">click here</a>.)</p>
<p>If the spell checker finds any words it doesn't recognize, those words will be highlighted for attention.  You can specify corrections by clicking on highlighted words.</p>
<p>The XML button...  This displays the XML document returned by the spell checker.</p>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><textarea name="text" cols="70" rows="8" wrap="physical"></textarea></td>
  </tr>
  <tr>
    <td>
      <p align="center">
      <input type="button" value="Spell Check" onclick="spellCheck()" />
      <input type="button" value="XML" onclick="showXML()" />
      </p>
    </td>
  </tr>
</table>
<div style="position:relative">
  <div id="loading" style="position:absolute; top:10px; left:269px; display:none"><img src="/memorize/images/loading.gif" alt="loading..." /></div>
</div>
</form>
<br />
<div id="check">
</div>

<div id="correctiontool" style="display:none">
<p><?php echo $HORIZ_LINE; ?></p>
<p>To make a correction, either enter the correct spelling in the text field and tab out of it, or select a word from the list of suggestions.  The correction will replace the misspelling.  Continue until the text is satisfactory.</p>
<form name="correction">
<table bgcolor="#cccccc" border="0" cellpadding="3" cellspacing="1">
  <tr bgcolor="#ffffff">
    <td class="cell">Unrecognized Word</td>
    <td class="cell"><span id="unrecognized" style="font-weight:bold"></span></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td class="cell">Type Correct Spelling</td>
    <td><input type="text" name="textCorrection" size="15" onblur="getCorrection(this)" /></td>
  </tr>
  <tr bgcolor="#ffffff" valign="top">
    <td class="cell">OR Select From Menu</td>
    <td>
      <select name="menuCorrection" size="5" onchange="getCorrection(this)">
      </select>
    </td>
  </tr>
</table>
</form>
</div>
</div>
<?php
$page_content = ob_get_clean();

ob_start();
require_once('./includes/toewsweb_template.php');
$page_template = ob_get_clean();

print $page_template;
?>
