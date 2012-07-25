<?php
$FILES = array(
    '.htaccess',
    'index.php',
    'login.php',
    'generic.css',
    'style1.css',
    'style2.css',
    'includes/icrjs.js',
    'cgi-bin/includes/lib.inc',
    'cgi-bin/classes/page.inc',
    'cgi-bin/classes/user.inc',
    'cgi-bin/pg/tenets.inc',
    'cgi-bin/pg/heritage.inc',
    'cgi-bin/pg/identify.inc',
    'icr_users'
);
?>
<html>
<head>
  <title>View Code for Web Technical Assignment</title>
  <script language="JavaScript" src="/includes/ajax.js"></script>
  <script language="JavaScript">
    function useHttpResponse_code()
    {
        var f = document.forms["data"];
        if (http.readyState == 4) {
            var code = http.responseText;
            f.showcode.value = code;
        }
    }


    function retrieveCode(file)
    {
        initAJAX('getcode.php?code=' + file, 'code');
    }
  </script>
</head>
<body>
<form name="data">
<select name="file" onchange="retrieveCode(this.options[this.selectedIndex].value)">
<option value="">File to view</option>
<?php
foreach ($FILES as $f) {
    $label = substr($f, 0, 4) == 'icr_' ? "$f (mysql table)" : $f;
    print "<option $selected value='$f'>$label</option>\n";
}
?>
</select>
<br />
<textarea name="showcode" style="background-color:#004080;color:#ffffff; width:770px; height:500px; font-family:courier; font-size:10pt;"></textarea>
</form>
</body>
</html>
