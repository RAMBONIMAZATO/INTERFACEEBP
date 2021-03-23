<?php 
$connection = mysqli_connect("localhost", "root", "");
$bd = mysqli_select_db($connection, 'ebp'); 
if (isset($_POST['countries'])) {
	$countries = $_POST['countries'];
	
	foreach ($countries as $key => $value) {
		echo "$value<br>";
		/*$q = "UPDATE t_dept_ancient SET Test='$value' WHERE DeptId='$value' ";
    	$q_run = mysqli_query($connection, $q);*/
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="POST" >
	<?php 
		$connection = mysqli_connect("localhost", "root", "");
    	$bd = mysqli_select_db($connection, 'ebp');
        $query = "SELECT DeptId AS Deptid, min(Code) AS DeptCode, count(UserId) AS DeptEff FROM t_dept_user GROUP BY  DeptId";
    	$query_run = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($query_run)) { 
    ?>
    	 <input type="checkbox" name="countries[]" value='<?php echo $row["DeptCode"]; ?>'>
    	 <input type="hidden" name="countries[]" value="<?php echo $row["DeptCode"]; ?>"><br>
    <!-- <input type="checkbox" name="countries[]" value="Administration"> ADM <br>
    <input type="checkbox" name="countries[]" value="QA"> QA <br>
    <input type="checkbox" name="countries[]" value="Maintenance"> MNT <br>
    <input type="checkbox" name="countries[]" value="Finishing"> FNT <br> -->
	<?php } ?>
    <p><input type="submit" class="btn btn-primary" value="Submit" /></p>
</form>
</body>
</html>