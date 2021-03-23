<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ebp");


// $sqlQuery = "SELECT distinct(Deptid) as Deptid,Code,Effectif FROM t_dept ORDER BY Deptid";
//$sqlQuery = "SELECT distinct(DeptId) as DeptId,min(DeptCode) AS Code,count(UserId) AS Effectif FROM t_present WHERE Dates BETWEEN '2019-11-04' AND '2019-11-29' GROUP BY DeptId";
$sqlQuery = "SELECT DISTINCT DeptId, Code, Effectif, sum(Nb_abs) as Nb_abs FROM t_abs WHERE Dates=date_add(curdate(), interval -1 month)  GROUP BY DeptId";
$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>