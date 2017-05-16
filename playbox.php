<?php
if (($row['act1_image'] != "") || ($row['main_image'] != "")) {
  // Which image are we using?
  $img = (empty($row['main_image'])) ? "images/bands/" . $row['act1_image'] : "images/bands/" . $row['main_image'];
  
  if (file_exists($img)) {
    // Get width and height of image
    list($width, $height, $type, $attr) = getimagesize($img);
    
    // Get ratio of image so it can be centered in a square box
    $ratio = ceil(($width / $height) * 100);
    $adjust = ($ratio - 100) / 2;

    $adj_pos = ($width/$height > 1) ? "width: " . $ratio . "%; left: -" . $adjust . "%;" : "width: 100%; top: " . $adjust . "%;";
  }
}

$img_alt = ($row['main_text'] != "") ? strip_tags($row['main_text']) : strip_tags($row['act1']);
?>

<div class="playbox">
  <div class="playbox-img">
    <img src="<?php echo $img . "?" . time(); ?>" alt="<?php echo $img_alt; ?>" style="<?php echo $adj_pos; ?>">
    <?php
    if ($row['notice'] == "canceled") echo "<img src=\"images/canceled.png\" alt=\"CANCELED\" class=\"playbox-stamp\">";
    if ($row['notice'] == "soldout") echo "<img src=\"images/soldout.png\" alt=\"SOLD OUT\" class=\"playbox-stamp\">";
    ?>
  </div> <!-- END playbox-img -->
  
  <?php
  // Sponsors
  if (!empty($row['wmse'])) echo "<a href=\"http://www.wmse.org\"><img src=\"images/wmse.jpg\" alt=\"WMSE\" class=\"playbox-sponsor\"></a>";
  if (!empty($row['sprecher'])) echo "<a href=\"http://www.sprecherbrewery.com\"><img src=\"images/sprecher.jpg\" alt=\"Sprecher\" class=\"playbox-sponsor\"></a>";
  if (!empty($row['cascio'])) echo "<a href=\"http://www.interstatemusic.com\"><img src=\"images/cascio.png\" alt=\"Cascio Interstate Music\" class=\"playbox-sponsor\"></a>";
  if (!empty($row['eightyeightnine'])) echo "<a href=\"http://www.radiomilwaukee.org\"><img src=\"images/88nine.jpg\" alt=\"88NINE\" class=\"playbox-sponsor\"></a>";
  if (!empty($row['oneohtwoone'])) echo "<a href=\"http://www.fm1021milwaukee.com\"><img src=\"images/102point1.jpg\" alt=\"102.1\" class=\"playbox-sponsor\"></a>";
  if (!empty($row['othersponsor'])) echo "<img src=\"images/" . $row['othersponsor'] . "\" alt=\"\" class=\"playbox-sponsor\">";
  ?>
  
  <div class="playbox-title">
    <?php
    if (empty($row['main_text'])) {
      $event = strip_tags($row['act1']);
      if ($row['act2'] != "") {
        if (!empty($row['act2_minor'])) $event .= "<span class=\"playbox-minor\">";
        $event .= ", " . strip_tags($row['act2']);
        if (!empty($row['act2_minor'])) $event .= "</span>";
      }
      if ($row['act3'] != "") {
        if (!empty($row['act3_minor'])) $event .= "<span class=\"playbox-minor\">";
        $event .= ", " . strip_tags($row['act3']);
        if (!empty($row['act3_minor'])) $event .= "</span>";
      }
      if ($row['act4'] != "") {
        if (!empty($row['act4_minor'])) $event .= "<span class=\"playbox-minor\">";
        $event .= ", " . strip_tags($row['act4']);
        if (!empty($row['act4_minor'])) $event .= "</span>";
      }
    } else {
      $event = $row['main_text'];
    }

    if ($row['notice'] == "canceled") echo "<strike>";

    echo $event;

    if ($row['notice'] == "canceled") echo "</strike> <strong style=\"color: #843700;\">CANCELED</strong>";
    if ($row['notice'] == "soldout") echo " <strong style=\"color: #843700;\">SOLD OUT</strong>";
    if ($row['notice'] == "newdate") echo " <strong style=\"color: #843700;\">NEW DATE</strong>";
    ?>
  </div> <!-- END playbox-title -->

  <div class="playbox-time">
    <?php
    if ($row['notice'] == "canceled") echo "<strike>";

    echo "<span class=\"playbox-date\">";
      echo "<span class=\"playbox-day\">";
        if ($row['show_date'] == $today) echo "<strong style=\"color: #843700;\">Today</strong>";
        if ($row['show_date'] == $tomorrow) echo "<strong style=\"color: #843700;\">Tomorrow</strong>";
        if (($row['show_date'] != $today) && ($row['show_date'] != $tomorrow)) echo date("l", $row['show_date']);
      echo "</span>";
    echo date("F j, Y", $row['show_date']) . "</span>";
    
    echo "<span class=\"playbox-timecover\">";
      if (!empty($row['time'])) echo $row['time'];
      if (!empty($row['time']) && !empty($row['cover'])) echo " &nbsp; ";
      if (!empty($row['cover'])) echo $row['cover'];
    echo "</span>";

    if ($row['notice'] == "canceled") echo "</strike>";
    
    if (substr($row['tickets'], 0, 20) == "http://www.ticketweb" && $row['notice'] != "soldout" && $row['notice'] != "canceled")
      echo "<a href=\"" . $row['tickets'] . "\"><img src=\"images/ticketweb.png\" alt=\"TicketWeb\"></a>";
    if (substr($row['tickets'], 0, 20) == "http://www.ticketmas" && $row['notice'] != "soldout" && $row['notice'] != "canceled")
      echo "<a href=\"" . $row['tickets'] . "\"><img src=\"images/ticketmaster.png\" alt=\"TicketMaster\"></a>";
    ?>
  </div> <!-- END playbox-time -->
  
  <?php
  if ($row['notice'] == "canceled") {
    echo "If you already have tickets for this show, please return them to the place of purchase for a refund.  Sorry for the inconvenience.";
  } else {
    if (!empty($row['act1_desc'])) {
      // Figure out if/where the description will be truncated
      $thechop = ((strlen(strip_tags($event)) < 60) ? "325" : "225");
      $chopped = substr(strip_tags($row['act1_desc']), 0, $thechop);
      $len = strlen($chopped);

      if ($len >= $thechop) {
        $pos = strrpos($chopped, " ");
        echo substr($row['act1_desc'], 0, $pos) . "....<a href=\"#popup" . $row['id'] . "\" class=\"popup-link\">read more</a>";
      } else {
        echo str_replace("\n", "<br>", $row['act1_desc']);
      }
    }
  }
  ?>

  <div style="clear: both;"></div>
  
  <a href="#popup<?php echo $row['id']; ?>" class="popup-link"><img src="images/magnify.png" alt="Read more" class="magnify"></a>
</div> <!-- END playbox -->