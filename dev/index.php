<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table width="600" border="1">  
	<tr>  
		<th>Id</th>  
		<th>Code</th>  
		<th>Effectif</th> 
		<th>Edit</th>  
	</tr>  
	<?php 
	$con = odbc_connect("mklen", " ", " "); 
	$sql = "SELECT t_dept_save.DeptId AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif FROM t_dept_save";  
	$res = odbc_exec($con, $sql) or die ("Error Execute [".$sql."]");
	/*$res = odbc_exec($con, $sql) or die ("Error Execute [".$sql."]");*/   
	while($row = odbc_fetch_array($res)){  
	?>  
	<tr>  
		<td>
			<?php echo $row['DeptId']; ?>
		</td>  
		<td align="center">
			<?php echo $row['Code']; ?>
		</td>  
		<td align="center">
			<?php echo $row['Effectif']; ?>
		</td>
		<td><a href="update.php?DeptId=<?=$row['DeptId'];?>">Edit</a></td>  
		<!-- <a href="php_access_update2.php?CusID=<?=$row["DeptId"];?>">Edit</a> -->
	</tr>  
	<?php  
	}  
	?>  
</table>  
	<?php  
	odbc_close($con);  
	?> 
</body>
</html>