<?php
// require_once "db.php";
$conn = mysqli_connect("localhost", "root", "");
$bd = mysqli_select_db($conn, 'ebp');
$rowCount = count($_POST["users"]);
for($i=0;$i<$rowCount;$i++) {
	$query="DELETE FROM t_sous_dept WHERE UserId='" . $_POST["users"][$i] . "'";
	mysqli_query($conn, $query);
}
header("Location:index.php");
?>
