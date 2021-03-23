<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liste night shift</title>
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
                <!-- <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Absence journalier </h2>
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
                
                <div class="row">
                    
                <!-- ============================================================== -->
                <!-- table retard journalier -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Liste night shift</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php  
                                        	$connection = mysqli_connect("localhost", "root", "");
                                            $bd = mysqli_select_db($connection, 'ebp');
                                            /*
                                            SELECT distinct UserId as UserId, Name,  Code, Dates, Obs
                                            FROM t_absence_jours WHERE (Dates=Date(now()) AND Obs='nightshift') GROUP BY UserId*/
                                            
                                            $q = "SELECT distinct UserId as UserId, Name, Fonction,Code, Dates, Obs FROM  `t_absence_jours`  
                                            WHERE (Dates = DATE( NOW( ) ) AND Obs='night shift') GROUP BY UserId";
                                            $r_q = mysqli_query($connection, $q);
                                        ?>
                                        <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Matricule</th>
                                                    <th>Nom et prénom</th>
                                                    <th>Fonction</th>
                                                    <th>Departement</th>
                                                    <th>Dates</th>
                                                    <th>Motif</th>
                                                    <!-- <th>H Entrée</th>
                                                    <th>H Sortie</th>
                                                    <th>Motif</th> -->
                                                </tr>
                                            </thead>
                                        <?php 
                                            while ($row = mysqli_fetch_array($r_q)) {
                                        ?>
                                                    <tr>
                                                        <td><?php echo $row["UserId"]; ?></td>
                                                        <td><?php echo $row["Name"]; ?></td>
                                                        <td><?php echo $row["Fonction"]; ?></td>
                                                        <td><?php echo $row["Code"]; ?></td>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                        <td><?php echo $row["Obs"]; ?></td>
                                                        <!-- <td><?php echo $row["Fonction"] ?></td>
                                                        <td><?php echo $row["H_entree"]; ?></td>
                                                        <td><?php echo $row["H_sortie"]; ?></td>
                                                        <td><?php echo $row["Motif"]; ?></td> -->
                                                    </tr>
                                        <?php
                                            }
                                        ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                <!-- ============================================================== -->
                <!-- end table retard journalier-->
                <!-- ============================================================== -->
                </div>
        <!-- <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content"> -->
                
                <!-- ============================================================== -->
                <!-- end page body -->
                <!-- ============================================================== -->
                
           <!--  </div> -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../config/template/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        <!-- </div> -->
        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
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
    </script>
</body>
 
</html>