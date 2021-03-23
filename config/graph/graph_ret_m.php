<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ebp");


// $sqlQuery = "SELECT distinct(Deptid) as Deptid,Code,Effectif FROM t_dept ORDER BY Deptid";
$sqlQuery = "SELECT  DISTINCT DeptId, Code, sum(Nb_ret) as Nb_ret FROM t_pourcentage_retard WHERE MONTH(Dates)=MONTH(date_add(curdate(), interval -1 month)) GROUP BY DeptId";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>