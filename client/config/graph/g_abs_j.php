<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ebp");


$sqlQuery = "
			SELECT DISTINCT DeptId, Code, Nb_abs
            FROM `t_abs` WHERE Dates=Date(now()) ORDER BY Code";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>