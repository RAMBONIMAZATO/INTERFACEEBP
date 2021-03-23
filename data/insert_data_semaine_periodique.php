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
    <title>Collection de données</title>
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

                        if (isset($_POST['btn_travail'])) {
					        $BeginDate = $_POST['BeginDate'];
					        $EndDate = $_POST['EndDate'];
                            
                            /*Heures de travail*/
                            $q_travail_employee="INSERT INTO t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_entree, P_sortie, H_travail)
                                SELECT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie,
                                (CASE
                                   WHEN Code='ADM' THEN '08:00:00'
                                   ELSE '07:00:00'
                                END) AS P_entree,
                                (CASE
                                   WHEN Code='ADM' THEN '16:00:00'
                                   ELSE '17:45:00'
                                END) AS P_sortie,
                                H_travail
                                FROM t_h_e_s WHERE Dates='$BeginDate'
                                ";
                            $r_q_travail_employee = mysqli_query($connection, $q_travail_employee);
                            /*Retard des employées*/
                            $q_update_entree_sortie=" UPDATE t_h_travail 
                                        SET H_Retard=(timediff(H_entree, P_entree))
                                        WHERE SIGN(TIMEDIFF(H_entree, P_entree))>0 AND Dates='$BeginDate'
                                        ";
                            $r_q_update_entree_sortie = mysqli_query($connection, $q_update_entree_sortie);  
                            /*Calcul d'heures de travail*/
                            $entre_sortie = "UPDATE t_h_travail SET H_travail=(CASE
                                        WHEN (H_entree <= P_entree) THEN ABS(TIMEDIFF(H_sortie, P_entree))
                                        WHEN (H_entree > P_entree) THEN ABS(TIMEDIFF(H_sortie, H_entree))
                                    END) WHERE Dates='$BeginDate'";         
                            $r_entre_sortie = mysqli_query($connection, $entre_sortie); 


                            /**/
                            $q_update_pause=" UPDATE t_h_travail SET Pause=(CASE WHEN H_entree!=H_sortie THEN '00:45:00' END) WHERE Dates='$BeginDate'";
                            $r_q_update_pause = mysqli_query($connection, $q_update_pause);

                            $q_update_travail_pause=" UPDATE t_h_travail SET H_travail=TIMEDIFF(H_travail, Pause) WHERE Dates='$BeginDate'";
                            $r_q_update_travail_pause = mysqli_query($connection, $q_update_travail_pause);

                            /*night shift*/
                            /*$q1 = "INSERT INTO t_h_nuit(UserId, Name, Fonction, DeptId, Code, Dates, H_entree, H_sortie)
	                        SELECT e.UserId AS UserId, e.Name AS Name, e.Fonction AS Fonction,e.DeptId AS DeptId,e.Code AS DeptId, e.Dates AS Dates, e.H_entree AS H_entree, s.H_sortie AS H_sortie
	                        FROM t_night_shift_entree e LEFT JOIN t_night_shift_sortie s ON e.UserId = s.UserId WHERE e.Dates ='$BeginDate' AND s.Dates='$EndDate'";*/
	                        $q1 = "INSERT INTO t_h_nuit(UserId, Name, Fonction, DeptId, Code, Dates, H_entree, H_sortie)
	                        SELECT e.UserId AS UserId, e.Name AS Name, e.Fonction AS Fonction,e.DeptId AS DeptId,e.Code AS DeptId, e.Dates AS Dates, e.H_entree AS H_entree, s.H_sortie AS H_sortie
	                        FROM t_night_shift_entree e LEFT JOIN t_night_shift_sortie s ON e.UserId = s.UserId WHERE e.Dates ='$BeginDate' AND s.Dates='$EndDate'";
	                        $r_q1 = mysqli_query($connection, $q1);

	                        /*$q2= "UPDATE t_h_nuit SET Pause='01:00:00' WHERE Dates='$DateBegin'";*/
	                        $q2= "UPDATE t_h_nuit SET Pause='00:00:00' WHERE Dates='$BeginDate'";
	                        $r_q2 = mysqli_query($connection, $q2);
	                        
	                        $q3="UPDATE t_h_nuit SET P_entree='22:00:00' WHERE Dates='$BeginDate'";
	                        $r_q3 = mysqli_query($connection, $q3);
	                        

	                        $q4="UPDATE t_h_nuit SET H_travail=(CASE WHEN H_entree <= P_entree THEN TIMEDIFF(ADDTIME(TIMEDIFF(H_sortie, P_entree), '24:00:00'), Pause) 
	                            WHEN H_entree > P_entree THEN TIMEDIFF(ADDTIME(TIMEDIFF(H_sortie, H_entree), '24:00:00'), Pause) END) WHERE Dates='$BeginDate'";
	                        $r_q4 = mysqli_query($connection, $q4);
                            /*fin night shift*/
                            if($r_q_travail_employee && $r_q_update_entree_sortie && $r_entre_sortie && $r_q_update_pause && $r_q_update_travail_pause && $r_q1 && $r_q2 && $r_q3 && $r_q4){
                                echo '<div class="alert alert-success" role="alert">Les heures de travail '.$BeginDate.'  et '.$EndDate.' ont été inserées!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">Erreur d enregistrement des heures de travail!</div>';
                            }
                        }

                    ?>
                    <div class="row">       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h2 class="card-header">COLLECTIOIN DE DONNÉES HEURES TRAVAIL JOUR/NUIT</h2>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine_periodique.php" method="post">
                                        <label>DATE DU JOUR-1 : </label>
                                        <input type="date" name="BeginDate">
                                        <label>DATE DU JOUR : </label>
                                        <input type="date" name="EndDate">
                                        <label>INSERTION : </label>
                                        <button class="btn btn-primary" type="submit" name="btn_travail">INSERT</button>
                                    </form>
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
