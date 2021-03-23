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
					
<!-- ######################################################################################################################################################### -->
                    <!-- INSERTION JOURS -->
                    <?php  
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        
                        if (isset($_POST['btn_heure_travail'])) {
                        	$txtJour1=$_POST["txtJour1"];
                        	$txtJour=$_POST["txtJour"];
                            /*Heures de travail*/
                            $q_travail_employee="INSERT INTO t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_entree, P_sortie, Pause, H_travail)
                            SELECT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie,(CASE WHEN Code='ADM' THEN '08:00:00' ELSE '07:00:00' END) AS P_entree,
                            (CASE WHEN Code='ADM' THEN '16:00:00' ELSE '17:45:00' END) AS P_sortie, (CASE WHEN H_entree!=H_sortie THEN '00:45:00' END) AS Pause , H_travail
                            FROM t_h_e_s WHERE Dates='$txtJour1'";
                            $r_q_travail_employee = mysqli_query($connection, $q_travail_employee);
                            /**/
                            $entre_sortie = "UPDATE t_h_travail SET H_travail=(CASE
                                    WHEN (H_entree <= P_entree) THEN ABS(TIMEDIFF(TIMEDIFF(H_sortie,Pause), P_entree))
                                    WHEN (H_entree > P_entree ) THEN ABS(TIMEDIFF(TIMEDIFF(H_sortie,Pause), H_entree))
                                END) WHERE Dates='$txtJour1'";         
                            $r_entre_sortie=mysqli_query($connection, $entre_sortie);
                            /**/
/*                            $q_travail_nuit="INSERT INTO t_h_nuit(UserId, Name, Fonction, DeptId, Code, Dates, H_entree, H_sortie, P_entree)
                            SELECT d.UserId AS UserId, d.Name AS Name, d.Fonction AS Fonction, d.DeptId AS DeptId, d.Code AS Code, e.Dates AS Dates, e.H_entree AS H_entree,s.H_sortie AS H_sortie,
                            '22:00:00' AS P_entree 
                            FROM t_dept_user d
                            LEFT JOIN  t_night_shift_sortie s ON s.UserId = d.UserId AND s.DeptId=d.DeptId
                            LEFT JOIN t_night_shift_entree e ON e.UserId=d.UserId AND e.DeptId=d.DeptId
                            WHERE e.Dates='$txtJour1' AND s.Dates= '$txtJour'";
                            $r_q_travail_nuit=mysqli_query($connection, $q_travail_nuit);*/

                            $update_travail_nuit="UPDATE t_h_nuit SET P_entree='22:00:00', H_travail=(CASE WHEN H_entree<=P_entree THEN ADDTIME(TIMEDIFF(H_sortie, P_entree), '24:00:00') 
                            WHEN H_entree > P_entree THEN ADDTIME(TIMEDIFF(H_sortie, H_entree),'24:00:00') END) WHERE Dates='$txtJour1'";
                            $r_update_travail_nuit = mysqli_query($connection, $update_travail_nuit);
                            /*&& $r_q_travail_nuit*/
                            if($r_q_travail_employee && $r_entre_sortie && $r_update_travail_nuit){
                                
                                echo '<div class="alert alert-success" role="alert">The data in '.$txtJour1.' and '.$txtJour.' is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                            }
                        }

                    ?>
                    <div class="row">       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h2 class="card-header">COLLECTIOIN DES HEURES DE TRAVAIL JOUR/NIGHT SHIFT/LOBE</h2>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_heure_travail.php" method="post">
                                        <label for="txtJour1">DATE DU JOUR-1 :</label>
                                        <input type="date" name="txtJour1">
                                        <label for="txtJour">DATE DU JOUR :</label>
                                        <input type="date" name="txtJour">
                                        <label>INSERTION : </label>
                                        <button class="btn btn-primary" type="submit" name="btn_heure_travail">HEURE TRAVAIL</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
############################################ HEURES NIGHT SHIFT###################################################################################
                    if (isset($_POST['btn_sup_h_travail'])) {
                        $SuprDate = $_POST['SuprDate'];
                        $qt_h_travail="DELETE FROM t_h_travail WHERE Dates='$SuprDate'";
                        $r_qt_h_travail=mysqli_query($connection, $qt_h_travail);

                        $qt_h_nuit="DELETE FROM t_h_nuit WHERE Dates='SuprDate'";
                        $r_qt_h_nuit=mysqli_query($connection, $qt_h_nuit);
                            /*&&  */
                        if($r_qt_h_travail && $r_qt_h_nuit){
                            echo '<div class="alert alert-success" role="alert">The data is deleted!</div>';
                        }else{
                            echo '<div class="alert alert-success" role="alert">The data is not deleted!</div>';
                        }
                        /*echo $SuprDate;*/
                    
                    }
############################################END HEURES NIGHT #####################################################################################
                     ?>
                    <div class="row">       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h2 class="card-header">SUPPRESSION DES EFFECTIFS</h2>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_heure_travail.php" method="post">
                                        <label>DATE DU JOUR : </label>
                                        <input type="date" name="SuprDate">
                                        <label>SUPPRESSION :</label>
                                        <button class="btn btn-danger" type="submit" name="btn_sup_h_travail">DELETE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    

    </div>
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
</body>
 
</html>
