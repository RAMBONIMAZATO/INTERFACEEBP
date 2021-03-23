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
    <!-- ajax selector -->
    <script>
        function showUser(str) {
          if (str=="") {
            document.getElementById("txtHint").innerHTML="";
            return;
          } 
          var xmlhttp=new XMLHttpRequest();
          xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
              document.getElementById("txtHint").innerHTML=this.responseText;
            }
          }
          xmlhttp.open("GET","get_user.php?q="+str,true);
          xmlhttp.send();
        }
    </script>
    <title>Collection des données</title>
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
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="container-fluid dashboard-content ">
        <!-- ============================================================== -->
        <!-- pageheader  -->
        <!-- ============================================================== -->
<!-- ######################################################################################################################################################### -->
			<div class="row">
                <!-- ============================================================== -->
                <!-- data table  -->
                <!-- ============================================================== -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tableau représentative des employées</h5>
                            <?php 
                            	$con_access=odbc_connect("mklen", "", "");

                            	$connection = mysqli_connect("localhost", "root", "");
								$bd = mysqli_select_db($connection, 'ebp');
								if(isset($_POST["Submit"])){
									$checkbox1 = $_POST['chkl'];
									$UserId=$_POST["UserId"];
									$Name = $_POST['Name'];
									$Fonction = $_POST['Fonction'];
									$Code = $_POST['Code'];
									$CheckTime = $_POST['CheckTime'];
									for ($i=0; $i < sizeof($checkbox1); $i++) { 
										/*$sql="INSERT INTO Checkinout(Userid, CheckTime) VALUES('".$UserId."', '".$CheckTime."')";
										$res=odbc_exec($con_access, $sql);*/
										$query = "INSERT INTO xtest(name, sex) VALUES('".$checkbox1[$i]."', '".$Name."')";
										mysqli_query($connection, $query);
									}
									header("Location: insertion_masse.php");
								} 
								/*odbc_close($con_access);*/
							?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form method="post">
	                                <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
	                                    <thead>
	                                        <tr>
	                                        	<th><input type="checkbox" name="select-all" id="select-all"></th>
	                                            <th>Matricule</th>
	                                            <th>Nom et prenom</th>
	                                            <th>Fonction</th>
	                                            <th>Dept</th>
	                                            <th>CheckTime</th>
	                                        </tr>
	                                    </thead>
	                                <?php 
	                                	$connection = mysqli_connect("localhost", "root", "");
	    								$bd = mysqli_select_db($connection, 'ebp');
	                                	if (isset($_POST['show_btn'])) {
									    	$Deptid = $_POST['show_id'];
									        $q_user = "SELECT UserId, Name, Fonction, Code, NOW() AS CheckTime FROM t_dept_user WHERE DeptId=$Deptid";
									        $r_user = mysqli_query($connection, $q_user);
									    }
	                                ?>
	                                <?php 
	                                    	while ($row = mysqli_fetch_array($r_user)) {
	                                ?>        
                                            <tr>
												<td><input type="checkbox" name="chkl[ ]" value="<?=$row["UserId"]?>"></td>
												<td><input type="hidden" name="UserId" value="<?=$row["UserId"]?>"><?php echo $row["UserId"]; ?></td>
												<td><input type="hidden" name="Name" value="<?=$row['Name']?>"><?php echo $row["Name"]; ?></td>
												<td><input type="hidden" name="Fonction" value="<?=$row['Fonction']?>"><?php echo $row["Fonction"]; ?></td>
												<td><input type="hidden" name="Code" value="<?=$row['Code']?>"><?php echo $row["Code"]; ?></td>
												<td><input type="hidden" name="CheckTime" value="<?=$row['CheckTime']?>"><?php echo $row["CheckTime"]; ?></td>
                                            </tr>

	                                <?php        
	                                    	}
	                                ?>
	                                </table>
	                                <button class="btn btn-success" type="submit" name="Submit">INSERTION</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end data table  -->
                <!-- ============================================================== -->
            </div>
<!-- ######################################################################################################################################################### -->
		</div>

        <!-- ============================================================== -->
        <!-- end pagebody  -->
        <!-- ============================================================== -->
        <!-- </div> -->
        
            <!-- </div> -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../config/template/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        <!-- </div> -->
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../assets/libs/js/dashboard-ecommerce.js"></script>
    <!--  ajout js-->
    <script type="text/javascript" src="../assets/vendor/datatables/js/datatables.min.js"></script>
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
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
            });
            $('#example').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'excel', 'csv', 'pdf', 'copy', 'print'
                ],
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
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
