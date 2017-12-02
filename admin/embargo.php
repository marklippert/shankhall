<?php
include "login.php";
$PageTitle = "Embargoed Show Links";
include "header.php";

$result = $mysqli->query("SELECT * FROM schedule WHERE embargo_date >= $rightnow ORDER BY show_date ASC");
 
while($row = $result->fetch_array(MYSQLI_BOTH)) {
  echo "<strong>" . date("n/j",$row['show_date']) . "</strong> ";

  echo $row['act1'];
  if ($row['act2'] != "") echo ", " . $row['act2'];
  if ($row['act3'] != "") echo ", " . $row['act3'];
  if ($row['act4'] != "") echo ", " . $row['act4'];

  if (!empty($row['acg'])) echo " [ACG]";

  echo "<br>\n";

  echo "https://shankhall.com/details.php?" . $row['id'] . "<br><br>\n";
}

include "footer.php";
?>