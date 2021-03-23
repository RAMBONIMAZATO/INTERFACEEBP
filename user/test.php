<?php  
	/*$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, 'ebp');*/

    $conn = odbc_connect("mklen", "", "");
	
	if (isset($_POST['updatedept'])) {
		$dept = $_POST['update_id'];
		$name = $_POST['DeptName'];
		$sup = $_POST['SupDeptid'];
		$des = $_POST['DeptDes'];
		$test = $_POST['TEST'];
		/*echo $dept;
		echo $code;
		echo $eff;*/
		$sql = "UPDATE Dept SET DeptName='$name', SupDeptid='$sup', DeptDes='$des', TEST='$test' WHERE DeptId=$dept";
		$resultat = odbc_exec($conn, $sql);
		header("Location: employees.php");
		/*$sql = "UPDATE t_dept_save SET t_dept_save.Code='$code', t_dept_save.Effectif='$eff' WHERE t_dept_save.DeptId=$dept";
		$res=odbc_exec($con, $sql);*/
/*		$query_run = mysqli_query($connection, $query);*/
		/*if($res){
			header("Location: employees.php");
		}else{
			echo 'Query failed'.odbc_error();
		}*/
	}
	/*odbc_close($con);*/
?>