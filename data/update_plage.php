<?php  
	$connection = odbc_connect("mklen", "", "");

	if (isset($_POST['updateabs'])) {
		$user = $_POST['update_id'];
		$name = $_POST['Name'];
		/*$fonction = $_POST['Duty'];
		$dept = $_POST['Deptid'];*/
		$plage = $_POST['Plage_E'];
		
		$query="UPDATE Userinfo SET Plage_E='$plage' WHERE Userid='$user'";
		$r_q = odbc_exec($connection, $query) or die ("Error Execute [".$query."]");  

		if($r_q){
			echo '<script> alert("Data Updated");</script>';
			header("Location: plage_heures.php");
		}else{
			echo '<script>alert("Data Not Updated");</script>';
		}
	}
	odbc_close($connection);
?>