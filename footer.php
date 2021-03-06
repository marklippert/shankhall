        </article>

        <?php if (!isset($PageTitle)) { ?>
        <aside>
          <img src="images/john-prine.jpg" alt="" style="max-width: 100%;"><br>
          <br>

          <h1>Quick Calendar</h1>
          <div id="quickcal-back">
            <div id="quickcal">
              <?php
              $count = 1;
              $tendays = strtotime("today -10 days");

              $result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$today' AND embargo_date <= '$rightnow' AND acg = '' AND quickcal = '' ORDER BY show_date ASC");

              while($row = $result->fetch_array(MYSQLI_BOTH)) {
                if ($count > 1) echo "<hr>\n";

                echo "<a href=\"#popup" . $row['id'] . "\" class=\"popup-link\"><strong>" . date("F j",$row['show_date']) . "</strong>";

                if ($row['embargo_date'] >= $tendays) echo " <strong style=\"color: #843700;\">NEW</strong>";

                if ($row['notice'] == "canceled") echo " <strong style=\"color: #843700;\">CANCELED</strong>";
                if ($row['notice'] == "postponed") echo " <strong style=\"color: #843700;\">POSTPONED</strong>";
                if ($row['notice'] == "soldout") echo " <strong style=\"color: #843700;\">SOLD OUT</strong>";
                if ($row['notice'] == "newdate") echo " <strong style=\"color: #843700;\">NEW DATE</strong>";

                echo "<br>\n";

                if (empty($row['main_text'])) {
                  $event = strip_tags($row['act1']);
                  if ($row['act2'] != "") { $event .= ", " . strip_tags($row['act2']); }
                  if ($row['act3'] != "") { $event .= ", " . strip_tags($row['act3']); }
                  if ($row['act4'] != "") { $event .= ", " . strip_tags($row['act4']); }
                } else {
                  $event = $row['main_text'];
                }

                if ($row['notice'] == "canceled" || $row['notice'] == "postponed") echo "<strike>";

                echo $event;

                if ($row['notice'] == "canceled" || $row['notice'] == "postponed") echo "</strike>";

                echo "</a>\n";
                
                echo "<div id=\"popup" . $row['id'] . "\" class=\"popup-box mfp-hide\">\n";
                  include "popup.php";
                echo "</div> <!-- END popup-box -->\n";

                $count++;
              }

              $result->close();
              ?>
            </div> <!-- END quickcal -->
          </div> <!-- END quickcal-back -->

          <br>

          <div style="text-align: center;">
            <strong>All shows 21+</strong><br>
            <br>

            Check the <a href="schedule.php">schedule</a> for more detailed information or subscribe to our <a type="application/rss+xml" href="rssfeed.xml"><img src="images/rss.png" alt="RSS" style="vertical-align: middle; height: 1em; width: auto;"></a> <a type="application/rss+xml" href="rssfeed.xml">RSS feed</a><br>
            <br>
            <br>

            <?php if (strtotime("now") <= strtotime("29 August 2015 11:59pm")) { ?>
            <a href="images/sprecher-30-years-large.jpg" target="new"><img src="images/sprecher-30-years.jpg" alt="" style="max-width: 100%;"></a><br>
            <br>
            <?php } ?>

            <img src="images/mark-shurilla.jpg" alt="" style="max-width: 100%;"><br>
            <br>

            <img src="images/leon-redbone.jpg" alt="" style="max-width: 100%;">
          </div>
        </aside>

        <div style="clear: both;"></div>
        <?php } ?>
      </div> <!-- END content -->

      <footer>
        <nav id="footermenu">
          <?php include "menu.php"; ?>
        </nav>
        Copyright &copy; <?php echo date("Y"); ?> All rights reserved
      </footer>
    </div> <!-- END wrap -->

  </body>
</html>
<?php $mysqli->close(); ?>