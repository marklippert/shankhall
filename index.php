<?php
include "header.php";
?>

<!-- <div class="spiff">Celebrating 25 years of bringing great music to Milwaukee!</div> -->

<?php if ($rightnow >= strtotime("24 February 2020 11:00am") && $rightnow <= strtotime("18 July 2020 11:00pm")) { ?>
<!-- <img src="images/bands/billy-bragg-2020.jpg" alt="Billy Bragg July 16, 17, 18" style="max-width: 100%; height: auto;"><br><br> -->
<?php } ?>

<div id="notice">
  <strong>Due to the current global health crisis as well as travel and performance restrictions the following shows have been postponed or canceled:</strong><br>
  <br>

  <div class="two-col">
    March 16 Flying Buffaloes - new date Aug 5<br>
    March 18 Ward Davis - new date Sept 9<br>
    March 19 The Nielsen Trust - new Dec 12<br>
    March 20 Jeffrey Gaines - new date July 19<br>
    March 21 No Quarter - new date Nov 6<br>
    March 25 Joe Louis Walker - new date Aug 27<br>
    March 27 Koch Marshall Trio - new date Dec 5<br>
    March 28 Brand X - new date Sept 20<br>
    April 1 Tinsley Ellis - new date Sept 30<br>
    April 2 The Claudettes - new date Oct 8<br>
    April 3 Diver Down, NightSnake - new date Aug 8<br>
    April 4 Jagged Little Pill, etc - new date Oct 30<br>
    April 8 Shawn Mullins - new date Oct 28<br>
    April 10 The Lovin' Kind, etc - new date Fall TBA<br>
    April 17 Altered 5 Blues Band - new date Oct 9<br>
    April 18 Benjamin Trick - new date Jan 16, 2021<br>
    April 19 The Mighty Pines - new date TBA<br>
    April 21 Yak Attack - new date Sept 29<br>
    April 23 Jazz is Phsh - new date Oct 20<br>
    April 24 Frank Marino - new date Sept 28<br>
    April 25 New Wave Fest - new date July 31<br>
    April 29 The Minks - new date Aug 13<br>
    April 30 24-7 Spyz - new date July 21<br>
    May 1 Pundamonium - new date Sept 25<br>
    May 4 Cold - new date Oct 31<br>
    May 7 Moonshine Bandits - new date Sept 11<br>
    May 8 Cowboy Mouth - new date July 24<br>
    May 9 Super-Unknown, etc - new date Oct 10<br>
    May 14 Stu Larsen - new date 2021 TBA<br>
    May 15 Katie Toupin - new date Aug 28<br>
    May 16 Monochrome Set - new date Sept 5<br>
    May 22 Stay Outside - new date TBA<br>
    May 23 Cloud Zero - new date TBA<br>
    May 29 Steve Hofstetter - new date TBA<br>
    June 4 Steve Forbert - new date Sept 13<br>
    June 5 Webb Wilder - new date Aug 29<br>
    June 6 Mutlu - new date Feb 27, 2021<br>
    June 19 The Get Happy!! - new date July 11<br>
    June 20 Chris Duarte Group - new date TBA<br>
    <br>
    
    March 30 Talisk is canceled<br>
    April 11 Jay Anderson is canceled<br>
    May 3 Pierre Bensusan is canceled<br>
    May 2 Wayne Baker Brooks is canceled<br>
    May 27 Jesus Jones is canceled<br>
    May 31 Andrew Rivers is canceled<br>
    June 6 James Lee Stanley is canceled<br>
    June 13 Bettye LaVette is canceled
  </div>
  <br>

  Previously purchased tickets will be honored for new event dates.
</div>

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
$TheUrl = "https://shankhall.com";

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