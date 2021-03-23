<?php  
	$q = intval($_GET['q']);

	$con = mysqli_connect('localhost','root','','ebp');
	if (!$con) {
	  die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT UserId FROM t_dept_user WHERE DeptId = '".$q."'";
	$result = mysqli_query($con,$sql);
?>
 <label>N°Mat : </label>
 <select name="txtUser">
<?php 
while($row = mysqli_fetch_array($result)) {
?>
	<option value="<?php echo $row["UserId"]; ?>"><?php echo $row["UserId"]; ?></option>
<?php
	}
	mysqli_close($con);
?>
</select>
