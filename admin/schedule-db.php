<?php
include "../inc/dbconfig.php";

if ($_GET['a'] != "delete") {
  $ShowDate = strtotime($_POST['show_date']);
  //$EmbargoDate = strtotime($_POST['embargo_date']);
  $EmbargoDate = strtotime($_POST['embargo_date'] . " " . $_POST['embargo_hour']);
  $acg = (isset($_POST['acg'])) ? "yes" : "";
}

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO schedule (
                show_date,
                embargo_date,
                acg,
                time,
                cover,
                act1,
                act1_url,
                act1_image,
                act1_desc,
                act2,
                act2_url,
                act2_image,
                act2_desc,
                act2_minor,
                act3,
                act3_url,
                act3_image,
                act3_desc,
                act3_minor,
                act4,
                act4_url,
                act4_image,
                act4_desc,
                act4_minor,
                main_text,
                main_image,
                sticky,
                playbox,
                donttweet,
                wmse,
                sprecher,
                cascio,
                eightyeightnine,
                oneohtwoone,
                othersponsor,
                tickets
              ) VALUES (
                '$ShowDate',
                '$EmbargoDate',
                '$acg',
                '" . $_POST['time'] . "',
                '" . $mysqli->real_escape_string($_POST['cover']) . "',
                '" . $mysqli->real_escape_string($_POST['act1']) . "',
                '" . $_POST['act1_url'] . "',
                '" . $_POST['act1_image'] . "',
                '" . $mysqli->real_escape_string($_POST['act1_desc']) . "',
                '" . $mysqli->real_escape_string($_POST['act2']) . "',
                '" . $_POST['act2_url'] . "',
                '" . $_POST['act2_image'] . "',
                '" . $mysqli->real_escape_string($_POST['act2_desc']) . "',
                '" . $_POST['act2_minor'] . "',
                '" . $mysqli->real_escape_string($_POST['act3']) . "',
                '" . $_POST['act3_url'] . "',
                '" . $_POST['act3_image'] . "',
                '" . $mysqli->real_escape_string($_POST['act3_desc']) . "',
                '" . $_POST['act3_minor'] . "',
                '" . $mysqli->real_escape_string($_POST['act4']) . "',
                '" . $_POST['act4_url'] . "',
                '" . $_POST['act4_image'] . "',
                '" . $mysqli->real_escape_string($_POST['act4_desc']) . "',
                '" . $_POST['act4_minor'] . "',
                '" . $mysqli->real_escape_string($_POST['main_text']) . "',
                '" . $_POST['main_image'] . "',
                '" . $_POST['sticky'] . "',
                '" . $_POST['playbox'] . "',
                '" . $_POST['donttweet'] . "',
                '" . $_POST['wmse'] . "',
                '" . $_POST['sprecher'] . "',
                '" . $_POST['cascio'] . "',
                '" . $_POST['eightyeightnine'] . "',
                '" . $_POST['oneohtwoone'] . "',
                '" . $mysqli->real_escape_string($_POST['othersponsor']) . "',
                '" . $_POST['tickets'] . "'
              )";
    break;
  case "edit":
    $query = "UPDATE schedule SET
              show_date = '" . $ShowDate . "',
              embargo_date = '" . $EmbargoDate . "',
              acg = '" . $acg . "',
              time = '" . $_POST['time'] . "',
              cover = '" . $mysqli->real_escape_string($_POST['cover']) . "',
              act1 = '" . $mysqli->real_escape_string($_POST['act1']) . "',
              act1_url = '" . $_POST['act1_url'] . "',
              act1_image = '" . $_POST['act1_image'] . "',
              act1_desc = '" . $mysqli->real_escape_string($_POST['act1_desc']) . "',
              act2 = '" . $mysqli->real_escape_string($_POST['act2']) . "',
              act2_url = '" . $_POST['act2_url'] . "',
              act2_image = '" . $_POST['act2_image'] . "',
              act2_desc = '" . $mysqli->real_escape_string($_POST['act2_desc']) . "',
              act2_minor = '" . $_POST['act2_minor'] . "',
              act3 = '" . $mysqli->real_escape_string($_POST['act3']) . "',
              act3_url = '" . $_POST['act3_url'] . "',
              act3_image = '" . $_POST['act3_image'] . "',
              act3_desc = '" . $mysqli->real_escape_string($_POST['act3_desc']) . "',
              act3_minor = '" . $_POST['act3_minor'] . "',
              act4 = '" . $mysqli->real_escape_string($_POST['act4']) . "',
              act4_url = '" . $_POST['act4_url'] . "',
              act4_image = '" . $_POST['act4_image'] . "',
              act4_desc = '" . $mysqli->real_escape_string($_POST['act4_desc']) . "',
              act4_minor = '" . $_POST['act4_minor'] . "',
              main_text = '" . $mysqli->real_escape_string($_POST['main_text']) . "',
              main_image = '" . $_POST['main_image'] . "',
              sticky = '" . $_POST['sticky'] . "',
              playbox = '" . $_POST['playbox'] . "',
              donttweet = '" . $_POST['donttweet'] . "',
              notice = '" . $_POST['notice'] . "',
              wmse = '" . $_POST['wmse'] . "',
              sprecher = '" . $_POST['sprecher'] . "',
              cascio = '" . $_POST['cascio'] . "',
              eightyeightnine = '" . $_POST['eightyeightnine'] . "',
              oneohtwoone = '" . $_POST['oneohtwoone'] . "',
              othersponsor = '" . $mysqli->real_escape_string($_POST['othersponsor']) . "',
              tickets = '" . $_POST['tickets'] . "'
              WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM schedule WHERE id = '" . $_GET['id'] . "'";
    break;
  case "upload";
    $max_width = 350;
    $img_path = "../images/bands/";
    $TheImage = basename($_FILES['image']['name']);
    $target_path = $img_path . "tmp_" . $TheImage;
    $FinalImage = $img_path . $TheImage;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
      list($width_orig, $height_orig, $image_type) = getimagesize($target_path);

      if ($width_orig > $max_width) {
        switch ($image_type) {
          case 1: $im = imagecreatefromgif($target_path); break;
          case 2: $im = imagecreatefromjpeg($target_path); break;
          case 3: $im = imagecreatefrompng($target_path); break;
          default: trigger_error('Unsupported filetype!', E_USER_WARNING); break;
        }

        // Calculate resize numbers
        $aspect_ratio = (float) $height_orig / $width_orig;
        $img_height = round($max_width * $aspect_ratio);

        $newImg = imagecreatetruecolor($max_width, $img_height);
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $max_width, $img_height, $width_orig, $height_orig);

        //Generate the file, and rename it
        switch ($image_type) {
          case 1: imagegif($newImg,$FinalImage); break;
          case 2: imagejpeg($newImg,$FinalImage); break;
          case 3: imagepng($newImg,$FinalImage); break;
          default: trigger_error('Failed resize image!', E_USER_WARNING); break;
        }

        // Delete original file
        unlink($target_path);
      } else {
        rename($target_path, $FinalImage);
      }
    }

    break;
}

if ($query != "") $mysqli->query($query);

$mysqli->close();

if (isset($_GET['b'])) {
  $go = "schedule.php?b=" . $_GET['b'];
} else {
  $go = "schedule.php";
}

header( "Location: $go" );
?>