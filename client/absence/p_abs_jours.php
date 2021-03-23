<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pourcentage absence permanant</title>
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
        <div class="card-body">
                                <canvas id="graph_dept"></canvas>
                            </div>
        <?php
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $bd = mysqli_select_db($connection, 'ebp');
                                            //include('../config/connection/conn.php'); 
                                            $p_abs_jours = "
                                            SELECT distinct DeptId as DeptId, Code,  Effectif, DATE_FORMAT(Dates,'%d/%m/%Y') AS Dates, Nb_pres, Nb_abs, ROUND(P_abs, 1) AS P_abs, C, CM, AA, P,Com, Susp, RM, Recup,HP,MAP, SM 
                                            FROM t_pourcentage_abs WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR') GROUP BY DeptId";
                                            $r_abs_jours = mysqli_query($connection, $p_abs_jours);
                                        ?>
                                        <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                  <tr>
                                                   <th>Dept</th>
                                                   <th>Effectif</th>
                                                   <th>Dates</th>
                                                   <th>Pres</th>
                                                   <th>Abs</th>
                                                   <th>%abs</th>
                                                   <th>Conge</th>
                                                   <th>Mat</th>
                                                   <th>Abs auto</th>
                                                   <th>Perm</th>
                                                   <th>Com</th>
                                                   <th>Susp</th>
                                                   <th>Rep med</th>
                                                   <th>Recup</th>
                                                   <th>Hosp</th>
                                                   <th>MaP</th>
                                                   <th>SM</th>
                                                  </tr>
                                            </thead>
                                            <tbody>
                                        <?php 
                                            while ($row = mysqli_fetch_array($r_abs_jours)) {
                                        ?>        
                                                    <tr>
                                                        <td><?php echo $row["Code"]; ?></td>
                                                        <td><?php echo $row["Effectif"]; ?></td>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                        <td><?php echo $row["Nb_pres"]; ?></td>
                                                        <td><?php echo $row["Nb_abs"]; ?></td>
                                                        <td><?php echo $row["P_abs"]; ?></td>
                                                        <td><?php echo $row["C"]; ?></td>
                                                        <td><?php echo $row["CM"]; ?></td>
                                                        <td><?php echo $row["AA"]; ?></td>
                                                        <td><?php echo $row["P"]; ?></td>
                                                        <td><?php echo $row["Com"]; ?></td>
                                                        <td><?php echo $row["Susp"]; ?></td>
                                                        <td><?php echo $row["RM"]; ?></td>
                                                        <td><?php echo $row["Recup"]; ?></td>
                                                        <td><?php echo $row["HP"]; ?></td>
                                                        <td><?php echo $row["MAP"]; ?></td>
                                                        <td><?php echo $row["Nb_abs"]-$row["C"]-$row["CM"]-$row["AA"]-$row["P"]-$row["Com"]-$row["Susp"]-$row["RM"]-$row["Recup"]-$row["HP"]-$row["MAP"]; ?></td>
                                                    </tr>

                                        <?php        
                                            }
                                        ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                        <?php
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $bd = mysqli_select_db($connection, 'ebp');
                                            $q_sum = "
                                                    SELECT ROUND(sum(Nb_pres),0) AS T_pres, ROUND(sum(Nb_abs),0) AS T_abs, ROUND((sum(Nb_abs)*100)/(sum(Nb_pres)),2) AS T_p FROM t_abs WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                            $r_q_sum = mysqli_query($connection, $q_sum);
                                        ?>
                                                <td>Total</td>

                                        <?php 
                                            while ($row = mysqli_fetch_array($r_q_sum)) {
                                        ?>        
                                                <td><?php echo $row['T_pres']; ?></td>
                                                <td><?php echo $row['T_abs']; ?></td>
                                                <td><?php echo $row['T_p']; ?></td>
                                                <td>
                                                    <?php 
                                                        $q_c = "SELECT sum(C) AS c FROM conge WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_c = mysqli_query($connection, $q_c);
                                                        while ($c = mysqli_fetch_array($r_q_c)) { 
                                                            echo $c["c"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_cm = "SELECT sum(CM) AS cm FROM conge_mat WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_cm = mysqli_query($connection, $q_cm);
                                                        while ($cm = mysqli_fetch_array($r_q_cm)) { 
                                                            echo $cm["cm"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_aa = "SELECT sum(AA) AS aa FROM abs_auto WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_aa = mysqli_query($connection, $q_aa);
                                                        while ($aa = mysqli_fetch_array($r_q_aa)) { 
                                                            echo $aa["aa"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_p = "SELECT sum(P) AS p FROM permission WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_p = mysqli_query($connection, $q_p);
                                                        while ($p = mysqli_fetch_array($r_q_p)) { 
                                                            echo $p["p"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_com = "SELECT sum(Com) AS com FROM comission WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_com = mysqli_query($connection, $q_com);
                                                        while ($com = mysqli_fetch_array($r_q_com)) { 
                                                            echo $com["com"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_susp = "SELECT sum(Susp) AS susp FROM suspendu WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_susp = mysqli_query($connection, $q_susp);
                                                        while ($susp = mysqli_fetch_array($r_q_susp)) { 
                                                            echo $susp["susp"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_rm = "SELECT sum(RM) AS rm FROM rep_med WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_rm = mysqli_query($connection, $q_rm);
                                                        while ($rm = mysqli_fetch_array($r_q_rm)) { 
                                                            echo $rm["rm"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_recup = "SELECT sum(Recup) AS recup FROM Recup WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_recup = mysqli_query($connection, $q_recup);
                                                        while ($recup = mysqli_fetch_array($r_q_recup)) { 
                                                            echo $recup["recup"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_hp = "SELECT sum(HP) AS hp FROM hospitalise WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_hp = mysqli_query($connection, $q_hp);
                                                        while ($hp = mysqli_fetch_array($r_q_hp)) { 
                                                            echo $hp["hp"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $q_map = "SELECT sum(MAP) AS map FROM miseapied WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                        $r_q_map = mysqli_query($connection, $q_map);
                                                        while ($map = mysqli_fetch_array($r_q_map)) { 
                                                            echo $map["map"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php  
                                                     $q_sm="SELECT sum(SM) AS sm FROM  sans_motif WHERE (Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                                     $r_q_sm=mysqli_query($connection, $q_sm);
                                                     while ($sm=mysqli_fetch_array($r_q_sm)) {
                                                         echo $sm["sm"];
                                                     }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php        
                                            }
                                        ?>

                                        </tfoot>
                                        </table>
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- page body -->
                <!-- ============================================================== -->
               
                    <!-- ============================================================== -->
                    <!-- Chart departement  -->
                    <!-- ============================================================== -->
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Graphe d'absence jours</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="graph_dept"></canvas>
                            </div>
                        </div>
                    </div> -->
                    <!-- ============================================================== -->
                    <!-- end Chart  -->
                    <!-- ============================================================== -->
               
                    
                <!-- ============================================================== -->
                <!-- table absence resultat hebdomadaire -->
                <!-- ============================================================== -->



                <!-- ============================================================== -->
                <!-- end table absence resultat hebdomadaire-->
                <!-- ============================================================== -->
              
                <!-- ============================================================== -->
                <!-- end page body -->
                <!-- ============================================================== -->
                
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
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
                customize: function ( doc ) {
                  doc.content[0].alignment = 'center';
                },
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
    <!-- Script filter table -->
    <script type="text/javascript" language="javascript" >
        $(document).ready(function(){
        	showGraph();
    	});
        function showGraph()
        {
            {
                $.post("../config/graph/g_abs_j.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var effectif = [];

                    for (var i in data) {
                        name.push(data[i].Code);
                        effectif.push(data[i].Nb_abs);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Abs journalier',
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