<?php  
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, 'ebp');

	if (isset($_POST['updateabs'])) {
		$user = $_POST['update_id'];
		$dept = $_POST['Code'];
		$code = $_POST['Code'];
		$dates = $_POST['Dates'];
		$entree = $_POST['Entree'];
		$sortie = $_POST['Sortie'];

		$query = "UPDATE xtest SET sorties='$sortie'
					WHERE mat='$user' AND code='$dept' AND code='$dept' AND dates='$dates' ";
		$query_run = mysqli_query($connection, $query);

		if($query_run){
			echo '<script> alert("Data Updated");</script>';
			header("Location: form.php");
		}else{
			echo '<script>alert("Data Not Updated");</script>';
		}
	}
?>