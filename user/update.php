<?php  
	/*$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, 'ebp');*/

    $conn = odbc_connect("mklen", "", "");
	
	if (isset($_POST['updateuser'])) {
		$dept = $_POST['update_id'];
		$code = $_POST['Code'];
		$eff = $_POST['Effectif'];
		/*echo $dept;
		echo $code;
		echo $eff;*/
		$sql = "UPDATE t_dept_save SET Code='$code', Effectif='$eff' WHERE DeptId=$dept";
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