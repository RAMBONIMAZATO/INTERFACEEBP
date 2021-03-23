<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form  method="POST">
		<button class="btn btn-primary" type="submit" name="del">SUPPRESSION</button>
	</form>
    
<?php  
	$con=odbc_connect("mklen", "", "");
	$connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ebp');

	$sql="
		DELETE FROM t_dept_save
		";
	$sql1="
		INSERT INTO t_dept_save(DeptId, Code, Effectif) 
		SELECT DISTINCT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((Dept.DeptName)<>'STC' And (Dept.DeptName)<>'MKLEN INTERNATIONAL'))
		GROUP BY Dept.Deptid
		";
    $q_del="
    DELETE FROM t_dept_user;
    ";
    $q_del_journalier="
    DELETE FROM t_dept_journalier;
    ";
	if (isset($_POST['del'])) {
		$res=odbc_exec($con, $sql);
		$res1=odbc_exec($con, $sql1);
		$r_del = mysqli_query($connection, $q_del);
        $r_del_journalier = mysqli_query($connection, $q_del_journalier);
		if ($res && $res1 && $r_del && $r_del_journalier) {
			echo "Data is empty";
			header("Location: ../../index.php");
		}else{
			echo "Data is not inserted";
		}
	}
	odbc_close($con);
?>

</body>
</html>