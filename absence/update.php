<?php  
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, 'ebp');

	if (isset($_POST['updateabs'])) {
		$user = $_POST['update_id'];
		$mat = $_POST['UserId'];
		$dept = $_POST['DeptId'];
		$code = $_POST['Code'];
		$dates = $_POST['Dates'];
		$obs = $_POST['Obs'];

		$query = "UPDATE t_absence_jours SET Obs='$obs' 
					WHERE id='$user' AND Code='$code' AND Dates='$dates' ";
		$query_run = mysqli_query($connection, $query);

		if($query_run){
			echo '<script> alert("Data Updated");</script>';
			header("Location: modification.php");
		}else{
			echo '<script>alert("Data Not Updated");</script>';
		}
	}
?>