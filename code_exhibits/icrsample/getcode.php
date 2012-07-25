<?php
include('/home/virtual/www/cgi-bin/wardrobe/connect.inc');
$PATH = '/home/virtual/www/icr';
$code = $_GET['code'];
if (substr($code, 0, 4) == 'icr_') {
    $sql = "SHOW CREATE TABLE $code";
    $result = mysql_query($sql, $connect);
    $lines = array();
    while ($row = mysql_fetch_row($result)) {
        $lines[] = $row[1];
    }
}
else {
    $lines = file("$PATH/$code"); 
}
print implode('', $lines);
?>
