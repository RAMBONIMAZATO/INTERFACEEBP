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
<script language="javascript" src="users.js" type="text/javascript"></script>

</head>
<body>
<div class="dashboard-main-wrapper">
    <?php include('../config/template/header.php'); ?>
        <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> 					
        	<div class="card">
	        	<div class="card-header">
	        		<form method="post">
	        			<table id="table_data1" class="table table-striped table-bordered second" style="width: 100%;">
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
	                                    <label for="txtUser">Jours férie:</label>
	                                    <input type="date" name="txtFerie">
	                                </td>
	                                <td>
	                                    <label> Commentaire</label>
	                                    <input type="text" name="txtComment">
	                                </td>
	                                <td>
	                                    <label>INSERTION :</label>
	                                    <button class="btn btn-info" type="submit" name="insert">INSERT</button>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>        
	        		</form>
	        	</div>
		        <div class="card-body">
			            <table id="table_data" class="table table-striped table-bordered second" style="width: 100%;">
			                <thead>
			                <tr>
			                	<th><input type="checkbox" name="select-all" id="select-all"></th>
			                    <th>Id</th>
			                    <th>Jours</th>
			                    <th>Commentaire</th>
			                </tr>
			                    </thead>
			                <?php
			                	$connection = mysqli_connect("localhost", "root", "");
								$bd = mysqli_select_db($connection, 'ebp');
								if (isset($_POST["insert"])) {
									$txtFerie=$_POST["txtFerie"];
									$txtComment=$_POST["txtComment"];

									$query_insert="INSERT INTO t_ferie(Jours, Name) VALUES ('$txtFerie', '$txtComment')";
									$r_query_insert=mysqli_query($connection, $query_insert);
									if ($r_query_insert) {
										echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
									}else{
		                                echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
		                            }
								}
								$query= "SELECT id, Jours, Name FROM t_ferie";
								$query_run = mysqli_query($connection, $query);
			                    while ($row = mysqli_fetch_array($query_run)) {
			                ?>
			                    <tr>
			                    	<td><input type="checkbox" name="chkl[ ]" value="<?=$row["id"]?>"></td>
			                        <td><?php echo $row["id"]; ?></td>
			                        <td><?php echo $row["Jours"]; ?></td>
			                        <td><?php echo $row["Name"]; ?></td>
			                    </tr>
			                <?php
			                    }
			                ?>
			            </table> 
		        </div>
        	</div></div>
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
                "lengthMenu": [[10, 50, 300, -1],[10, 50, 300, "All"]]
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