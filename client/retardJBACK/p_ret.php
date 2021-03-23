<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pourcentage retard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/select.bootstrap4.css"/>
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
        <!-- <div class="card-header">
            <h5 class="mb-0">Graphe retard journalier </h5>
        </div> -->
        <!-- <div class="card-body">
            <canvas id="graph_ret"></canvas>
        </div> -->
        <div class="card-header">
            <h2 class="pageheader-title">Pourcentage retard jours </h2>
            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <?php  
    
				    $connection = mysqli_connect("localhost", "root", "");
				    $bd = mysqli_select_db($connection, 'ebp');             
				    $q = "SELECT DISTINCT DeptId AS DeptId, Code, Effectif, Nb_Ret, ROUND(P_Ret, 2) AS P_Ret, Dates 
				                    FROM t_pourcentage_retard_journalier WHERE (Dates=Date(now())) AND (Code!='STC')";
				    $r_q = mysqli_query($connection, $q);
                ?>
                <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Departement</th>
                            <th>Dates</th>
                            <th>Effectif</th>
                            <th>Nb retard</th>
                            <th>%retard</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        while ($row = mysqli_fetch_array($r_q)) {
                    ?>
                                <tr>
                                    <td><?php echo $row["Code"]; ?></td>
                                    <td><?php echo $row["Dates"]; ?></td>
                                    <td><?php echo $row["Effectif"]; ?></td>
                                    <td><?php echo $row["Nb_Ret"]; ?></td>
                                    <td><?php echo $row["P_Ret"]; ?></td>
                                </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                    <?php
                        $connection = mysqli_connect("localhost", "root", "");
                        $bd = mysqli_select_db($connection, 'ebp');
                        $q_sum = "
                                SELECT sum(Effectif) AS T_eff, sum(Nb_Ret) AS T_Ret, ROUND(((sum(Nb_Ret)*100)/sum(Effectif)),2) AS T_p FROM t_pourcentage_retard_journalier WHERE (Dates=Date(now()) AND Code!='STC')";
                        $r_q_sum = mysqli_query($connection, $q_sum);
                    ?>
                            <td>Total</td>

                    <?php 
                        while ($row = mysqli_fetch_array($r_q_sum)) {
                    ?>        
                    		<td><?php echo $row['T_eff']; ?></td>
                            <td><?php echo $row['T_Ret']; ?></td>
                            <td><?php echo $row['T_p']; ?></td>
                        </tr>
                    <?php        
                        }
                    ?>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php include('../config/template/footer.php'); ?>                

        
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
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/buttons.dataTables.min.css">
    <!-- chartjs js-->
    <script src="../assets/charts/Chart.bundle.js"></script>
    <script src="../assets/charts/chartjs.js"></script>
    <!--  print data-->
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $('#table_data').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {extend: 'excel', footer: true},
                    {extend: 'pdf', footer: true},
                    {extend: 'copy', footer: true},
                    {extend: 'print', footer: true},
                    {extend: 'csv', footer: true}
                ],
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
            });
        });
    </script>
    <!-- Script chartjs -->
    <script>
        
        /*$(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("../config/graph/graph_ret_j.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var effectif = [];

                    for (var i in data) {
                        name.push(data[i].Code);
                        effectif.push(data[i].Nb_ret);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Ret journalier',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: effectif
                            }
                        ]
                    };
                    var graphTarget = $("#graph_ret");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }*/
    </script>

</body>
 
</html>