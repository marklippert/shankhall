<?php
include "header.php";
?>

<!-- <div class="spiff">Celebrating 25 years of bringing great music to Milwaukee!</div> -->

<h1>Upcoming Shows</h1>
<?php
$result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = '' AND playbox = '' ORDER BY show_date ASC LIMIT 3");
while($row = $result->fetch_array(MYSQLI_BOTH)) {
  include "playbox.php";

  // Get IDs of upcoming shows to make sure we don't show them in Recently Added Shows section
  $uc_row[] = $row['id'];
}
$result->close();
?>

<br><br>

<?php if (strtotime("now") <= strtotime("13 February 2015 9:00pm")) { ?>
<a href="http://southmilwaukeepac.org/event/the-pedrito-martinez-group-featuring-ariacne-trujillo/"><img src="images/20150213.jpg" alt="" style="max-width: 100%; margin-bottom: 3em;"></a><br>
<?php } ?>

<h1>Recently Added Shows</h1>
<?php
// Get total number of upcoming shows
$num_rows = mysqli_num_rows($mysqli->query("SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = '' AND sticky != 'unsticky'"));

// Set how many recently added shows we'll display based on total shows
$limit = 13;
if ($num_rows < 38) $limit = 11;
if ($num_rows < 32) $limit = 9;
if ($num_rows < 26) $limit = 6;
if ($num_rows < 20) $limit = 4;

// Clear old view so the correct limit is used
$mysqli->query("DROP TABLE temptab");

// Create view to get reverse sort sticky and embargo_date
$mysqli->query("CREATE TABLE temptab AS SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = '' AND donttweet = '' AND sticky != 'unsticky' AND act1_image != '' AND id != '" . $uc_row[0] . "' AND id != '" . $uc_row[1] . "' AND id != '" . $uc_row[2] . "' ORDER BY sticky DESC, embargo_date DESC, id DESC LIMIT $limit");

// Sort limited results by actual date and feed to display function
$result = $mysqli->query("SELECT * FROM temptab ORDER BY show_date ASC");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_BOTH)) {
    include "playbox.php";
  }
  $result->close();
}
?>

<br><br>

<?php
$result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = 'yes' ORDER BY show_date ASC");
if ($result->num_rows != 0) {
  echo "<h1>Alternative Concert Group Presents</h1>\n";
  while($row = $result->fetch_array(MYSQLI_BOTH)) {
    include "playbox.php";

    echo "<div id=\"popup" . $row['id'] . "\" class=\"popup-box mfp-hide\">\n";
      include "popup.php";
    echo "</div> <!-- END popup-box -->\n";
  }
}
$result->close();
?>

<br>

<a href="rent.php"><img src="images/rent.png" alt="Rent Shank Hall" id="rent"></a>

<?php
// Create RSS feed
$TheUrl = "http://www.shankhall.com";

$TheFeed = "<?xml version='1.0'?>\n<rss version=\"2.0\">
  <channel>
    <title>Shank Hall</title>
    <link>$TheUrl</link>
    <description>Upcoming events at Shank Hall</description>\n";

$result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = '' AND notice != 'canceled' ORDER BY show_date ASC");
while($row = $result->fetch_array(MYSQLI_BOTH)) {
  // Clear the variable
  $event = "";

  $event .= strip_tags($row['act1']);
  if ($row['act2'] != "") $event .= ", " . strip_tags($row['act2']);
  if ($row['act3'] != "") $event .= ", " . strip_tags($row['act3']);
  if ($row['act4'] != "") $event .= ", " . strip_tags($row['act4']);

  // Act 1 image
  if ($row['act1_image'] != "") {
    $desc = "<img src=\"$TheUrl/images/bands/" . $row['act1_image'] . "\" alt=\"" . strip_tags($row['act1']) . "\" style=\"";
    list($width, $height, $type, $attr) = getimagesize("images/bands/" . $row['act1_image']);
    $desc .= ($width > 250) ? "display: block; margin: 0 auto;\"><br>" : "float: left; padding-right: 10px;\">";
  }

  // Act 1 description
  if ($row['act1_desc'] != "") $desc .= str_replace("\n", "<br>", $row['act1_desc']);

  // If there's an act 2, display it
  if (($row['act2_image'] != "") || ($row['act2_desc'] != "")) {
    $desc .= "\n<hr>\n";

    // Act 2 image
    if ($row['act2_image'] != "") {
      $desc .= "<img src=\"$TheUrl/images/bands/" . $row['act2_image'] . "\" alt=\"" . strip_tags($row['act2']) . "\" style=\"";
      list($width, $height, $type, $attr) = getimagesize("images/bands/" . $row['act2_image']);
      $desc .= ($width > 250) ? "display: block; margin: 0 auto;\"><br>" : "float: left; padding-right: 10px;\">";
    }

    // Act 2 description
    if ($row['act2_desc'] != "") $desc .= str_replace("\n", "<br>", $row['act2_desc']);
  }

  // If there's an act 3, display it
  if (($row['act3_image'] != "") || ($row['act3_desc'] != "")) {
    $desc .= "\n<hr>\n";

    // Act 3 image
    if ($row['act3_image'] != "") {
      $desc .= "<img src=\"$TheUrl/images/bands/" . $row['act3_image'] . "\" alt=\"" . strip_tags($row['act3']) . "\" style=\"";
      list($width, $height, $type, $attr) = getimagesize("images/bands/" . $row['act3_image']);
      $desc .= ($width > 250) ? "display: block; margin: 0 auto;\"><br>" : "float: left; padding-right: 10px;\">";
    }

    // Act 3 description
    if ($row['act3_desc'] != "") $desc .= str_replace("\n", "<br>", $row['act3_desc']);
  }

  // If there's an act 4, display it
  if (($row['act4_image'] != "") || ($row['act4_desc'] != "")) {
    $desc .= "\n<hr>\n";

    // Act 4 image
    if ($row['act4_image'] != "") {
      $desc .= "<img src=\"$TheUrl/images/bands/" . $row['act4_image'] . "\" alt=\"" . strip_tags($row['act4']) . "\" style=\"";
      list($width, $height, $type, $attr) = getimagesize("images/bands/" . $row['act4_image']);
      $desc .= ($width > 250) ? "display: block; margin: 0 auto;\"><br>" : "float: left; padding-right: 10px;\">";
    }

    // Act 4 description
    if ($row['act4_desc'] != "") $desc .= str_replace("\n", "<br>", $row['act4_desc']);
  }

  $TheFeed .= "<item>
    <title>" . date("F j",$row['show_date']) . " - " . htmlspecialchars($event) . "</title>
    <link>$TheUrl/details.php?" . $row['id'] . "</link>
    <description><![CDATA[$desc]]></description>
    <guid>" . $row['show_date'] . "</guid>
    <pubDate>" . date("r", $row['embargo_date']) . "</pubDate>
  </item>\n";
}

$TheFeed .= "  </channel>\n</rss>";

$file= fopen("rssfeed.xml", "w");
fwrite($file, $TheFeed);
fclose($file);

$result->close();
?>

<?php include "footer.php"; ?>