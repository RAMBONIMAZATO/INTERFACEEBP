<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Interface EBP</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
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
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
<!--         <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content"> -->
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <!-- <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Résultat sur l'absence journalier </h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- page body -->
                <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Modal modification  -->
    <!-- ============================================================== -->
        <div class="modal fade" id="editmodal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">MODIFICATION</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="update_test.php" method="POST">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group">
                                <label for="Name">Nom:</label>
                                <input type="text" name="Name" id="Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="Fonction">Fonction:</label>
                                <input type="text" name="Fonction" id="Fonction" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="DeptId">Dept:</label>
                                <input type="text" name="DeptId" id="DeptId" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="Code">Code:</label>
                                <input type="text" name="Code" id="Code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="Dates">Date:</label>
                                <input type="datetime" name="Dates" id="Dates" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="H_pause">Pause:</label>
                                <input type="datetime" name="H_pause" id="H_pause" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updateabs" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- ============================================================== -->
    <!-- End Modal modification  -->
    <!-- ============================================================== -->
                <div class="row">
                    
                <!-- ============================================================== -->
                <!-- table absence resultat hebdomadaire -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Liste absent jours</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php  
                                            $con = odbc_connect("mklen", "", "");
                                            /*if (isset($_POST['show_btn'])) {
                                            	$Deptid = $_POST['show_id'];
                                                $Dates = $_POST['show_id2'];*/
	                                            $query = "SELECT UserId, Name, Fonction, DeptId, Code, Dates, H_pause FROM test_table WHERE Dates=#12/21/2020#";
	                                            $query_run = odbc_exec($con, $query);
                                            /*}*/
                                        ?>
                                        <table id="example" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                  <tr>
                                                   <th>UserId</th>
                                                   <th>Name</th>
                                                   <th>Fonction</th>
                                                   <th>Dept</th>
                                                   <th>Code</th>
                                                   <th>Dates</th>
                                                   <th>Pause</th>
                                                   <th>Modifier</th>
                                                  </tr>
                                            </thead>
                                        <?php 
                                            while ($row = odbc_fetch_array($query_run)) {
                                        ?>        
                                                    <tr>
                                                        <td><?php echo $row["UserId"]; ?></td>
                                                        <td><?php echo $row["Name"]; ?></td>
                                                        <td><?php echo $row["Fonction"]; ?></td>
                                                        <td><?php echo $row["DeptId"]; ?></td>
                                                        <td><?php echo $row["Code"]; ?></td>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                        <td><?php echo $row["H_pause"]; ?></td>
		                                                <td>
		                                                    <button type="button" class="btn btn-primary editbtn" >EDIT</button>
		                                                </td>
                                                    </tr>

                                        <?php        
                                            }
                                        ?>
                                        </table>
                                        <?php odbc_close($con); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                <!-- ============================================================== -->
                <!-- end table absence resultat hebdomadaire-->
                <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- end page body -->
                <!-- ============================================================== -->
                
            <!-- </div> -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../config/template/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
       <!--  </div> -->
        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chartjs js-->
    <script src="../assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="../assets/vendor/charts/charts-bundle/chartjs.js"></script>
    <!-- filter date -->
    <!-- <script src="../assets/libs/js/main-js.js"></script> -->
    <!-- <script src="../assets/lib-range/jquery-1.12.4.js"></script> -->
    <script src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/vendor/datepicker/tempusdominus-bootstrap-4.css" />
    <link rel="stylesheet" href="../assets/lib-range/bootstrap-datepicker.css" />
    <script src="../assets/lib-range/bootstrap-datepicker.js"></script>
    <script src="../assets/vendor/datepicker/moment.js"></script>
    <link rel="stylesheet" href="../assets/vendor/daterangepicker/daterangepicker.css" />
    <script src="../assets/vendor/datepicker/datepicker.js"></script>
    <!-- Print data -->
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/jszip.min.js"></script>
    <script type="text/javascript" src="../assets/print/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/vfs_fonts.js"></script>
    <!-- css datatable-->
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/buttons.dataTables.min.css">
    <!-- chartjs js-->
    <script src="../assets/charts/Chart.bundle.js"></script>
    <script src="../assets/charts/chartjs.js"></script>
    <!-- edit modal et datatable-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.editbtn').on('click', function(){
                $('#editmodal').modal('show');

                    $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function(){
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#Name').val(data[1]);
                    $('#Fonction').val(data[2]);
                    $('#DeptId').val(data[3]);
                    $('#Code').val(data[4]);
                    $('#Dates').val(data[5]);
                    $('#H_pause').val(data[6]);
            });
            $('#example').DataTable({
                dom: 'lBfrtip',
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
            });
        });
    </script>
</body>
 
</html>