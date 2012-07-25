<?
$MAILSERVER = 'mail.toewsweb.net';
$USER = 'rick@toewsweb.net';
$PASS = '153846';
$PORT = 110;

$fp = fsockopen($MAILSERVER, $PORT, $errno, $errstr, 30);
$LOGIN = "user $USER\n";
$LOGIN2 = "user $USER\npass $PASS\nLIST\nQUIT\n";
$i = 0;
if ($fp) {
    fputs($fp, $LOGIN2);
    while (!feof($fp)) {
        $line = fgets($fp, 1024);
print "$i: $line \n";
$i++;
    }

}
fclose($fp);
print "Done";
?>
