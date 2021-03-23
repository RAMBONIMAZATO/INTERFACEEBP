<?php  
	$connection = odbc_connect("mklen", "", "");

	if (isset($_POST['updateabs'])) {
		$user = $_POST['update_id'];
		$name = $_POST['Name'];
		$fonction = $_POST['Duty'];
		$dept = $_POST['Deptid'];
		/*$plage = $_POST['Plage_E'];*/
		
		$query="UPDATE Userinfo SET Name='$name', Duty='$fonction', Deptid='$dept' WHERE Userid='$user'";
		$r_q = odbc_exec($connection, $query) or die ("Error Execute [".$query."]");  

		if($r_q){
			echo '<script> alert("Data Updated");</script>';
			header("Location: modification_access.php");
		}else{
			echo '<script>alert("Data Not Updated");</script>';
		}
	}
	odbc_close($connection);
	
		/*$query_run = odbc_exec($connection, $query);*/
		/*$dept = $_POST['DeptId'];*/
	/*echo $user; 
		echo "<br>";
		echo $fonction;
		echo "<br>";
		echo $name;
		echo "<br>";
		echo $code;
		echo "<br>";
		echo $dates;
		echo "<br>";
		echo $dept;
		echo "<br>";
		echo '12/21/2020';*/
		/*$query = "UPDATE test_table SET Fonction='$fonction'
					WHERE UserId='$user' AND Dates=#$dates# ";*/
?>