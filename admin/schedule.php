<?php
include "login.php";
$PageTitle = "Schedule";
include "header.php";

function ListImages() {
  $dir = opendir("../images/bands");

  // Read image directory and put files in array
  while(false != ($file = readdir($dir))) {
    if (($file != ".") and ($file != "..")) {
      $files[] = $file;
    }
  }

  closedir($dir);

  // Sort file array
  natcasesort($files);

  // List files in dropdown
  foreach ($files as $file) {
    echo "<option value=\"" . $file . "\">" . $file . "</option>\n";
  }
}
?>

<div class="toggle-box">
  <div class="toggle-control" data-text="Show add event form" data-expanded-text="Hide add event form">Show add event form</div>
  <div id="admin-left">
    <h1>Upload Image</h1>
    <form action="schedule-db.php?a=upload<?php if (!empty($_GET['b'])) { echo "&b=" . $_GET['b']; } ?>" method="POST" enctype="multipart/form-data" style="margin-bottom: 2em;">
      <input type="file" name="image">
      <input type="submit" name="isubmit" value="Upload">
    </form>

    <h1>Add Event</h1>
    <form action="schedule-db.php?a=add" method="POST">
      <div class="form-left">
        <strong>Show Date</strong>
        <input type="text" name="show_date" id="show_date" readonly="true"><br>
        <br>
      </div>

      <div class="form-right">
        <strong>Show Time</strong>
        <input type="text" name="time" class="mytimepicker"><br>
        <br>
      </div>

      <div style="clear: both;"></div>

      <div class="form-left">
        <strong>Embargo Date</strong>
        <input type="text" name="embargo_date" id="embargo_date" readonly="true" value="<?php echo date("m/d/Y"); ?>"><br>
        <br>
      </div>

      <div class="form-right">
        <strong>Embargo Time</strong>
        <input type="text" name="embargo_hour" class="embargo_hour" value="0:00"><br>
        <br>
      </div>

      <div style="clear: both;"></div>

      <div class="form-left">
        <strong>Cover</strong>
        <input type="text" name="cover"><br>
        <br>
      </div>

      <div class="form-right">
        <strong>Ticket Link</strong>
        <input type="text" name="tickets"><br>
        <br>
      </div>

      <div style="clear: both;"></div>
      
      <div class="form-left">
        <input type="checkbox" name="playbox"> <strong>Do NOT show in Playbox</strong><br>
        <input type="checkbox" name="donttweet"> <strong>Don't tweet</strong><br>
        <br>
        <input type="checkbox" name="wmse"> <strong>WMSE Presents</strong><br>
        <input type="checkbox" name="eightyeightnine"> <strong>88Nine Presents</strong><br>
        <input type="checkbox" name="oneohtwoone"> <strong>102.1 Presents</strong>
      </div>

      <div class="form-right">
        <input type="checkbox" name="acg"> <strong>ACG</strong><br>
        <br>
        <br>
        <input type="checkbox" name="sprecher"> <strong>Sprecher Presents</strong><br>
        <input type="checkbox" name="cascio"> <strong>Cascio Presents</strong>
      </div>

      <div style="clear: both; margin-bottom: 0.3em;"></div>

      <strong>Other Sponsor</strong>
      <input type="text" name="othersponsor"><br>
      <br>

      <strong>Act 1</strong>
      <input type="text" name="act1"><br>
      <br>

      <strong>Act 1 URL</strong>
      <input type="text" name="act1_url"><br>
      <br>

      <strong>Act 1 Image</strong>
      <select name="act1_image">
        <option value="">Select file...</option>
        <?php ListImages(); ?>
      </select><br>
      <br>

      <strong>Act 1 Description</strong>
      <textarea name="act1_desc"></textarea>

      <div id="act2link" style="text-align: center;"><a href="javascript:toggle('act2','act2link')">Add a second act to this event</a></div>
      <div id="act2" style="display: none; padding-top: 1.3em;">
        <div style="float: right;"><strong>Minor</strong> <input type="checkbox" name="act2_minor"></div>
        <strong>Act 2</strong>
        <input type="text" name="act2"><br>
        <br>

        <strong>Act 2 URL</strong>
        <input type="text" name="act2_url"><br>
        <br>

        <strong>Act 2 Image</strong>
        <select name="act2_image">
          <option value="">Select file...</option>
          <?php ListImages(); ?>
        </select><br>
        <br>

        <strong>Act 2 Description</strong>
        <textarea name="act2_desc"></textarea>

        <div id="act3link" style="text-align: center;"><a href="javascript:toggle('act3','act3link')">Add a third act to this event</a></div>
      </div>

      <div id="act3" style="display: none; padding-top: 1.3em;">
        <div style="float: right;"><strong>Minor</strong> <input type="checkbox" name="act3_minor"></div>
        <strong>Act 3</strong>
        <input type="text" name="act3"><br>
        <br>

        <strong>Act 3 URL</strong>
        <input type="text" name="act3_url"><br>
        <br>

        <strong>Act 3 Image</strong>
        <select name="act3_image">
          <option value="">Select file...</option>
          <?php ListImages(); ?>
        </select><br>
        <br>

        <strong>Act 3 Description</strong>
        <textarea name="act3_desc"></textarea>

        <div id="act4link" style="text-align: center;"><a href="javascript:toggle('act4','act4link')">Add a fourth act to this event</a></div>
      </div>

      <div id="act4" style="display: none; padding-top: 1.3em;">
        <div style="float: right;"><strong>Minor</strong> <input type="checkbox" name="act4_minor"></div>
        <strong>Act 4</strong>
        <input type="text" name="act4"><br>
        <br>

        <strong>Act 4 URL</strong>
        <input type="text" name="act4_url"><br>
        <br>

        <strong>Act 4 Image</strong>
        <select name="act4_image">
          <option value="">Select file...</option>
          <?php ListImages(); ?>
        </select><br>
        <br>

        <strong>Act 4 Description</strong>
        <textarea name="act4_desc"></textarea>
      </div>

      <br>

      <strong>Main Text</strong>
      <input type="text" name="main_text"><br>
      <br>

      <strong>Main Image</strong>
      <select name="main_image">
        <option value="">Select file...</option>
        <?php ListImages(); ?>
      </select><br>
      <br>

      <div id="sticky">
        <span><input type="radio" name="sticky" value="sticky"> <strong>Sticky</strong></span>
        <span><input type="radio" name="sticky" value="unsticky"> <strong>Unsticky</strong></span>
        <span><input type="radio" name="sticky" value="none" checked> <strong>None</strong></span>
      </div>
      <br>

      <input type="submit" value="Add" class="butt-center">
    </form>

    <br><br>

    <form action="schedule.php<?php if (!empty($_GET['b'])) echo "?b=" . $_GET['b']; ?>" method="POST">
      <h1>Search</h1>
      <input type="text" name="ssearch">
      <input type="submit" name="ssubmit" value="Search" class="butt-center">
    </form>

    <?php
    if (!empty($_POST['ssubmit'])) {
      echo "<br><strong>Search Results</strong><br>\n";

      $result = $mysqli->query("SELECT * FROM schedule WHERE act1 LIKE '%" . $_POST['ssearch'] . "%' OR act2 LIKE '%" . $_POST['ssearch'] . "%' OR act3 LIKE '%" . $_POST['ssearch'] . "%' OR act4 LIKE '%" . $_POST['ssearch'] . "%' ORDER BY show_date ASC");

      if ($result->num_rows > 0) {
        while($row = $result->fetch_array(MYSQLI_BOTH)) {
          ?>
          <div class="c3">
            <div class="controls">
              <a href="schedule-db.php?a=delete&id=<?php echo $row['id'] . $TheB; ?>" onClick="return(confirm('Are you sure you want to delete this record?'));"><img src="images/delete.png" alt="Delete" title="Delete"></a>
              <a href="schedule-edit.php?a=edit&id=<?php echo $row['id'] . $TheB; ?>"><img src="images/edit.png" alt="Edit" title="Edit"></a>
              <a href="schedule-edit.php?a=copy&id=<?php echo $row['id'] . $TheB; ?>"><img src="images/copy.png" alt="Copy" title="Copy"></a>
            </div>

            <div class="sched-date"><?php echo date("n/j/y",$row['show_date']); ?></div>

            <div class="info">
              <?php
              if ($row['notice'] == "canceled" || $row['notice'] == "postponed") echo "<strike>";

              if (!empty($row['acg'])) echo "[ACG] ";

              echo $row['act1'];
              if ($row['act2'] != "") echo ", " . $row['act2'];
              if ($row['act3'] != "") echo ", " . $row['act3'];
              if ($row['act4'] != "") echo ", " . $row['act4'];

              if ($row['embargo_date'] > $rightnow) echo "<br><em style=\"font-size: 80%;\">[embargoed until " . date("n/j g:ia",$row['embargo_date']) . "]</em>";

              if ($row['notice'] == "canceled" || $row['notice'] == "postponed") echo "</strike>";
              ?>
            </div>

            <div class="show-spacer"></div>
          </div>
          <?php
        }

        $result->close();
      } else {
        echo "Nothing found.  Try again.\n";
      }
    }
    ?>
  </div>
</div>

<div id="admin-right">
  <?php
  if (!empty($_GET['b'])) {
    $date = mktime(0,0,0,substr($_GET['b'],-2), 1, substr($_GET['b'],0,4));
    $title = date("F Y",$date);
    $lastmonth = mktime(0,0,0,substr($_GET['b'],-2)-1, 1, substr($_GET['b'],0,4));
    $nextmonth = mktime(0,0,0,substr($_GET['b'],-2)+1, 1, substr($_GET['b'],0,4));
    $TheB = "&b=" . $_GET['b'];
  } else {
    $title = date("F Y");
    $lastmonth = mktime(1, 1, 1, date('m')-1, 1, date('Y'));
    $nextmonth = mktime(1, 1, 1, date('m')+1, 1, date('Y'));
    $TheB = "";
  }

  $first_day = strtotime("First day of " . $title . " 00:00");
  $last_day = strtotime("First day of " . date("F Y", $nextmonth) . " 00:00");
  ?>

  <div style="text-align: center;">
    <h2 id="sched-prev"><a href="schedule.php?b=<?php echo date("Ym", $lastmonth); ?>" style="text-decoration: none;"><<</a></h2>
    <h2 id="sched-month"><?php echo $title; ?></h2>
    <h2 id="sched-next"><a href="schedule.php?b=<?php echo date("Ym", $nextmonth); ?>" style="text-decoration: none;">>></a></h2>
    <div style="clear: both;"></div>
  </div>

  <br>

  <?php
  $result = $mysqli->query("SELECT * FROM schedule WHERE show_date >= '$first_day' AND show_date < '$last_day' ORDER BY show_date ASC");

  while($row = $result->fetch_array(MYSQLI_BOTH)) {
    ?>
    <div class="c3">
      <div class="controls">
        <a href="schedule-db.php?a=delete&id=<?php echo $row['id'] . $TheB; ?>" onClick="return(confirm('Are you sure you want to delete this record?'));"><img src="images/delete.png" alt="Delete" title="Delete"></a>
        <a href="schedule-edit.php?a=edit&id=<?php echo $row['id'] . $TheB; ?>"><img src="images/edit.png" alt="Edit" title="Edit"></a>
        <a href="schedule-edit.php?a=copy&id=<?php echo $row['id'] . $TheB; ?>"><img src="images/copy.png" alt="Copy" title="Copy"></a>
      </div>

      <div class="sched-date"><?php echo date("n/j",$row['show_date']); ?></div>

      <div class="info">
        <?php
        if ($row['notice'] == "canceled" || $row['notice'] == "postponed") echo "<strike>";

        if (!empty($row['acg'])) echo "[ACG] ";

        echo $row['act1'];
        if ($row['act2'] != "") echo ", " . $row['act2'];
        if ($row['act3'] != "") echo ", " . $row['act3'];
        if ($row['act4'] != "") echo ", " . $row['act4'];

        if ($row['tickets'] != "") echo " <a href=\"" . $row['tickets'] . "\"><img src=\"images/ticket.png\" alt=\"Tickets\" title=\"Tickets\" style=\"height: 0.8em; width: auto;\"></a>";

        if ($row['embargo_date'] > $rightnow) echo "<br><em style=\"font-size: 80%;\">[embargoed until " . date("n/j g:ia",$row['embargo_date']) . "]</em>";

        if ($row['notice'] == "canceled" || $row['notice'] == "postponed") echo "</strike>";
        ?>
      </div>

      <div class="show-spacer"></div>
    </div>
    <?php
  }
  $result->close();
  ?>
</div>

<div style="clear: both;"></div>

<?php include "footer.php"; ?>