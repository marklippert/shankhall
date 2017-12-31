<?php
// Are we coming from the schedule or someplace else? Deal with it. Yeesh.
if (isset($sshow_date) && $sshow_date != "") { $show_date = $sshow_date; }
else { $show_date = (isset($row['show_date'])) ? $row['show_date'] : ""; }
if (isset($snotice) && $snotice != "") { $notice = $snotice; }
else { $notice = (isset($row['notice'])) ? $row['notice'] : ""; }
if (isset($swmse) && $swmse != "") { $wmse = $swmse; }
else { $wmse = (isset($row['wmse'])) ? $row['wmse'] : ""; }
if (isset($ssprecher) && $ssprecher != "") { $sprecher = $ssprecher; }
else { $sprecher = (isset($row['sprecher'])) ? $row['sprecher'] : ""; }
if (isset($scascio) && $scascio != "") { $cascio = $scascio; }
else { $cascio = (isset($row['cascio'])) ? $row['cascio'] : ""; }
if (isset($seightyeightnine) && $seightyeightnine != "") { $eightyeightnine = $seightyeightnine; }
else { $eightyeightnine = (isset($row['eightyeightnine'])) ? $row['eightyeightnine'] : ""; }
if (isset($soneohtwoone) && $soneohtwoone != "") { $oneohtwoone = $soneohtwoone; }
else { $oneohtwoone = (isset($row['oneohtwoone'])) ? $row['oneohtwoone'] : ""; }
if (isset($sothersponsor) && $sothersponsor != "") { $othersponsor = $sothersponsor; }
else { $othersponsor = (isset($row['othersponsor'])) ? $row['othersponsor'] : ""; }
if (isset($sact1) && $sact1 != "") { $act1 = $sact1; }
else { $act1 = (isset($row['act1'])) ? $row['act1'] : ""; }
if (isset($sact1_url) && $sact1_url != "") { $act1_url = $sact1_url; }
else { $act1_url = (isset($row['act1_url'])) ? $row['act1_url'] : ""; }
if (isset($sact1_image) && $sact1_image != "") { $act1_image = $sact1_image; }
else { $act1_image = (isset($row['act1_image'])) ? $row['act1_image'] : ""; }
if (isset($sact1_desc) && $sact1_desc != "") { $act1_desc = $sact1_desc; }
else { $act1_desc = (isset($row['act1_desc'])) ? $row['act1_desc'] : ""; }
if (isset($sact2) && $sact2 != "") { $act2 = $sact2; }
else { $act2 = (isset($row['act2'])) ? $row['act2'] : ""; }
if (isset($sact2_url) && $sact2_url != "") { $act2_url = $sact2_url; }
else { $act2_url = (isset($row['act2_url'])) ? $row['act2_url'] : ""; }
if (isset($sact2_image) && $sact2_image != "") { $act2_image = $sact2_image; }
else { $act2_image = (isset($row['act2_image'])) ? $row['act2_image'] : ""; }
if (isset($sact2_desc) && $sact2_desc != "") { $act2_desc = $sact2_desc; }
else { $act2_desc = (isset($row['act2_desc'])) ? $row['act2_desc'] : ""; }
if (isset($sact2_minor) && $sact2_minor != "") { $act2_minor = $sact2_minor; }
else { $act2_minor = (isset($row['act2_minor'])) ? $row['act2_minor'] : ""; }
if (isset($sact3) && $sact3 != "") { $act3 = $sact3; }
else { $act3 = (isset($row['act3'])) ? $row['act3'] : ""; }
if (isset($sact3_url) && $sact3_url != "") { $act3_url = $sact3_url; }
else { $act3_url = (isset($row['act3_url'])) ? $row['act3_url'] : ""; }
if (isset($sact3_image) && $sact3_image != "") { $act3_image = $sact3_image; }
else { $act3_image = (isset($row['act3_image'])) ? $row['act3_image'] : ""; }
if (isset($sact3_desc) && $sact3_desc != "") { $act3_desc = $sact3_desc; }
else { $act3_desc = (isset($row['act3_desc'])) ? $row['act3_desc'] : ""; }
if (isset($sact3_minor) && $sact3_minor != "") { $act3_minor = $sact3_minor; }
else { $act3_minor = (isset($row['act3_minor'])) ? $row['act3_minor'] : ""; }
if (isset($sact4) && $sact4 != "") { $act4 = $sact4; }
else { $act4 = (isset($row['act4'])) ? $row['act4'] : ""; }
if (isset($sact4_url) && $sact4_url != "") { $act4_url = $sact4_url; }
else { $act4_url = (isset($row['act4_url'])) ? $row['act4_url'] : ""; }
if (isset($sact4_image) && $sact4_image != "") { $act4_image = $sact4_image; }
else { $act4_image = (isset($row['act4_image'])) ? $row['act4_image'] : ""; }
if (isset($sact4_desc) && $sact4_desc != "") { $act4_desc = $sact4_desc; }
else { $act4_desc = (isset($row['act4_desc'])) ? $row['act4_desc'] : ""; }
if (isset($sact4_minor) && $sact4_minor != "") { $act4_minor = $sact4_minor; }
else { $act4_minor = (isset($row['act4_minor'])) ? $row['act4_minor'] : ""; }
if (isset($stime) && $stime != "") { $time = $stime; }
else { $time = (isset($row['time'])) ? $row['time'] : ""; }
if (isset($scover) && $scover != "") { $cover = $scover; }
else { $cover = (isset($row['cover'])) ? $row['cover'] : ""; }
if (isset($stickets) && $stickets != "") { $tickets = $stickets; }
else { $tickets = (isset($row['tickets'])) ? $row['tickets'] : ""; }
?>
<div class="popup-scroll">
  <div class="popup-date"><?php echo date("F j, Y",$show_date); ?></div>

  <div class="popup-title">
    <?php
    if ($notice == "soldout") echo "<span style=\"color: #000000;\">SOLD OUT</span><br>\n";

    if (!empty($wmse)) echo "<a href=\"http://www.wmse.org\"><img src=\"images/wmse.jpg\" alt=\"WMSE\"></a>\n";
    if (!empty($sprecher)) echo "<a href=\"http://www.sprecherbrewery.com\"><img src=\"images/sprecher.jpg\" alt=\"Sprecher\"></a>\n";
    if (!empty($cascio)) echo "<a href=\"http://www.interstatemusic.com\"><img src=\"images/cascio.png\" alt=\"Cascio Interstate Music\"></a>\n";
    if (!empty($eightyeightnine)) echo "<a href=\"http://www.radiomilwaukee.org\"><img src=\"images/88nine.jpg\" alt=\"88NINE\"></a>\n";
    if (!empty($oneohtwoone)) echo "<a href=\"http://www.fm1021milwaukee.com\"><img src=\"images/102point1.jpg\" alt=\"102.1\"></a>\n";
    if (!empty($othersponsor)) echo "<img src=\"images/" . $row['othersponsor'] . "\" alt=\"\">\n";

    echo (empty($act1_url)) ? $act1 : "<a href=\"" . $act1_url . "\">" . $act1 . "</a>";

    if ($act2 != "") {
      echo (empty($act2_minor)) ? ", " : "<br>\n<span style=\"font-size: 75%;\">";
      echo (empty($act2_url)) ? $act2 : "<a href=\"" . $act2_url . "\">" . $act2 . "</a>";
    }
    if ($row['act3'] != "") {
      echo (empty($act2_minor) && !empty($act3_minor)) ? "<br>\n<span style=\"font-size: 75%;\">" : ", ";
      echo (empty($act3_url)) ? $act3 : "<a href=\"" . $act3_url . "\">" . $act3 . "</a>";
    }
    if ($row['act4'] != "") {
      echo (empty($act2_minor) && empty($act3_minor) && !empty($act4_minor)) ? "<br>\n<span style=\"font-size: 75%;\">" : ", ";
      echo (empty($act4_url)) ? $act4 : "<a href=\"" . $act4_url . "\">" . $act4 . "</a>";
    }
    if (!empty($act2_minor) || !empty($act3_minor) || !empty($act4_minor)) echo "</span>\n";
    ?>
  </div> <!-- END popup-title -->

  <div class="popup-time">
    <?php
    if (!empty($time)) echo $time;
    if (!empty($time) && !empty($cover)) echo " &nbsp; ";
    if (!empty($cover)) echo $cover;
    
    if (strpos($tickets, 'ticketweb') !== false && $notice != "soldout" && $notice != "canceled") echo "<a href=\"" . $tickets . "\"><img src=\"images/ticketweb.png\" alt=\"TicketWeb\"></a>";
    if (strpos($tickets, 'ticketmaster') !== false && $notice != "soldout" && $notice != "canceled") echo "<a href=\"" . $tickets . "\"><img src=\"images/ticketmaster.png\" alt=\"TicketMaster\"></a>";
    ?>
  </div> <!-- END popup-time -->
  
  <?php
  // Act 1 image
  if ($act1_image != "")
    echo "<img src=\"images/bands/" . $act1_image . "?" . time() . "\" alt=\"" . strip_tags($act1) . "\" class=\"popup-img-center\">\n";

  // Act 1 description
  if ($act1_desc != "") echo str_replace("\n", "<br>", $act1_desc);

  // If there's an act 2, display it
  if (($act2_image != "") || ($act2_desc != "")) {
    echo "<div style=\"clear: both;\"></div>\n<hr style=\"margin: 1em 0;\">\n";

    // Act 2 image
    if ($act2_image != "")
      echo "<img src=\"images/bands/" . $act2_image . "?" . time() . "\" alt=\"" . strip_tags($act2) . "\" class=\"popup-img-center\">\n";

    // Act 2 description
    if ($act2_desc != "") echo str_replace("\n", "<br>", $act2_desc);
  }

  // If there's an act 3, display it
  if (($act3_image != "") || ($act3_desc != "")) {
    echo "<div style=\"clear: both;\"></div>\n<hr style=\"margin: 1em 0;\">\n";

    // Act 3 image
    if ($act3_image != "")
      echo "<img src=\"images/bands/" . $act3_image . "?" . time() . "\" alt=\"" . strip_tags($act3) . "\" class=\"popup-img-center\">\n";

    // Act 3 description
    if ($act3_desc != "") echo str_replace("\n", "<br>", $act3_desc);
  }

  // If there's an act 4, display it
  if (($act4_image != "") || ($act4_desc != "")) {
    echo "<div style=\"clear: both;\"></div>\n<hr style=\"margin: 1em 0;\">\n";

    // Act 4 image
    if ($act4_image != "")
      echo "<img src=\"images/bands/" . $act4_image . "?" . time() . "\" alt=\"" . strip_tags($act4) . "\" class=\"popup-img-center\">\n";

    // Act 4 description
    if ($act4_desc != "") echo str_replace("\n", "<br>", $act4_desc);
  }
  ?>
</div> <!-- END popup-scroll -->