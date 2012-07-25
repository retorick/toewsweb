<?php
require_once('cgi-bin/includes/lib.inc');

$first = $_POST['first'];
$last = $_POST['last'];
$USER->checkLogin($first, $last);
$location = $ACCEPTS_COOKIES ? '/tenets.html' : '/tenets.html/' . session_id();
header("Location: $location");
?>
