<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ebp");


// $sqlQuery = "SELECT distinct(Deptid) as Deptid,Code,Effectif FROM t_dept ORDER BY Deptid";
//$sqlQuery = "SELECT distinct(DeptId) as DeptId, Code, Nb_abs FROM t_abs WHERE Dates = Date(now())  ORDER BY DeptId";
$sqlQuery = "
			SELECT DISTINCT DeptId, Code, count(distinct UserId) AS Nb_abs
            FROM `t_absence_jours` WHERE ((Dates=DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AND (Obs IS NULL)) GROUP BY DeptId";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>