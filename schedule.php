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
          <div class=\"cal-day\">" . date("D", $eventarr[$day_num][0]['show_date']) . "</div>
        </div>
        ";

        // This day has a show so display it
        if (isset($eventarr[$day_num])) {
          echo "<div class=\"cal-info\">\n";

          // Sold out?
          if ($eventarr[$day_num][0]['notice'] == "soldout") echo "<strong style=\"color: #000000;\">SOLD OUT</strong><br>";

          // Canceled?
          if ($eventarr[$day_num][0]['notice'] == "canceled") echo "<strong style=\"color: #000000;\">CANCELED</strong><br><strike>";

          // Display acts
          echo (empty($eventarr[$day_num][0]['act1_url'])) ? $eventarr[$day_num][0]['act1'] : "<a href=\"" . $eventarr[$day_num][0]['act1_url'] . "\">" . $eventarr[$day_num][0]['act1'] . "</a>";
          if ($eventarr[$day_num][0]['act2'] != "") {
            echo ", ";
            echo (empty($eventarr[$day_num][0]['act2_url'])) ? $eventarr[$day_num][0]['act2'] : "<a href=\"" . $eventarr[$day_num][0]['act2_url'] . "\">" . $eventarr[$day_num][0]['act2'] . "</a>";
          }
          if ($eventarr[$day_num][0]['act3'] != "") {
            echo ", ";
            echo (empty($eventarr[$day_num][0]['act3_url'])) ? $eventarr[$day_num][0]['act3'] : "<a href=\"" . $eventarr[$day_num][0]['act3_url'] . "\">" . $eventarr[$day_num][0]['act3'] . "</a>";
          }
          if ($eventarr[$day_num][0]['act4'] != "") {
            echo ", ";
            echo (empty($eventarr[$day_num][0]['act4_url'])) ? $eventarr[$day_num][0]['act4'] : "<a href=\"" . $eventarr[$day_num][0]['act4_url'] . "\">" . $eventarr[$day_num][0]['act4'] . "</a>";
          }

          // Display time and cover
          if (!empty($eventarr[$day_num][0]['time']) || !empty($eventarr[$day_num][0]['cover'])) echo "<br>\n";
          echo (empty($eventarr[$day_num][0]['time'])) ? "" : $eventarr[$day_num][0]['time'] . " ";
          echo (empty($eventarr[$day_num][0]['cover'])) ? "" : $eventarr[$day_num][0]['cover'] . " ";

          // Canceled?
          if ($eventarr[$day_num][0]['notice'] == "canceled") echo "</strike>";

          // Display "show details"
          if (!empty($eventarr[$day_num][0]['act1_image']) || !empty($eventarr[$day_num][0]['act1_desc']) || !empty($eventarr[$day_num][0]['act2_image']) || !empty($eventarr[$day_num][0]['act2_desc']) || !empty($eventarr[$day_num][0]['act3_image']) || !empty($eventarr[$day_num][0]['act3_desc']) || !empty($eventarr[$day_num][0]['act4_image']) || !empty($eventarr[$day_num][0]['act4_desc'])) echo "<br><a href=\"#popup" . $eventarr[$day_num][0]['id'] . "\" class=\"popup-link\" style=\"font-size: 80%;\">show details</a>";

          echo "</div>\n";

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