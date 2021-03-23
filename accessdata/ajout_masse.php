<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liste comission</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/vector-map/jqvmap.css">
    <link rel="stylesheet" href="../assets/vendor/jvectormap/jquery-jvectormap-2.0.2.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <!-- css datatable-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/buttons.dataTables.min.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <?php include('../config/template/header.php'); ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- TABLEAU D'INSERTION EN MASSE -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <form method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    	<td>
					                        <label for="Code">Dept :</label>
					                        <select name="Code">
					                        	<?php  
			                                        $con = odbc_connect("mklen", "", "");
			                                        $q_dept ="SELECT Deptid, DeptName FROM Dept WHERE (Deptid<>1 AND Deptid<>65) ORDER BY DeptName";
			                                        $r_q_dept = odbc_exec($con, $q_dept);
			                                        while ($row = odbc_fetch_array($r_q_dept)) {
			                                    ?>
			                                    <option value="<?php echo $row['DeptName']; ?>"><?php echo $row['DeptName']; ?></option>
			                                    <?php
			                                        }
			                                    ?>
			                                    <?php odbc_close($con); ?> 
					                        </select>
					                    </td>
                                        <td>
                                        <td>
                                            <label>Dates : </label>
                                            <input type="datetime" name="StartDates" placeholder="DD/MM/YYYY  hh:mm:ss">
                                        </td>
                                        <td>
                                            <label>Affichage : </label>
                                            <button class="btn btn-primary" type="submit" name="search">AFFICHE</button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="card-body">
                    	<div class="table-responsive">
                        	<form method="post"> 
								<?php 
						            $con = odbc_connect("mklen", "", "");
						            if(isset($_POST['search'])){
                            			$dept = $_POST['Code'];
                            			$dates = $_POST['StartDates'];
						            	$q="SELECT  Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, Dept.DeptName AS Code, '$dates' AS Dates
						            	FROM Userinfo, Dept WHERE ((([Dept].[DeptName])='$dept') AND (([Userinfo].[Deptid])=([Dept].[Deptid])))";
						            	$r_q=odbc_exec($con, $q);
						        	}
						        ?>
						        <div class="card-header"><button class="btn btn-info" type="submit" name="Submit">INSERTION</button></div>
								<table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
									<thead>
										<tr>
											<th><input type="checkbox" name="select-all" id="select-all"></th>
											<th>Matricule</th>
											<th>Nom et prenom</th>
											<th>Fonction</th>
											<th>Dept</th>
											<th>Dates</th>
										</tr>
									</thead>
									<?php  
									if(isset($_POST['search'])){
										while ($row = odbc_fetch_array($r_q)) {
									?>
										<tr>
											<td><input type="checkbox" name="chkl[ ]" value="<?=$row["UserId"]?>"></td>
											<td><input type="hidden" name="UserId" value="<?=$row["UserId"]?>"><?php echo $row["UserId"]; ?></td>
											<td><input type="hidden" name="Name" value="<?=$row['Name']?>"><?php echo $row["Name"]; ?></td>
											<td><input type="hidden" name="Fonction" value="<?=$row['Fonction']?>"><?php echo $row["Fonction"]; ?></td>
											<td><input type="hidden" name="Code" value="<?=$row['Code']?>"><?php echo $row["Code"]; ?></td>
											<td><input type="hidden" name="Dates" value="<?=$row['Dates']?>"><?php echo $row["Dates"]; ?></td>
										</tr>
								<?php }
									} 
								?>
								</table>  
								<?php odbc_close($con); ?>
							</form>
                    	</div>
                    </div>
                    	
                	<?php  
						$con = odbc_connect("mklen", "", "");
						if(isset($_POST["Submit"])){
							$checkbox1 = $_POST['chkl'];
							$mat = $_POST['UserId'];
							$name = $_POST['Name'];
							$dates = $_POST['Dates'];
							for ($i=0; $i < sizeof($checkbox1); $i++) { 
								$query1 = "INSERT INTO Checkinout_test(UserId, Name, CheckTime) 
								SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, '$dates'
								FROM Userinfo WHERE Userinfo.Userid='$checkbox1[$i]'";
								odbc_exec($con, $query1);
							}
						}
						odbc_close($con);
					?>
                </div>
            </div>

		<?php include('../config/template/footer.php'); ?>
		<!-- ============================================================== -->
		<!-- END TABLEAU D'INSERTION EN MASSE -->
		<!-- ============================================================== -->
        </div>
        
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
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
    <!--  print data-->
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $('#table_data').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'excel', 'csv', 'pdf', 'copy', 'print'
                ],
                "lengthMenu": [[10, 50,500, -1],[10, 50,500, "All"]]
            });
            $('#example').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'excel', 'csv', 'pdf', 'copy', 'print'
                ],
                "lengthMenu": [[10, 50,500, -1],[10, 50,500, "All"]]
            });
        });
        $('#select-all').click(function(event) {   
	    if(this.checked) {
	        // Iterate each checkbox
	        $(':checkbox').each(function() {
	            this.checked = true;                        
	        });
	    } else {
	        $(':checkbox').each(function() {
	            this.checked = false;                       
	        });
	    }
		});
    </script>
</body>
 
</html>
