<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Etat de pointage</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

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
        <!-- <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content"> -->
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
               <!--  <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Liste etat hebdomadaire</h2>
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
                    <?php            
                        $connection = mysqli_connect("localhost", "root", "");
                        $bd = mysqli_select_db($connection, 'ebp');
                        if (isset($_POST['search'])) {
                            $txtUser = $_POST['txtUser'];
                            $txtUser = $_POST['txtUser'];
                            $txtCode = $_POST['txtCode'];
                            $txtStartDate = $_POST['txtStartDate'];
                            $txtEndDate = $_POST['txtEndDate'];
                            $query = "SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Dates, H_entree, H_sortie, P_entree, H_Retard
                                        FROM t_h_travail WHERE (Dates BETWEEN '$txtStartDate' AND '$txtEndDate') AND (UserId='$txtUser') AND (DeptId='$txtCode') GROUP BY UserId, Dates";
                            $r_query = mysqli_query($connection, $query);
                        }
                    ?>
                <!-- ============================================================== -->
                <!-- table retard journalier -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                   <!--  <h5 class="mb-0">État hebdomadaire</h5> -->
                                    
                                    <form method="post">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>                                            
                                                        <label for="txtCode">Code dept : </label>
                                                        <select   name="txtCode"  id="txtCode" onchange="showUser(this.value)">
                                                            <option value="">Departement</option><option value="23">QA</option><option value="30">ADM</option>
                                                            <option value="31">BDR</option><option value="32">CPE</option><option value="33">CPL</option><option value="34">GNR</option><option value="35">EXP</option><option value="36">LN1</option><option value="37">LVG</option><option value="38">MNT</option>
                                                            <option value="39">MEC</option><option value="40">MRO</option><option value="41">SMP</option><option value="42">STR</option><option value="44">DPR</option><option value="45">FNT</option><option value="46">LN2</option><option value="47">LN3</option><option value="48">LN4</option><option value="49">LN5</option><option value="50">LN6</option><option value="51">LN7</option><option value="52">ZPR</option><option value="53">LN8</option><option value="54">LN9</option>
                                                            <option value="55">LN10</option><option value="56">LN11</option><option value="57">LN12</option>  <option value="58">IE</option>
                                                            <option value="59">LN13</option><option value="60">LN14</option> <option value="61">RLC</option>
                                                            <option value="62">LN15</option><option value="64">RESP</option><option value="66">TRAIN</option>
                                                            <option value="67">LN16</option><option value="68">GNBR</option><option value="69">LN17</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                            <div id="txtHint">
                                                                 <label>N° Mat : </label> 
                                                               <select name="txtUser" id="txtUser">
                                                                   <option value="">Employée</option>
                                                               </select>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <label>Debut : </label>
                                                        <input type="date" name="txtStartDate">
                                                    </td>
                                                    <td>
                                                        <label>Fin :</label>
                                                        <input type="date" name="txtEndDate">
                                                    </td>
                                                    <td>
                                                        <input type="submit" name="search" value="Affiche">
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                                        
                                    </form>
                                </div>
                                <div class="card-body">
                                    <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>N° Mat</th>
                                                <th>Nom et Prénom</th>
                                                <th>Dept</th>
                                                <th>Dates</th>
                                                <th>Entrée</th>
                                                <th>Sortie</th>
                                                <th>Plage</th>
                                                <th>Retard</th>
                                            </tr>
                                        </thead>
                                        <?php
                                           if (isset($_POST['search'])) {   
                                            while ($row = mysqli_fetch_array($r_query)) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $row['UserId']; ?></td>    
                                            <td><?php echo $row['Name']; ?></td>      
                                            <td><?php echo $row['Code']; ?></td>    
                                            <td><?php echo $row['Dates']; ?></td>    
                                            <td><?php echo $row['H_entree']; ?></td>   
                                            <td><?php echo $row['H_sortie']; ?></td>   
                                            <td><?php echo $row['P_entree']; ?></td>   
                                            <td><?php echo $row['H_Retard']; ?></td>
                                        </tr>  
                                        <?php } 
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

</body>
 
</html>