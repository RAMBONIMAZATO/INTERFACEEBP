<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ebp");


// $sqlQuery = "SELECT distinct(Deptid) as Deptid,Code,Effectif FROM t_dept ORDER BY Deptid";
$sqlQuery = "SELECT DISTINCT DeptId, min(Code) AS Code, min(Effectif) AS Effectif, sum(Nb_abs) as Nb_abs FROM t_abs WHERE (MONTH(Dates)=MONTH(Date(now()))) AND (DAYOFWEEK(Dates) BETWEEN 1 AND 7) GROUP BY DeptId";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>