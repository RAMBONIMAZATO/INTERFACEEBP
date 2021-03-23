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
	$sql="
		DELETE FROM t_dept_save
		";
	if (isset($_POST['del'])) {
		$res=odbc_exec($con, $sql);
		if ($res) {
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