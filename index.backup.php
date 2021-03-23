<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/vector-map/jqvmap.css">
    <link rel="stylesheet" href="assets/vendor/jvectormap/jquery-jvectormap-2.0.2.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <!-- css datatable-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.dataTables.min.css">
    <title>Effectif departement</title>
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css"/>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.php">Mklen International</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include('config/template/leftbar_index.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">

                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <?php include('config/template/header_index.php'); ?>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    
                    <!-- ============================================================== -->
                    <!--  page body  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- Chart departement  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Graphe pour l'éfféctif des département </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="graph_dept"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end Chart  -->
                        <!-- ============================================================== -->
                    </div>

                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- data table  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Tableau représentative des départements</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php 
                                        $connection = mysqli_connect("localhost", "root", "");
                                        $db = mysqli_select_db($connection, 'ebp'); 
                                        $sql="SELECT DISTINCT u.DeptId AS DeptId, u.Code AS Code, u.Effectif AS Effectif, COUNT(DISTINCT p.UserId) AS Nb_pres, (CASE WHEN a.UserId IS NULL THEN COUNT(DISTINCT p.UserId) ELSE COUNT(DISTINCT p.UserId) END) AS Nb_abs
                                        FROM t_dept u LEFT JOIN t_departement p ON u.DeptId=p.DeptId
                                        LEFT JOIN t_absence_jours a ON a.UserId=p.UserId AND a.Dates='2021-03-08'
                                        GROUP BY u.DeptId";
                                        $r_sql=mysqli_query($connection, $sql);
                                        ?>
                                        <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Departement</th>
                                                    <th>Effectif</th>
                                                </tr>
                                            </thead>
                                        <?php 
                                            while ($row = mysqli_fetch_array($r_sql)) {
                                        ?>        
                                                    <tr>
                                                        <td><a href="dept.php"><?php echo $row["DeptId"]; ?></a></td>
                                                        <td><a href="dept.php"><?php echo $row["Nb_pres"]; ?></a></td>
                                                        <td><a href="dept.php"><?php echo $row["Nb_abs"]; ?></a></td>
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
                        <!-- end data table  -->
                        <!-- ============================================================== -->
                    </div>
                    <!-- modal -->
                    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            ...
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end modal -->
                    <!-- ============================================================== -->
                    <!--  end page body  -->
                    <!-- ============================================================== -->
                </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('config/template/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 js-->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstrap bundle js-->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js-->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chartjs js-->
    <script src="assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="assets/vendor/charts/charts-bundle/chartjs.js"></script>
    <!-- main js-->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- jvactormap js-->
    <script src="assets/vendor/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- sparkline js-->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <script src="assets/vendor/charts/sparkline/spark-js.js"></script>
     <!-- dashboard sales js-->
    <script src="assets/libs/js/dashboard-sales.js"></script>
    <!-- Javascript datatable-->
    <script type="text/javascript" src="assets/vendor/datatables/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <!-- Print data -->
    <script type="text/javascript" src="assets/vendor/datatables/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/jszip.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/datatables.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="assets/vendor/datatables/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="assets/vendor/popper/popper.min.js"></script>
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
        });
    </script>
    <!-- Script chartjs -->
    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("config/graph/graph_dept.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var effectif = [];

                    for (var i in data) {
                        name.push(data[i].Code);
                        effectif.push(data[i].Effectif);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Departement Effectif',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: effectif
                            }
                        ]
                    };
                    var graphTarget = $("#graph_dept");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
    </script>
</body>
 
</html>