<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form  method="POST">
		<button class="btn btn-primary" type="submit" name="insert">INSERTION</button>
	</form>
    <!--

		INSERT INTO t_user_dept(UserId, Name, Fonction, DeptId, Code, Effectif)
		SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, t_dept_save.DeptId AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif
		FROM Userinfo, t_dept_save
		WHERE (((t_dept_save.Code)<>'STC') And ((Userinfo.Deptid)=t_dept_save.DeptId))
		 -->
<!--
INSERTION TABLE DEPT SAVE IN MS ACCESS
		INSERT INTO t_dept_save(DeptId, Code, Effectif) 
		SELECT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((Dept.DeptName)<>'STC' And (Dept.DeptName)<>'MKLEN INTERNATIONAL'))
		GROUP BY Dept.Deptid 		
 -->
 <!-- INSERT INTO t_user_dept(UserId, Name, Fonction, DeptId, Code, Effectif) 	
    SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, t_dept_save.DeptId AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif
	FROM Userinfo, t_dept_save
	WHERE (((t_dept_save.Code)<>'STC') And ((Userinfo.Deptid)=t_dept_save.DeptId)); -->
<?php  
	$con=odbc_connect("mklen", "", "");
	$sql="
		INSERT INTO t_dept_save(DeptId, Code, Effectif) 
		SELECT DISTINCT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((Dept.DeptName)<>'STC' And (Dept.DeptName)<>'MKLEN INTERNATIONAL'))
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