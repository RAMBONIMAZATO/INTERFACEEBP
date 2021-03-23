<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ebp");


$sqlQuery = "SELECT distinct DeptId as DeptId, Code, Effectif FROM t_dept_user ORDER BY Deptid";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>