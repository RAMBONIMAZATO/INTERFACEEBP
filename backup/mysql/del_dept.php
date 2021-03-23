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
    /*$connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ebp');
	$sql="
		DELETE FROM t_dept_user
		";
	if (isset($_POST['del'])) {
		$res=mysqli_query($con, $sql);
		if ($res) {
			echo "Data is empty";
			header("Location: ../../index.php");
		}else{
			echo "Data is not inserted";
		}
	}*/
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ebp');
    if (isset($_POST['del'])) {
            $q_del="
            DELETE FROM t_dept_user;
            ";
            $r_del = mysqli_query($connection, $q_del);
            if($r_del){
                /*echo '
                <div class="alert alert-success" role="alert">
                  The data is delete!
                </div>';*/
                header("Location: ../../index.php");
            }else{
                echo '
                <div class="alert alert-danger" role="alert">
                  The data is not delete!
                </div>';
            }
    }
?>

</body>
</html>