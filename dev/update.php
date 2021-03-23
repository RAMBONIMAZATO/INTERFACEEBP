<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" action="index.php">
		<?php  
			$con = odbc_connect("mklen", " ", " ");
			$dept = $_GET['DeptId'];
			$sql = "SELECT t_dept_save.DeptId AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif FROM t_dept_save WHERE t_dept_save.DeptId='".$dept."'";
			$res = odbc_exec($con, $sql) or die ("Error Execute [".$sql."]");
			if(!$res){  
			echo "Not found CustomerID=".$_GET['DeptId'];  
			}else{  
			while($row = odbc_fetch_array($res)){
		?>
		<table>
			<tr>
				<th>DeptId</th>
				<th>Code</th>
				<th>Effectif</th>
			</tr>
			<tr>
				<td><input type="text" name="txtDeptId" value="<?php  echo $row['DeptId']; ?>"></td>
				<td><input type="text" name="txtCode" value="<?php  echo $row['Code']; ?>"></td>
				<td><input type="text" name="txtEffectif" value="<?php  echo $row['Effectif']; ?>"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="submit">
		<?php  }
			}
			odbc_close($con);
		?>
	</form>
</body>
</html>