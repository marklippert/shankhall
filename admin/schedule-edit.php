<?php
include "login.php";

$Action = ($_GET['a'] == "edit") ? "Edit" : "Copy";
$PageTitle = "Schedule | " . $Action . " Event";
include "header.php";

$result = $mysqli->query("SELECT * FROM schedule WHERE id = '" . $_GET['id'] . "'");
$row = $result->fetch_array(MYSQLI_BOTH);

function ListImages($sel) {
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
    echo "<option value=\"" . $file . "\"";
    if ($sel == $file) { echo " selected"; }
    echo ">" . $file . "</option>\n";
  }
}
?>

<form action="schedule-db.php?a=<?php echo ($_GET['a'] == "edit") ? "edit" : "add"; if (!empty($_GET['b'])) echo "&b=" . $_GET['b']; ?>" method="POST" class="admin-edit">
  <?php if ($_GET['a'] == "edit") { ?>
  <div class="sub-sidebar">
    <span><input type="radio" name="notice" value="canceled"<?php if ($row['notice'] == "canceled") echo " checked"; ?>> <strong>Canceled</strong></span>
    <span><input type="radio" name="notice" value="soldout"<?php if ($row['notice'] == "soldout") echo " checked"; ?>> <strong>Sold Out</strong></span>
    <span><input type="radio" name="notice" value="newdate"<?php if ($row['notice'] == "newdate") echo " checked"; ?>> <strong>New Date</strong></span>
    <span><input type="radio" name="notice" value=""<?php if ($row['notice'] == "") echo " checked"; ?>> <strong>All Is Well</strong></span>
  </div>
  <?php } ?>

  <div class="form-left">
    <strong>Show Date</strong>
    <input type="text" name="show_date" id="show_date" readonly="true" value="<?php if ($_GET['a'] == "edit") echo date("m/d/Y",$row['show_date']); ?>"><br>
    <br>
  </div>

  <div class="form-right">
    <strong>Show Time</strong>
    <input type="text" name="time" class="mytimepicker" value="<?php echo $row['time']; ?>"><br>
    <br>
  </div>

  <div style="clear: both;"></div>

  <div class="form-left">
    <strong>Embargo Date</strong>
    <input type="text" name="embargo_date" id="embargo_date" readonly="true" value="<?php echo ($_GET['a'] == "edit") ? date("m/d/Y", $row['embargo_date']) : date("m/d/Y"); ?>"><br>
    <br>
  </div>

  <div class="form-right">
    <strong>Embargo Time</strong>
    <input type="text" name="embargo_hour" class="embargo_hour" value="<?php echo ($_GET['a'] == "edit") ? date("G:i",$row['embargo_date']) : "0:00"; ?>"><br>
    <br>
  </div>

  <div style="clear: both;"></div>

  <div class="form-left">
    <strong>Cover</strong>
    <input type="text" name="cover" value="<?php echo $row['cover']; ?>"><br>
    <br>
  </div>

  <div class="form-right">
    <strong>Ticket Link</strong>
    <input type="text" name="tickets" value="<?php if ($_GET['a'] == "edit") echo $row['tickets']; ?>"><br>
    <br>
  </div>

  <div style="clear: both;"></div>

  <div class="form-left">
    <input type="checkbox" name="playbox"<?php if ($_GET['a'] == "edit" && !empty($row['playbox'])) echo " checked"; ?>> <strong>Do NOT show in Playbox</strong><br>
    <input type="checkbox" name="donttweet"<?php if ($_GET['a'] == "edit" && !empty($row['donttweet'])) echo " checked"; ?>> <strong>Don't tweet</strong><br>
    <br>
    <input type="checkbox" name="wmse"<?php if ($_GET['a'] == "edit" && !empty($row['wmse'])) echo " checked"; ?>> <strong>WMSE Presents</strong><br>
    <input type="checkbox" name="eightyeightnine"<?php if ($_GET['a'] == "edit" && !empty($row['eightyeightnine'])) echo " checked"; ?>> <strong>88Nine Presents</strong><br>
    <input type="checkbox" name="oneohtwoone"<?php if ($_GET['a'] == "edit" && !empty($row['oneohtwoone'])) echo " checked"; ?>> <strong>102.1 Presents</strong>
  </div>

  <div class="form-right">
    <input type="checkbox" name="acg"<?php if ($_GET['a'] == "edit" && !empty($row['acg'])) echo " checked"; ?>> <strong>ACG</strong><br>
    <br>
    <br>
    <input type="checkbox" name="sprecher"<?php if ($_GET['a'] == "edit" && !empty($row['sprecher'])) echo " checked"; ?>> <strong>Sprecher Presents</strong><br>
    <input type="checkbox" name="cascio"<?php if ($_GET['a'] == "edit" && !empty($row['cascio'])) echo " checked"; ?>> <strong>Cascio Presents</strong>
  </div>

  <div style="clear: both; margin-bottom: 0.3em;"></div>

  <strong>Other Sponsor</strong>
  <input type="text" name="othersponsor" value="<?php if ($_GET['a'] == "edit") echo $row['othersponsor']; ?>"><br>
  <br>

  <strong>Act 1</strong>
  <input type="text" name="act1" value="<?php echo htmlspecialchars($row['act1']); ?>"><br>
  <br>

  <strong>Act 1 URL</strong>
  <input type="text" name="act1_url" value="<?php echo $row['act1_url']; ?>"><br>
  <br>

  <strong>Act 1 Image</strong>
  <select name="act1_image">
    <option value="">Select file...</option>
    <?php ListImages($row['act1_image']); ?>
  </select><br>
  <br>

  <strong>Act 1 Description</strong>
  <textarea name="act1_desc"><?php echo stripslashes($row['act1_desc']); ?></textarea>

  <div id="act2link" style="text-align: center;<?php echo (empty($row['act2'])) ? "" : " display: none;"; ?>"><a href="javascript:toggle('act2','act2link')">Add a second act to this event</a></div>
  <div id="act2" style="display: <?php echo (empty($row['act2'])) ? "none" : "auto"; ?>; padding-top: 1.3em;">
    <div style="float: right;"><strong>Minor</strong> <input type="checkbox" name="act2_minor"<?php if (!empty($row['act2_minor'])) echo " checked"; ?>></div>
    <strong>Act 2</strong>
    <input type="text" name="act2" value="<?php echo htmlspecialchars($row['act2']); ?>"><br>
    <br>

    <strong>Act 2 URL</strong>
    <input type="text" name="act2_url" value="<?php echo $row['act2_url']; ?>"><br>
    <br>

    <strong>Act 2 Image</strong>
    <select name="act2_image">
      <option value="">Select file...</option>
      <?php ListImages($row['act2_image']); ?>
    </select><br>
    <br>

    <strong>Act 2 Description</strong>
    <textarea name="act2_desc"><?php echo stripslashes($row['act2_desc']); ?></textarea>

    <div id="act3link" style="text-align: center;<?php echo (empty($row['act3'])) ? "" : " display: none;"; ?>"><a href="javascript:toggle('act3','act3link')">Add a third act to this event</a></div>
  </div>

  <div id="act3" style="display: <?php echo (empty($row['act3'])) ? "none" : "auto"; ?>; padding-top: 1.3em;">
    <div style="float: right;"><strong>Minor</strong> <input type="checkbox" name="act3_minor"<?php if (!empty($row['act3_minor'])) echo " checked"; ?>></div>
    <strong>Act 3</strong>
    <input type="text" name="act3" value="<?php echo htmlspecialchars($row['act3']); ?>"><br>
    <br>

    <strong>Act 3 URL</strong>
    <input type="text" name="act3_url" value="<?php echo $row['act3_url']; ?>"><br>
    <br>

    <strong>Act 3 Image</strong>
    <select name="act3_image">
      <option value="">Select file...</option>
      <?php ListImages($row['act3_image']); ?>
    </select><br>
    <br>

    <strong>Act 3 Description</strong>
    <textarea name="act3_desc"><?php echo stripslashes($row['act3_desc']); ?></textarea>

    <div id="act4link" style="text-align: center;"><a href="javascript:toggle('act4','act4link')">Add a fourth act to this event</a></div>
  </div>

  <div id="act4" style="display: <?php echo (empty($row['act4'])) ? "none" : "auto"; ?>; padding-top: 1.3em;">
    <div style="float: right;"><strong>Minor</strong> <input type="checkbox" name="act4_minor"<?php if (!empty($row['act4_minor'])) echo " checked"; ?>></div>
    <strong>Act 4</strong>
    <input type="text" name="act4" value="<?php echo htmlspecialchars($row['act4']); ?>"><br>
    <br>

    <strong>Act 4 URL</strong>
    <input type="text" name="act4_url" value="<?php echo $row['act4_url']; ?>"><br>
    <br>

    <strong>Act 4 Image</strong>
    <select name="act4_image">
      <option value="">Select file...</option>
      <?php ListImages($row['act4_image']); ?>
    </select><br>
    <br>

    <strong>Act 4 Description</strong>
    <textarea name="act4_desc"><?php echo stripslashes($row['act4_desc']); ?></textarea>
  </div>

  <br>

  <strong>Main Text</strong>
  <input type="text" name="main_text" value="<?php echo $row['main_text']; ?>"><br>
  <br>

  <strong>Main Image</strong>
  <select name="main_image">
    <option value="">Select file...</option>
    <?php ListImages($row['main_image']); ?>
  </select><br>
  <br>

  <div id="sticky">
    <span><input type="radio" name="sticky" value="sticky"<?php if ($row['sticky'] == "sticky") echo " checked"; ?>> <strong>Sticky</strong></span>
    <span><input type="radio" name="sticky" value="unsticky"<?php if ($row['sticky'] == "unsticky") echo " checked"; ?>> <strong>Unsticky</strong></span>
    <span><input type="radio" name="sticky" value="none" <?php if ($row['sticky'] == "none") echo " checked"; ?>> <strong>None</strong></span>
  </div>
  <br>
  
  <?php if ($_GET['a'] == "edit") { ?>
  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
  <?php } ?>
  <input type="submit" value="<?php echo ($_GET['a'] == "edit") ? "Update" : "Copy"; ?>" class="butt-center">
</form>

<?php include "footer.php"; ?>