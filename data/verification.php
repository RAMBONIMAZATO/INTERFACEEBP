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
                    
                    
                    
                <div class="row">
                    
                <!-- ============================================================== -->
                <!-- table absence resultat hebdomadaire -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">VERIFIER LES DONNEES EXISTANTES</h5>
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="" method="post">
                                        <label>Debut : </label>
                                        <input type="date" name="DateBegin">
                                        <label>Fin :</label>
                                        <input type="date" name="DateEnd">
                                        <label>Insertion :</label>
                                        <button class="btn btn-info" type="submit" name="btn_travail">Affiche</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php 
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $db = mysqli_select_db($connection, 'ebp');
                                        if (isset($_POST['btn_travail'])) {
                                            $DateBegin = $_POST['DateBegin'];
                                            $DateEnd = $_POST['DateEnd'];
                                            $query="SELECT DISTINCT Dates FROM t_h_travail WHERE Dates BETWEEN '$DateBegin' AND '$DateEnd'";
                                            $r_query=mysqli_query($connection, $query);
                                        }
                                         ?>
                                        <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                  <tr>
                                                   <th>Dates</th>
                                                  </tr>
                                            </thead>
                                        <?php 
                                        if (isset($_POST['btn_travail'])) {
                                            while ($row = mysqli_fetch_array($r_query)) {
                                        ?>        
                                                    <tr>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                    </tr>

                                        <?php        
                                            }
                                        }
                                        ?>
                                        </table>
                                    </div>
                                </div>
                                    
                                <div class="card-body">
                                	<h5 class="mb-0">VERIFIER LES DONNEES EXISTANTES NUIT</h5>
                                    <div class="table-responsive">
                                        <?php 
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $db = mysqli_select_db($connection, 'ebp');
                                        if (isset($_POST['btn_travail'])) {
                                            $DateBegin = $_POST['DateBegin'];
                                            $DateEnd = $_POST['DateEnd'];
                                            $query="SELECT DISTINCT Dates FROM t_h_nuit WHERE Dates BETWEEN '$DateBegin' AND '$DateEnd'";
                                            $r_query=mysqli_query($connection, $query);
                                        }
                                         ?>
                                        <table id="example" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                  <tr>
                                                   <th>Dates</th>
                                                  </tr>
                                            </thead>
                                        <?php 
                                        if (isset($_POST['btn_travail'])) {
                                            while ($row = mysqli_fetch_array($r_query)) {
                                        ?>        
                                                    <tr>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                    </tr>

                                        <?php        
                                            }
                                        }
                                        ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                <!-- ============================================================== -->
                <!-- end table absence resultat hebdomadaire-->
                <!-- ============================================================== -->
                </div>


                    <!-- ################### FIN DISTINCT DATES POUR HEURES DE TRAVAIL ############################################### -->
                    

<!-- ########################################################################################################################################################## -->

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
                "lengthMenu": [[1, 2, 3, 4, 5, 6, 7, -1],[1, 2, 3,4, 5, 6, 7, "All"]]
            });
            $('#example').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'excel', 'csv', 'pdf', 'copy', 'print'
                ],
                "lengthMenu": [[1, 2, 3, 4, 5, 6, 7, -1],[1, 2, 3, 4, 5, 6, 7, "All"]]
            });
        });
    </script>
</body>
 
</html>