<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title></title>
</head>
<body>
	<form method="post">
		<table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label>Dept : </label>
                        <input type="number" name="DeptId">
                    </td><td>
                        <label>Code : </label>
                        <input type="text" name="Code">
                    </td>
                    <td>
                        <label>Effectif : </label>
                        <input type="number" name="Effectif">
                    </td>
                    <td>
                    	<label>Dates: </label>
                    	<input type="date" name="Dates">
                    </td>
                    <td>
                    	<label>Heures:</label>
                    	<input type="time" name="Heures">
                    </td>
                    <td>
                    	<label for="txtSex">Sex</label>
                    	<select name="txtSex">
                    		<option value="Male">Male</option>
                    		<option value="Female">Female</option>
                    	</select>
                    </td>
                    <td>
                        <input type="submit" name="search" value="Affiche">
                    </td>
                </tr>
            </tbody>
        </table>
	</form>
	<div>
		<?php 
			$con=odbc_connect("mklen", "", "");
			
			if (isset($_POST['search'])) {
				/*
				echo ' '.$dept.' '.$code.' '.$eff.' ';
				echo '</br>';*/
				$dept=$_POST['DeptId'];
				$code=$_POST['Code'];
				$eff=$_POST['Effectif'];
				$dates =$_POST['Dates'];
				$heures =$_POST['Heures'];
				$txtSex = $_POST['txtSex'];
				$sql1="INSERT INTO t_dept_save(DeptId, Code, Effectif, Dates, Heures, Sex) VALUES('$dept', '$code', '$eff', '$dates', '$heures', '$txtSex')";
				/*
					INSERT INTO t_dept_save(DeptId, Code, Effectif) 
					SELECT DISTINCT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
					FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
					WHERE (((Dept.DeptName)<>'STC' And (Dept.DeptName)<>'MKLEN INTERNATIONAL'))
					GROUP BY Dept.Deptid*/
				$res1=odbc_exec($con, $sql1);
				if ($res1) {
					header("Location: insertion_access.php");
				}else{
					echo "The data is not inserted";
				}

			}
			odbc_close($con);
		?>
	</div>
</body>
</html>