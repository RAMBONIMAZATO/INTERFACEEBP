<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="php_access_update3.php?DeptId=<?=$_GET["DeptId"];?>" name="frmEdit" method="post">
		<?php  
			$con = odbc_connect("mklen", "", "");
			$q="SELECT * FROM t_dept_save WHERE DeptId='".$_GET["DeptId"]."'";
			$r_q=odbc_exec($con, $q);
			$row=odbc_fetch_array($r_q);
			if (!$row) {
				echo "Not found DeptId=".$_GET["DeptId"];
			}else{
		?>
		<table>
			<tr>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<td><div align="center"><input type="text" name="txtDeptId" value="<?=$row["DeptId"];?>"></div></td>
				<td><div align="center"><input type="text" name="txtCode" value="<?=$row["Code"];?>"></div></td>
				<td><div align="center"><input type="text" name="txtEffectif" value="<?=$row["Effectif"];?>"></div></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="submit">
	<?php }
		odbc_close($con);
	?>
	</form>
</body>
</html>