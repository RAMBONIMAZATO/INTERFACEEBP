<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title></title>
</head>
<body>
<?php   
		$con = odbc_connect("mklen", " ", " ");
		$sql = "SELECT * FROM t_dept_save";
		$res=odbc_exec($con,$sql);
		$data_array = array();
		while ($row=odbc_fetch_array($res)) {
			$data_array[] = $row;
			/*$dept=$row['DeptId'];*/
		}

		$content = json_encode($data_array, true);
		echo $content;
/*		var_dump($data_array);*/

/*		$cont = json_decode($data_array);
		echo $cont;*/

 		/*$connection = mysqli_connect("localhost", "root", "");
        $bd = mysqli_select_db($connection, 'ebp');*/
		
		/*$dept = $content['DeptId'];
		$code = $content['Code'];
		$effectif = $content['Effectif'];*/




/*		$content = json_encode($data_array[], true);
		echo $content;*/
/*
		SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, Userinfo.Deptid AS Deptid,
		t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif, DateValue(Checkinout.CheckTime) AS Dates, TimeValue(Checkinout.CheckTime) AS H_E
		FROM Userinfo, t_dept_save, Checkinout
		WHERE (((Userinfo.Deptid)=t_dept_save.DeptId)) 
		AND ((t_dept_save.Code)<>'STC') 
		AND ((Checkinout.Userid)=Userinfo.Userid) 
		AND ((DateValue(Checkinout.CheckTime))=(Date()-1))
*/
/*		function dbquery($sql) {
		  $arr    = array();
		  $conn = odbc_connect('mklen',' ',' ');
		  $rs     = odbc_exec($conn,$sql);
		  $x      = 1;
		  while (odbc_fetch_row($rs)) {
		    for ($y = 1; $y <= odbc_num_fields($rs); $y++) 
		      $arr[$x][$y] = odbc_result($rs,$y);
		    $x++;
		  }
		  if ($x > 1)
		    return $arr;
		}
		$arr=dbquery("SELECT * FROM t_dept_save");*/
		
/*		for ($i=1; $i < 38; $i++) { */
/*			for ($j=1; $j < 4 ; $j++) { 
				echo $content = json_encode($arr[$j][$j], true);
			}*/
				/*$sql = "INSERT INTO t_dept() VALUES ($)"*/
			/*}
				echo "<br></br>";
		}

/*		echo $arr[1][1];
		echo $arr[1][2]; 
		echo $arr[1][3];*/
		/*$con = odbc_connect("mklen", " ", " ");
		$sql = "
			SELECT * FROM t_dept_save;
		";
		$res=odbc_exec($con,$sql);
		$data_array = array();
		while ($row=odbc_fetch_array($res)) {
			$data_array[] = $row;
		}*/
		/*echo $content[0];*/
		/*$content = json_encode($data_array, true);
		echo $content;*/
		/*echo $content['UserId'];
		echo $content['Name'];
		echo $content['Fonction'];
		echo $content['Deptid'];
		echo $content['Code'];
		echo $content['Effectif'];
		echo $content['Dates'];
		echo $content['H_E'];*/
?>
</body>
</html>