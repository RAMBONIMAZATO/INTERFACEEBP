<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		$con = odbc_connect("mklen"," "," ");  
		$q = "SELECT * FROM t_dept_save";  
		$r_q = odbc_exec($con, $q) or die ("Error Execute [".$q."]");  
	?>
	<table width="600" border="1">
		<tr>
			<th>Id</th>
			<th>Dept</th>
			<th>Effectif</th>
			<th>Edit</th>
		</tr>
		<?php
		while ($row=odbc_fetch_array($r_q)) { 
		?>
		<tr>
			<td><div align="center"><?=$row["DeptId"];?></div>  </td>
			<td><div align="center"><?=$row["Code"]; ?></div> </td>
			<td><div align="center"><?=$row["Effectif"];?></div>  </td>
			<td><div align="center"><a href="php_access_update2.php?DeptId=<?=$row["DeptId"];?>">Edit</a></div></td>
		</tr>
		<?php } ?>
	</table>
		<?php 
			odbc_close($con); 
		?>
</body>
</html>
