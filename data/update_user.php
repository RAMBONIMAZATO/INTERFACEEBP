<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form  method="POST">
		<button class="btn btn-primary" type="submit" name="del">MISE A JOUR</button>
	</form>
    
<?php  
	$con=odbc_connect("mklen", "", "");
	$connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ebp');

	$sql="
		DELETE FROM t_dept_save
		";
/*
		SELECT DISTINCT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(DISTINCT Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((Dept.DeptName)<>'STC' And (Dept.DeptName)<>'MKLEN INTERNATIONAL'))
		GROUP BY Dept.Deptid*/
	$sql1="
		INSERT INTO t_dept_save(DeptId, Code, Effectif) 
		SELECT DISTINCT Dept.Deptid AS DeptId, MIN(Dept.DeptName) AS Code, COUNT((Userinfo.Userid)) AS Effectif
		FROM Userinfo, Dept 
		WHERE Userinfo.Deptid=Dept.Deptid
		AND Dept.DeptName<>'STC' AND Dept.DeptName<>'MKLEN INTERNATIONAL'
		GROUP BY Dept.Deptid
		";

    $q_del="
    DELETE FROM t_dept_user;
    ";

    $q_del_journalier="
    DELETE FROM t_dept_journalier;
    ";

    $q_dept="
    DELETE FROM t_dept
    ";

    $q_del_departement="DELETE FROM t_departement";


	if (isset($_POST['del'])) {
		$res=odbc_exec($con, $sql);
		$res1=odbc_exec($con, $sql1);
		$r_del = mysqli_query($connection, $q_del);
        $r_del_journalier = mysqli_query($connection, $q_del_journalier);
        $r_q_dept = mysqli_query($connection, $q_dept);
        $r_q_departement = mysqli_query($connection, $q_del_departement);
		if ($res && $res1 && $r_del && $r_del_journalier && $r_q_dept && $r_q_departement) {
			/*echo "Data is empty";*/
			header("Location: ../index.php");
		}else{
			echo "Data is not inserted";
		}
	}
	odbc_close($con);
?>

</body>
</html>