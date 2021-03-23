<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<!-- <button type="submit" name="show">Show</button> -->
<table style="width:100%">
	<thead>
		<tr>
			<th>DeptId</th>
			<th>DeptCode</th>
			<th>DeptEff</th>
		</tr>
	</thead>
	<?php
/*	if (isset($_POST['show'])) {*/
			$conn = odbc_connect("mklen", "", "");
			$sql = "SELECT  DeptId, Code, Effectif FROM t_dept_save";
			if ($conn) {
				$res=odbc_exec($conn, $sql);
				/*if ($res) {
					echo "Query Executed";
				}else{
					echo "Query failed".odbc_error();
				}*/
				while ($row = odbc_fetch_array($res)) { 
	?>
					<tr>
						<td><?php  echo $row['DeptId']; ?></td>
						<td><?php echo $row['Code']; ?></td>
						<td><?php echo $row['Effectif']; ?></td>
					</tr>
	<?php  		}
			}else{
					echo "failed";
			}
		/*}*/
	?>
</table>
</body>
</html>