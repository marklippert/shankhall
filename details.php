<?php
include_once "inc/dbconfig.php";

$result = $mysqli->query("SELECT * FROM schedule WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = $result->fetch_array(MYSQLI_BOTH);

$PageTitle = date("F j, Y",$row['show_date']);
include "header.php";
?>

<div class="playbox details">
  <?php include "popup.php"; ?>
</div>

<?php include "footer.php"; ?>