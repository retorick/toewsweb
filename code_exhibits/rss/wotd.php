<?php
header("Content-type: text/xml");
include('path.inc');
include("$PATH/cgi-bin/wardrobe/mensa_connect.inc");
?>
<rss version="2.0">
  <channel>
    <title>A Sampler of Challenging Words</title>
    <link>http://www.toewsweb.net/rss/wotd.php</link>
    <description>A few probably challenging, possibly unfamiliar, words drawn at random from a database containing several thousand.</description>
    <pubDate><?= date("D, d M Y H:i:s O"); ?></pubDate>
    <language>en</language>

<?php
$today = date("Y-m-d");
$sql = "SELECT * FROM site_words 
        ORDER BY RAND()
        LIMIT 1, 5";
$result = mysql_query($sql, $connect);
while ($row = mysql_fetch_object($result)) {
    $id = $row->w_id;
    $word = htmlspecialchars($row->w_word);
    $definition = htmlspecialchars($row->w_definition);
?>
      <item>
        <title><?= $word; ?></title>
        <link>http://www.toewsweb.net/rss/words.php?id=<?= $id; ?></link>
        <description><?= $definition; ?></description>
      </item>
<?php
}
?>
  </channel>
</rss>

