<?php
// Are we coming from the schedule or someplace else? Deal with it. Yeesh.
$show_date = ($row['show_date'] != "") ? $row['show_date'] : $eventarr[$day_num][0]['show_date'];
$notice = ($row['notice'] != "") ? $row['notice'] : $eventarr[$day_num][0]['notice'];
$wmse = ($row['wmse'] != "") ? $row['wmse'] : $eventarr[$day_num][0]['wmse'];
$sprecher = ($row['sprecher'] != "") ? $row['sprecher'] : $eventarr[$day_num][0]['sprecher'];
$cascio = ($row['cascio'] != "") ? $row['cascio'] : $eventarr[$day_num][0]['cascio'];
$eightyeightnine = ($row['eightyeightnine'] != "") ? $row['eightyeightnine'] : $eventarr[$day_num][0]['eightyeightnine'];
$oneohtwoone = ($row['oneohtwoone'] != "") ? $row['oneohtwoone'] : $eventarr[$day_num][0]['oneohtwoone'];
$othersponsor = ($row['othersponsor'] != "") ? $row['othersponsor'] : $eventarr[$day_num][0]['othersponsor'];
$act1 = ($row['act1'] != "") ? $row['act1'] : $eventarr[$day_num][0]['act1'];
$act1_url = ($row['act1_url'] != "") ? $row['act1_url'] : $eventarr[$day_num][0]['act1_url'];
$act1_image = ($row['act1_image'] != "") ? $row['act1_image'] : $eventarr[$day_num][0]['act1_image'];
$act1_desc = ($row['act1_desc'] != "") ? $row['act1_desc'] : $eventarr[$day_num][0]['act1_desc'];
$act2 = ($row['act2'] != "") ? $row['act2'] : $eventarr[$day_num][0]['act2'];
$act2_url = ($row['act2_url'] != "") ? $row['act2_url'] : $eventarr[$day_num][0]['act2_url'];
$act2_image = ($row['act2_image'] != "") ? $row['act2_image'] : $eventarr[$day_num][0]['act2_image'];
$act2_desc = ($row['act2_desc'] != "") ? $row['act2_desc'] : $eventarr[$day_num][0]['act2_desc'];
$act2_minor = ($row['act2_minor'] != "") ? $row['act2_minor'] : $eventarr[$day_num][0]['act2_minor'];
$act3 = ($row['act3'] != "") ? $row['act3'] : $eventarr[$day_num][0]['act3'];
$act3_url = ($row['act3_url'] != "") ? $row['act3_url'] : $eventarr[$day_num][0]['act3_url'];
$act3_image = ($row['act3_image'] != "") ? $row['act3_image'] : $eventarr[$day_num][0]['act3_image'];
$act3_desc = ($row['act3_desc'] != "") ? $row['act3_desc'] : $eventarr[$day_num][0]['act3_desc'];
$act3_minor = ($row['act3_minor'] != "") ? $row['act3_minor'] : $eventarr[$day_num][0]['act3_minor'];
$act4 = ($row['act4'] != "") ? $row['act4'] : $eventarr[$day_num][0]['act4'];
$act4_url = ($row['act4_url'] != "") ? $row['act4_url'] : $eventarr[$day_num][0]['act4_url'];
$act4_image = ($row['act4_image'] != "") ? $row['act4_image'] : $eventarr[$day_num][0]['act4_image'];
$act4_desc = ($row['act4_desc'] != "") ? $row['act4_desc'] : $eventarr[$day_num][0]['act4_desc'];
$act4_minor = ($row['act4_minor'] != "") ? $row['act4_minor'] : $eventarr[$day_num][0]['act4_minor'];
$time = ($row['time'] != "") ? $row['time'] : $eventarr[$day_num][0]['time'];
$cover = ($row['cover'] != "") ? $row['cover'] : $eventarr[$day_num][0]['cover'];
$tickets = ($row['tickets'] != "") ? $row['tickets'] : $eventarr[$day_num][0]['tickets'];
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
    
    if (substr($tickets, 0, 20) == "http://www.ticketweb" && $notice != "soldout" && $notice != "canceled")
      echo "<a href=\"" . $tickets . "\"><img src=\"images/ticketweb.png\" alt=\"TicketWeb\"></a>";
    if (substr($tickets, 0, 20) == "http://www.ticketmas" && $notice != "soldout" && $notice != "canceled")
      echo "<a href=\"" . $tickets . "\"><img src=\"images/ticketmaster.png\" alt=\"TicketMaster\"></a>";
    ?>
  </div> <!-- END popup-time -->
  
  <?php
  // Act 1 image
  if ($act1_image != "") {
    list($width, $height, $type, $attr) = getimagesize("images/bands/" . $act1_image);
    $imgstyle = ($width > 250) ? "popup-img-center" : "popup-img-left";
    echo "<img src=\"images/bands/" . $act1_image . "\" alt=\"" . strip_tags($act1) . "\" class=\"$imgstyle\">\n";
  }

  // Act 1 description
  if ($act1_desc != "") echo str_replace("\n", "<br>", $act1_desc);

  // If there's an act 2, display it
  if (($act2_image != "") || ($act2_desc != "")) {
    echo "<div style=\"clear: both;\"></div>\n<hr style=\"margin: 1em 0;\">\n";

    // Act 2 image
    if ($act2_image != "") {
      list($width, $height, $type, $attr) = getimagesize("images/bands/" . $act2_image);
      $imgstyle = ($width > 250) ? "popup-img-center" : "popup-img-left";
      echo "<img src=\"images/bands/" . $act2_image . "\" alt=\"" . strip_tags($act2) . "\" class=\"$imgstyle\">\n";
    }

    // Act 2 description
    if ($act2_desc != "") echo str_replace("\n", "<br>", $act2_desc);
  }

  // If there's an act 3, display it
  if (($act3_image != "") || ($act3_desc != "")) {
    echo "<div style=\"clear: both;\"></div>\n<hr style=\"margin: 1em 0;\">\n";

    // Act 3 image
    if ($act3_image != "") {
      list($width, $height, $type, $attr) = getimagesize("images/bands/" . $act3_image);
      $imgstyle = ($width > 250) ? "popup-img-center" : "popup-img-left";
      echo "<img src=\"images/bands/" . $act3_image . "\" alt=\"" . strip_tags($act3) . "\" class=\"$imgstyle\">\n";
    }

    // Act 3 description
    if ($act3_desc != "") echo str_replace("\n", "<br>", $act3_desc);
  }

  // If there's an act 4, display it
  if (($act4_image != "") || ($act4_desc != "")) {
    echo "<div style=\"clear: both;\"></div>\n<hr style=\"margin: 1em 0;\">\n";

    // Act 4 image
    if ($act4_image != "") {
      list($width, $height, $type, $attr) = getimagesize("images/bands/" . $act4_image);
      $imgstyle = ($width > 250) ? "popup-img-center" : "popup-img-left";
      echo "<img src=\"images/bands/" . $act4_image . "\" alt=\"" . strip_tags($act4) . "\" class=\"$imgstyle\">\n";
    }

    // Act 4 description
    if ($act4_desc != "") echo str_replace("\n", "<br>", $act4_desc);
  }
  ?>
</div> <!-- END popup-scroll -->