<?php
// Keep people from snooping too far into the future
$toofar = date("Y") + 5 . "" . date("m");
if (!empty($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] > $toofar) header( "Location: schedule.php" );

include_once "inc/dbconfig.php";

if (!empty($_SERVER['QUERY_STRING'])) {
  $date = mktime(0,0,0,substr($_SERVER['QUERY_STRING'],-2), 1, substr($_SERVER['QUERY_STRING'],0,4));
  $title = date("F Y",$date);
  $lastmonth = mktime(0,0,0,substr($_SERVER['QUERY_STRING'],-2)-1, 1, substr($_SERVER['QUERY_STRING'],0,4));
  $nextmonth = mktime(0,0,0,substr($_SERVER['QUERY_STRING'],-2)+1, 1, substr($_SERVER['QUERY_STRING'],0,4));
} else {
  // Set variables to generate schedule
  $date = time();
  $title = date("F Y");
  $lastmonth = mktime(1, 1, 1, date('m')-1, 1, date('Y'));
  $nextmonth = mktime(1, 1, 1, date('m')+1, 1, date('Y'));
}

$first_day = strtotime("First day of " . $title . " 00:00");
$last_day = strtotime("First day of " . date("F Y", $nextmonth) . " 00:00");
$days_in_month = date("j", $last_day-1);
$blanks = date("w", $first_day);

$PageTitle = $title;
include "header.php";
?>

<div class="calendar">
  <div class="calendar-header">
    <a href="schedule.php?<?php echo date("Ym", $lastmonth); ?>" class="cal-nav-l"><?php echo date("F", $lastmonth); ?></a>
    <h1 class="cal-title"><?php echo $title; ?></h1>
    <a href="schedule.php?<?php echo date("Ym", $nextmonth); ?>" class="cal-nav-r"><?php echo date("F", $nextmonth); ?></a>
    <div style="clear: both;"></div>
  </div>

  <ul class="weekdays">
    <li>Sunday</li>
    <li>Monday</li>
    <li>Tuesday</li>
    <li>Wednesday</li>
    <li>Thursday</li>
    <li>Friday</li>
    <li>Saturday</li>
  </ul>

  <ul class="days">
    <?php
    // Display blank days before the month starts
    for ($day_count = 0; $day_count < $blanks; $day_count++) {
      echo "<li class=\"calendar-day blank-start\"></li>\n";
    }

    // Get any shows for this month and put them in an array
    $result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$first_day' AND show_date < '$last_day' AND embargo_date <= '$rightnow' AND acg = '' ORDER BY show_date ASC");

    if ($result->num_rows == 0) echo "<li class=\"calendar-day list-noshows\">No shows scheduled for this month yet. Check back later.</li>\n";

    $eventarr = array();
    while($row = $result->fetch_array(MYSQLI_BOTH)) {
      $MyDay = date("j", $row['show_date']);
      $eventarr[$MyDay][] = $row;
    }
    $result->close();

    $day_num = 1;

    // Create the calendar by counting up to the last day of the month
    while ($day_num <= $days_in_month) {
      echo "<li class=\"calendar-day";
      if (date("F", $date) . " " . $day_num . " " . date("Y", $date) == date("F", $rightnow) . " " . date("j", $rightnow) . " " . date("Y", $rightnow)) echo " cal-today";
      if (empty($eventarr[$day_num][0]['act1'])) echo " noshow";
      echo "\">\n";
        echo "
        <div class=\"cal-datebox\">
          <div class=\"cal-date\">$day_num</div>
          <div class=\"cal-day\">";
            if (isset($eventarr[$day_num][0]['show_date'])) {
              $sshow_date = $eventarr[$day_num][0]['show_date'];
              echo date("D", $sshow_date);
            }
          echo "</div>
        </div>
        ";

        // This day has a show so display it
        if (isset($eventarr[$day_num])) {
          $snotice = (isset($eventarr[$day_num][0]['notice'])) ? $eventarr[$day_num][0]['notice'] : "";
          $sact1 = (isset($eventarr[$day_num][0]['act1'])) ? $eventarr[$day_num][0]['act1'] : "";
          $sact1_url = (isset($eventarr[$day_num][0]['act1_url'])) ? $eventarr[$day_num][0]['act1_url'] : "";
          $sact1_image = (isset($eventarr[$day_num][0]['act1_image'])) ? $eventarr[$day_num][0]['act1_image'] : "";
          $sact1_desc = (isset($eventarr[$day_num][0]['act1_desc'])) ? $eventarr[$day_num][0]['act1_desc'] : "";
          $sact2 = (isset($eventarr[$day_num][0]['act2'])) ? $eventarr[$day_num][0]['act2'] : "";
          $sact2_url = (isset($eventarr[$day_num][0]['act2_url'])) ? $eventarr[$day_num][0]['act2_url'] : "";
          $sact2_image = (isset($eventarr[$day_num][0]['act2_image'])) ? $eventarr[$day_num][0]['act2_image'] : "";
          $sact2_desc = (isset($eventarr[$day_num][0]['act2_desc'])) ? $eventarr[$day_num][0]['act2_desc'] : "";
          $sact3 = (isset($eventarr[$day_num][0]['act3'])) ? $eventarr[$day_num][0]['act3'] : "";
          $sact3_url = (isset($eventarr[$day_num][0]['act3_url'])) ? $eventarr[$day_num][0]['act3_url'] : "";
          $sact3_image = (isset($eventarr[$day_num][0]['act3_image'])) ? $eventarr[$day_num][0]['act3_image'] : "";
          $sact3_desc = (isset($eventarr[$day_num][0]['act3_desc'])) ? $eventarr[$day_num][0]['act3_desc'] : "";
          $sact4 = (isset($eventarr[$day_num][0]['act4'])) ? $eventarr[$day_num][0]['act4'] : "";
          $sact4_url = (isset($eventarr[$day_num][0]['act4_url'])) ? $eventarr[$day_num][0]['act4_url'] : "";
          $sact4_image = (isset($eventarr[$day_num][0]['act4_image'])) ? $eventarr[$day_num][0]['act4_image'] : "";
          $sact4_desc = (isset($eventarr[$day_num][0]['act4_desc'])) ? $eventarr[$day_num][0]['act4_desc'] : "";
          $stime = (isset($eventarr[$day_num][0]['time'])) ? $eventarr[$day_num][0]['time'] : "";
          $scover = (isset($eventarr[$day_num][0]['cover'])) ? $eventarr[$day_num][0]['cover'] : "";
          
          echo "<div class=\"cal-info\">\n";

          // Sold out?
          if ($snotice == "soldout") echo "<strong style=\"color: #000000;\">SOLD OUT</strong><br>";

          // Canceled?
          if ($snotice == "canceled") echo "<strong style=\"color: #000000;\">CANCELED</strong><br><strike>";

          // Display acts
          echo ($sact1_url == "") ? $sact1 : "<a href=\"" . $sact1_url . "\">" . $sact1 . "</a>";
          if ($sact2 != "") {
            echo ", ";
            echo ($sact2_url == "") ? $sact2 : "<a href=\"" . $sact2_url . "\">" . $sact2 . "</a>";
          }
          if ($sact3 != "") {
            echo ", ";
            echo ($sact3_url == "") ? $sact3 : "<a href=\"" . $sact3_url . "\">" . $sact3 . "</a>";
          }
          if ($sact4 != "") {
            echo ", ";
            echo ($sact4_url == "") ? $sact4 : "<a href=\"" . $sact4_url . "\">" . $sact4 . "</a>";
          }

          // Display time and cover
          if (($stime != "") || ($scover != "")) echo "<br>\n";
          echo ($stime == "") ? "" : $stime . " ";
          echo ($scover == "") ? "" : $scover . " ";

          // Canceled?
          if ($snotice == "canceled") echo "</strike>";

          // Display "show details"
          if (($sact1_image != "") || ($sact1_desc != "") || ($sact2_image != "") || ($sact2_desc != "") || ($sact3_image != "") || ($sact3_desc != "") || ($sact4_image != "") || ($sact4_desc != "")) echo "<br><a href=\"#popup" . $eventarr[$day_num][0]['id'] . "\" class=\"popup-link\" style=\"font-size: 80%;\">show details</a>";

          echo "</div>\n";

          // Popup-only variables
          $swmse = (isset($eventarr[$day_num][0]['wmse'])) ? $eventarr[$day_num][0]['wmse'] : "";
          $ssprecher = (isset($eventarr[$day_num][0]['sprecher'])) ? $eventarr[$day_num][0]['sprecher'] : "";
          $scascio = (isset($eventarr[$day_num][0]['cascio'])) ? $eventarr[$day_num][0]['cascio'] : "";
          $seightyeightnine = (isset($eventarr[$day_num][0]['eightyeightnine'])) ? $eventarr[$day_num][0]['eightyeightnine'] : "";
          $soneohtwoone = (isset($eventarr[$day_num][0]['oneohtwoone'])) ? $eventarr[$day_num][0]['oneohtwoone'] : "";
          $sothersponsor = (isset($eventarr[$day_num][0]['othersponsor'])) ? $eventarr[$day_num][0]['othersponsor'] : "";
          $sact2_minor = (isset($eventarr[$day_num][0]['act2_minor'])) ? $eventarr[$day_num][0]['act2_minor'] : "";
          $sact3_minor = (isset($eventarr[$day_num][0]['act3_minor'])) ? $eventarr[$day_num][0]['act3_minor'] : "";
          $sact4_minor = (isset($eventarr[$day_num][0]['act4_minor'])) ? $eventarr[$day_num][0]['act4_minor'] : "";
          $stickets = (isset($eventarr[$day_num][0]['tickets'])) ? $eventarr[$day_num][0]['tickets'] : "";

          echo "<div id=\"popup" . $eventarr[$day_num][0]['id'] . "\" class=\"popup-box mfp-hide\">\n";
            include "popup.php";
          echo "</div> <!-- END popup-box -->\n";
        }
      echo "</li>\n";

      $day_num++;
      $day_count++;

      // Start a new row every week
      if ($day_count > 6) {
        echo "</ul>\n<ul class=\"days\">\n";
        $day_count = 0;
      }
    }

    // Finish out the table with some blank details if needed
    $blank_end_first = 1;
    while ($day_count > 0 && $day_count <= 6) {
      echo "<li class=\"calendar-day blank-end";
      if ($blank_end_first == 1) echo " blank-end-first";
      echo "\"></li>\n";
      $day_count++;
      $blank_end_first++;
    }
    ?>
  </ul>
</div>

<div style="clear: both;"></div>

<?php include "footer.php"; ?>