<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PLAGE HORAIRE EMPLOYEES</title>
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
        
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Liste etat hebdomadaire</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Département</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">État</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Employée</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
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
                        <form action="test.php" method="POST">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group">
                                <label for="DeptName">DeptName:</label>
                                <input type="text" name="DeptName" id="DeptName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="SupDeptid">SupDeptid:</label>
                                <input type="text" name="SupDeptid" id="SupDeptid" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="DeptDes">DeptDes:</label>
                                <input type="text" name="DeptDes" id="DeptDes" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="TEST">TEST:</label>
                                <input type="text" name="TEST" id="TEST" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updatedept" class="btn btn-primary">Save</button>
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
                <!-- ============================================================== -->
                <!-- page body -->
                <!-- ============================================================== -->
                <div class="row">
                <!-- ============================================================== -->
                <!-- table retard journalier -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Employée</h5>
                                </div>
                                <div class="card-body">
                                    <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>DeptId</th>
                                                <th>DeptName</th>
                                                <th>SupDeptid</th>
                                                <th>DeptDes</th>
                                                <th>TEST</th>
                                                <th>Modification</th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $conn = odbc_connect("mklen", "", "");
                                        $sql = "SELECT  Deptid, DeptName, SupDeptid, DeptDes, TEST FROM Dept";
                                        if ($conn) {
                                            $res=odbc_exec($conn, $sql);
                                             while ($row = odbc_fetch_array($res)) { 
                                        ?>  
                                        <tr>
                                            <td><?php  echo $row['Deptid']; ?></td>
                                            <td><?php echo $row['DeptName']; ?></td>
                                            <td><?php echo $row['SupDeptid']; ?></td>
                                            <td><?php echo $row['DeptDes']; ?></td>
                                            <td><?php echo $row['TEST']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary editbtn" >EDIT</button>
                                            </td>
                                        </tr>
                                        <?php }
                                        }else{
                                            echo "Query failed".odbc_error();
                                        } 
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                <!-- ============================================================== -->
                <!-- end table retard journalier-->
                <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- end page body -->
                <!-- ============================================================== -->
            
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../config/template/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        
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
    <!--  print data-->
    
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
                        $('#DeptName').val(data[1]);
                        $('#SupDeptid').val(data[2]);
                        $('#DeptDes').val(data[3]);
                        $('#TEST').val(data[4]);
                });
                $('#table_data').DataTable({
                    dom: 'lBfrtip',
                    buttons: [
                        'excel', 'csv', 'pdf', 'copy', 'print'
                    ],
                    "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
                });
            });
        </script>

</body>
 
</html>