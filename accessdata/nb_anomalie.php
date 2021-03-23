<?php
$con = odbc_connect("mklen", "", "");

/*$query ="SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Duty, Userinfo.Deptid AS Deptid, t_dept_save.Code AS Code, 
t_dept_save.Effectif AS Effectif, DateValue(Checkinout.CheckTime) AS Dates, TimeValue(Checkinout.CheckTime) AS H_E
FROM Userinfo, t_dept_save, Checkinout
WHERE (((Userinfo.Deptid)=[t_dept_save].[DeptId]) AND ((t_dept_save.Code)<>'STC') AND ((Checkinout.Userid)=[Userinfo].[Userid]) AND ((DateValue([Checkinout].[CheckTime]))=(Date()))) 
ORDER BY Userinfo.Userid";*/

/*$query="SELECT Userinfo.Userid AS UserId, MIN(Userinfo.Name) AS Name, MIN(Userinfo.Duty) AS Duty, MIN(Userinfo.Deptid) AS DeptId, MIN(t_dept_save.Code) AS Code, 
MIN(DateValue(Checkinout.CheckTime)) AS Dates, COUNT(Userinfo.Userid) AS Nb_user
FROM Userinfo, t_dept_save, Checkinout
WHERE (((Userinfo.Deptid)=[t_dept_save].[DeptId]) AND ((t_dept_save.Code)<>'STC') AND ((Checkinout.Userid)=[Userinfo].[Userid]) AND ((DateValue([Checkinout].[CheckTime]))=(Date()-1)))
GROUP BY Userinfo.Userid, Userinfo.Name";*/
$query="SELECT Userid, Name, Duty, Dept, Dates, Nb_Pointage FROM ANOMALIES_POINTAGE WHERE Dates=(Date()-1)";
$query_run = odbc_exec($con, $query);
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="../assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <!-- Ajout libraray -->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/select.bootstrap4.css"/>
<!-- eto ny farany -->
<title>Users List</title>


</head>
<body>
<div class="dashboard-main-wrapper">
	<?php include('../config/template/header.php'); ?>
		<div class="row">
        <div class="card-body">
		<div class="table-responsive">
		<form method="post" action="">
			<table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
				<thead>
				<tr>
					<th>Mat</th>
					<th>Name</th>
					<th>Fonction</th>
					<th>Dept</th>
                    <th>Dates</th>
                    <th>Nombre</th>
				</tr>
					</thead>
				<?php
                    while ($row = odbc_fetch_array($query_run)) {
				?>
					<tr>
						<td><?php echo $row["Userid"]; ?></td>
						<td><?php echo $row["Name"]; ?></td>
						<td><?php echo $row["Duty"]; ?></td>
						<td><?php echo $row["Dept"];?> </td>
                        <td><?php echo $row["Dates"]; ?></td>
                        <td><?php echo $row["Nb_Pointage"]; ?></td>
					</tr>
				<?php
					}
				?>
			</table>
            <?php odbc_close($con); ?>
			
		</form>
		</div>
		</div>
		</div>
		<?php include('../config/template/footer.php'); ?>
	</div>

     <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 js-->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstrap bundle js-->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js-->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chartjs js-->
    <script src="../assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="../assets/vendor/charts/charts-bundle/chartjs.js"></script>
    <!-- main js-->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- jvactormap js-->
    <script src="../assets/vendor/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- sparkline js-->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <script src="../assets/vendor/charts/sparkline/spark-js.js"></script>
     <!-- dashboard sales js-->
    <script src="../assets/libs/js/dashboard-sales.js"></script>
    <!-- Javascript datatable-->
    <script type="text/javascript" src="../assets/vendor/datatables/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <!-- Print data -->
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/jszip.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../assets/vendor/popper/popper.min.js"></script>
    <!--  print data-->
    <script type="text/javascript" language="javascript">
    
        $(document).ready(function() {
            $('#table_data').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'copy'
                ],
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
                
                
            });
        });

    </script>
</body>
</html>