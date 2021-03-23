<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title></title>
</head>
<body>
<?php  


?>
<table style="text-align: center;">
	<thead>
		<tr>
			<th>UserId</th>
			<th>Name</th>
			<th>Fonction</th>
			<th>DeptId</th>
			<th>Code</th>
			<th>Effectif</th>
			<th>Dates</th>
			<th>Entrée</th>
		</tr>
	</thead>
	<tbody>
		<?php  
			$con = odbc_connect("mklen", " ", " ");
			$sql = "
			SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, Userinfo.Deptid AS DeptId, 
			t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif, DateValue(Checkinout.CheckTime) AS Dates, TimeValue(Checkinout.CheckTime) AS H_E
			FROM Userinfo, t_dept_save, Checkinout
			WHERE (((Userinfo.Deptid)=t_dept_save.DeptId) And ((t_dept_save.Code)<>'STC') And ((Checkinout.Userid)=Userinfo.Userid) 
			And ((DateValue(Checkinout.CheckTime))=Date()))
			";
			$res = odbc_exec($con, $sql);
			while ($row = odbc_fetch_array($res)) {
		?>
		<tr>
			<td><?php echo $row['UserId']; ?></td>
			<td><?php echo $row['Name']; ?></td>
			<td><?php echo $row['Fonction']; ?></td>
			<td><?php echo $row['DeptId']; ?></td>
			<td><?php echo $row['Code']; ?></td>
			<td><?php echo $row['Effectif']; ?></td>
			<td><?php echo $row['Dates']; ?></td>
			<td><?php echo $row['H_E']; ?></td>
		</tr>
		<?php  
			}
		?>
	</tbody>
</table>
</body>
</html>