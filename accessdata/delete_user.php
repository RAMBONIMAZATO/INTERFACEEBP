<?php
$con = odbc_connect("mklen", "", "");
$rowCount = count($_POST["users"]);
for($i=0;$i<$rowCount;$i++) {
	$mat=$_POST["users"][$i];
	$query="DELETE FROM Checkinout WHERE Logid=$mat";
	odbc_exec($con, $query);
}
odbc_close($con);
header("Location:suppression_anomalie.php");
?>


