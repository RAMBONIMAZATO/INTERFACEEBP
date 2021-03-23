<?php  
	$q = intval($_GET['q']);

	$con = mysqli_connect('localhost','root','','ebp');
	if (!$con) {
	  die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,"ajax_demo");
	/*$sql="SELECT UserId FROM t_dept_user WHERE DeptId = '".$q."'";
	$result = mysqli_query($con,$sql);*/

	$sql2="SELECT UserId FROM t_dept_journalier WHERE DeptId = '".$q."'";
	$result2 = mysqli_query($con,$sql2);
?>
 <label>N°Mat : </label>
 <select name="txtUser">
<?php 
/*while($row = mysqli_fetch_array($result)) {
	if (is_null($row['UserId'])) {*/
		while($ligne = mysqli_fetch_array($result2)) {
?>
			<option value="<?php echo $ligne["UserId"]; ?>"><?php echo $ligne["UserId"]; ?></option>
<?php
		
	/*	}
	}else{*/
?>
	<!-- <option value="<?php echo $row["UserId"]; ?>"><?php echo $row["UserId"]; ?></option> -->
<?php
		/*}*/
	}

	mysqli_close($con);
?>
</select>
