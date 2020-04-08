<?php
$PageTitle = "Tickets";
include "header.php";
?>

<h1>Tickets</h1>

So, you're afraid the show might sell out, and you wanna make sure you can get in.  Advance tickets are available for many of the shows.<br>
<br>

<a href="http://www.ticketweb.com"><img src="images/ticketweb.png" alt="TicketWeb" class="right"></a>
  
<a href="http://www.ticketweb.com">TicketWeb</a> sells tickets to many Shank Hall shows.  There are several ways to get ahold of them:<br>

<ul>
  <li>Visit their website at <a href="http://www.ticketweb.com/snl/VenueListings.action?venueId=235395">www.ticketweb.com</a>.</li>
  <li>Charge by phone at 866-468-3401.</li>
</ul>

<br>

You can also buy tickets right at Shank Hall.  Our box office is open on Tuesdays from 11am to 2pm and during all scheduled show dates.  We accept Visa, MasterCard and cold hard cash.  Tickets must be purchased in person; sorry, but we are unable accept credit cards over the phone.<br>
<br>
<br>

<h1>Upcoming Shows</h1>
<?php
$tfloat = "";
$result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = '' AND tickets != '' AND notice != 'canceled' AND notice != 'postponed' AND notice != 'soldout' ORDER BY show_date ASC");

while($row = $result->fetch_array(MYSQLI_BOTH)) {
  $tfloat = ($tfloat == "right" || $tfloat == "") ? "left" : "right";
  ?>
  <div class="playbox ticket-<?php echo $tfloat; ?>">
    <div class="ticket-datebox">
      <div class="ticket-month"><?php echo date("M", $row['show_date']); ?></div>
      <div class="ticket-date"><?php echo date("d", $row['show_date']); ?></div>
      <div class="ticket-day"><?php echo date("D", $row['show_date']); ?></div>
    </div>

    <?php
    if (($row['act1_image'] != "") || ($row['main_image'] != "")) {
      // Which image are we using?
      $img = (empty($row['main_image'])) ? "images/bands/" . $row['act1_image'] : "images/bands/" . $row['main_image'];
    }
    ?>
    <div class="playbox-img" style="background-image: url(<?php echo $img; ?>);"></div>

    <?php
    if (empty($row['main_text'])) {
      $event = strip_tags($row['act1']);
      if ($row['act2'] != "") $event .= ", " . strip_tags($row['act2']);
      if ($row['act3'] != "") $event .= ", " . strip_tags($row['act3']);
      if ($row['act4'] != "") $event .= ", " . strip_tags($row['act4']);
    } else {
      $event = $row['main_text'];
    }

    echo "<a href=\"" . $row['tickets'] . "\" style=\"text-decoration: none; font-weight: bold;\">$event</a>";
    
    echo "<div class=\"ticket-time\">\n";
      if ($row['time']) echo "\n" . $row['time'] . "<br>";
      if ($row['time']) echo "\n" . $row['cover'];
    echo "</div>\n";

    echo "<a href=\"" . $row['tickets'] . "\" class=\"ticket-link\">GET TICKETS &raquo;</a>";
    ?>

    <div style="clear: both;"></div>
  </div> <!-- END playbox -->
  <?php
  if ($tfloat == "right") echo "<div style=\"clear: both;\"></div>\n";
}
$result->close();
?>

<div style="clear: both;"></div>

<?php include "footer.php"; ?>