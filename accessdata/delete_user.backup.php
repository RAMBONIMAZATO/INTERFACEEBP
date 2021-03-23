<?php
// require_once "db.php";
$connection = odbc_connect("mklen", "", "");
/**/
$rowCount = count($_POST["users"]);
for($j=0;$j<$rowCount;$j++) {
	$query_delete="DELETE * FROM Checkinout WHERE ([Checkinout].[Logid])='". $_POST["users"][$j] ."'";
	odbc_exec($connection, $query_delete);
	
	/*echo $_POST["users"][$j];
	echo "<br>";
	echo $_POST["users"][$j];
	echo "<br>";
	echo $_POST["users"][$j];
	echo "<br>";echo $_POST["UserId"];
	echo "<br>";*/
}
odbc_close($connection);
header("Location:anomalie_jours.php");
/*
*/

?>