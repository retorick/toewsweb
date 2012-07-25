<?php
header("Content-type: text/html");
include('path.inc');
include("$PATH/cgi-bin/wardrobe/mensa_connect.inc");

$id = $_REQUEST['id'];

$today = date("Y-m-d");
$sql = "SELECT * FROM site_words " .
       "WHERE w_id='$id'";
$result = mysql_query($sql, $connect);
if ($row = mysql_fetch_object($result)) {
    $word = htmlspecialchars($row->w_word);
    $definition = htmlspecialchars($row->w_definition);
    print "$word<br/>"; 
    print "$definition<br/>"; 
}
?>
