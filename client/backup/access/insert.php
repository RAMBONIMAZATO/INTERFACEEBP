<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form  method="POST">
		<button class="btn btn-primary" type="submit" name="insert">INSERTION</button>
	</form>
<?php  
	$con=odbc_connect("mklen", "", "");
	$sql="
		INSERT INTO t_dept_save(DeptId, Code, Effectif) 
		SELECT DISTINCT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((t_dept_save.Code)<>'STC') AND ((Dept.DeptName)<>('MKLEN INTERNATIONAL')))
		GROUP BY Dept.Deptid
		";
	if (isset($_POST['insert'])) {
		$res=odbc_exec($con, $sql);
		if ($res) {
			echo "Data is inserted";
			header("Location: ../../index.php");
		}else{
			echo "Data is not inserted";
		}
	}
	odbc_close($con);
?>

</body>
</html>