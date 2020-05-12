<?php
include "header.php";
?>

<h1>Give Us A Hand</h1>
<div id="support" class="playbox">
  Independent venues all across the nation, like Shank Hall, were the first to close and they will be the last to open. Organizations like <a href="https://www.nivassoc.org">National Independent Venue Association</a> and <a href="https://www.indiepromoter.org">Independent Promoter Alliance</a> are trying to get everyone to contact their federal, state and local authorities to help give businesses like Shank Hall support so we can come back. In the meantime, we could use a little bit of a helping hand from you, in the form of gift certificates to future shows or even a direct donation. We thank you for whatever support you can give.<br>
  <br>

  #SaveOurStages<br>
  <br>
  
  <div id="support-links">
    <a href="https://www.ticketweb.com/event/shank-hall-gift-certificate-shank-hall-tickets/10586135">Buy Gift Certificates</a>

    <form id="donation" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="new">
      <div>
        <input type="hidden" name="cmd" value="_donations">
        <input type="hidden" name="business" value="shank_hall@sbcglobal.net">
        <input type="hidden" name="item_name" value="Shank Hall Donation">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="amount" value="">
        <input type="submit" name="submit" value="Donate">
      </div>
    </form>
  </div>
</div>
<br>

<!-- <div class="spiff">Celebrating 25 years of bringing great music to Milwaukee!</div> -->

<?php if ($rightnow >= strtotime("24 February 2020 11:00am") && $rightnow <= strtotime("18 July 2020 11:00pm")) { ?>
<!-- <img src="images/bands/billy-bragg-2020.jpg" alt="Billy Bragg July 16, 17, 18" style="max-width: 100%; height: auto;"><br><br> -->
<?php } ?>

<div id="notice">
  <strong>Due to the current global health crisis as well as travel and performance restrictions the following shows have been postponed or canceled:</strong><br>
  <br>

  <div class="two-col">
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