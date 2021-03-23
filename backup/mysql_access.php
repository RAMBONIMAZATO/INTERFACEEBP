<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table>
<?php  

$con_access = odbc_connect("mklen", "", "");
$sql_access = "
			SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, t_dept_save.DeptId AS DeptId,t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif
			FROM Userinfo, t_dept_save
			WHERE (((t_dept_save.Code)<>'STC') And ((Userinfo.Deptid)=t_dept_save.DeptId))
		";
$r_access = odbc_exec($con_access, $sql_access);

/*$con_mysql = mysqli_connect('localhost', 'root', '');
$db_mysql = mysqli_select_db($conn_myssl, 'ebp');
$sql_mysql = "
INSERT INTO t_user_dept(UserId, Name, Fonction, DeptId, Code, Effectif) VALUES (,,,,,);
			";
$r_mysql = mysqli_query($con_mysql, $sql_mysql);*/

?>
	<thead>
		<tr>
			<td>UserId</td>
		</tr>
	</thead>
<?php  while ($row = odbc_fetch_array($r_access)) {
?>
<tr>
	<td><?php $user = $row['UserId']; ?></td>
</tr>
<?php 
} 
 ?>
</table>

</body>
</html>
