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
        <?php  
            $connection = mysqli_connect("localhost", "root", "");
            $db = mysqli_select_db($connection, 'ebp');
            ###################################################### HEURES SEMAINE NIGHT SHIFT #########################################################################
            /*if (isset($_POST['btn_semaine_nuit'])) {
            	$DateBegin = $_POST['DateBegin'];
            	$DateEnd = $_POST['DateEnd'];
            	$query = "INSERT INTO t_hs_nuit(UserId, Name, Fonction, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_semaine)
            	SELECT UserId, Name, Fonction, DeptId, Code, MIN(Dates) AS Dates_debut, MAX(Dates) AS Dates_fin, ABS(DATEDIFF(MIN(Dates), MAX(Dates))) AS Nb_jours,
				WEEK(Dates) AS Num_semaine, SEC_TO_TIME(SUM(TIME_TO_SEC(H_travail))) AS H_semaine
				FROM t_h_nuit WHERE (Dates BETWEEN '$DateBegin' AND '$DateEnd') GROUP BY UserId, Name
            	";
            	$r_query = mysqli_query($connection, $query);
            	if ($r_query) {
            		echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
            	}else{
            		echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
            	}
            	
            }*/
            ###################################################### HEURES SEMAINE NIGHT SHIFT #########################################################################

        ?>
<!--         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">COLLECTION HEURES SEMAINE NUIT</h5>
                    <div class="card-body">
                        <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                            <label>Date debut nuit: </label>
                            <input type="date" name="DateBegin">
                            <label>Date fin nuit:</label>
                            <input type="date" name="DateEnd">
                            <label>Insertion </label>
                            <button class="btn btn-primary" type="submit" name="btn_semaine_nuit">INSERTION</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
    <?php  
        $connection = mysqli_connect("localhost", "root", "");
        $db = mysqli_select_db($connection, 'ebp');
#########################################LIER DEUX TABLES t_h_nuit et t_h_travail#############################################################################
        if (isset($_POST['btn_jours_nuit'])) {
            $DateBegin = $_POST['DateBegin'];
            $q_j_n="INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_jours, H_nuit)
            SELECT t.UserId AS UserId, t.Name AS Name, t.DeptId AS DeptId, t.Code AS Code, t.Dates AS Dates, t.H_travail AS H_jours, n.H_travail AS H_nuit
            FROM t_h_travail t 
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND t.Dates=n.Dates
            WHERE t.Dates='$DateBegin' GROUP BY t.UserId, t.Name";
           
            $r_q_j_n=mysqli_query($connection, $q_j_n);

            $q_conge = "INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_conge)
            SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='conge' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='conge' AND Dates='$DateBegin'";
            $r_q_conge =mysqli_query($connection, $q_conge);

            $q_repos = "INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_repos)
            SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='repos medical' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='repos medical' AND Dates='$DateBegin'";
            $r_q_repos =mysqli_query($connection, $q_repos);

            $q_permission = "INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_permission)
            SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='permission' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='permission' AND Dates='$DateBegin'";
            $r_q_permission =mysqli_query($connection, $q_permission);

            $q_autoabs = "INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_autoabs)
            SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='absence autorise' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='absence autorise' AND Dates='$DateBegin'";
            $r_q_autoabs =mysqli_query($connection, $q_autoabs);

            $q_commission = "INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_commission)
            SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='comission' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='comission' AND Dates='$DateBegin'";
            $r_q_commission =mysqli_query($connection, $q_commission);

            $q_miseapied = "INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_miseapied)
            SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='miseapied' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='miseapied' AND Dates='$DateBegin'";
            $r_q_miseapied =mysqli_query($connection, $q_miseapied);
/*heures travail ferie*/
            /*$q_update_ferie="UPDATE t_h_ferie SET Pause='00:45:00',
            P_entree=(CASE WHEN Code='ADM' THEN '08:00:00' ELSE '07:00:00' END)
            ,P_sortie=(CASE WHEN Code='ADM' THEN '16:00:00' ELSE '17:45:00' END)";
            $r_q_update_ferie=mysqli_query($connection, $q_update_ferie);

            $q_update_wferie="UPDATE t_h_ferie SET H_travail=(CASE
                WHEN (H_entree <= P_entree) THEN ABS(TIMEDIFF(TIMEDIFF(H_sortie, Pause), P_entree))
                WHEN (H_entree > P_entree) THEN ABS(TIMEDIFF(TIMEDIFF(H_sortie, Pause), H_entree)) END)";
            $r_q_update_wferie=mysqli_query($connection, $q_update_wferie);*/

/*fin heures travail ferie*/
/*heures dimanche*/
            $qdim1="UPDATE `t_h_dimanche` SET `Plage_entree`=(CASE
                        WHEN Code='GNR' THEN '06:00:00'
                        WHEN Code='ADM' THEN '08:00:00'
                        ELSE '07:00:00'
                        END)";
            $r_qdim1=mysqli_query($connection, $qdim1);
            $qdim2="UPDATE `t_h_dimanche` SET `Plage_sortie`=(CASE
                        WHEN Code='ADM' THEN '16:00:00'
                        ELSE '17:45:00'
                        END)";
            $r_qdim2=mysqli_query($connection, $qdim2);

            $qdim3="UPDATE `t_h_dimanche` SET `Pause`='00:45:00'";
            $r_qdim3=mysqli_query($connection, $qdim3);

            $qdim4="UPDATE `t_h_dimanche` SET `H_travail`=(CASE
                        WHEN (H_entree <= Plage_entree) THEN ABS(TIMEDIFF(TIMEDIFF(H_sortie, Pause), Plage_entree))
                        WHEN (H_entree > Plage_entree) THEN ABS(TIMEDIFF(TIMEDIFF(H_sortie,Pause), H_entree))
                        END)";

            $r_qdim4=mysqli_query($connection, $qdim4);
/*fin heures dimanche*/
            if ($r_q_j_n && $r_q_conge && $r_q_repos && $r_q_permission && $r_q_autoabs && $r_q_commission && $r_q_miseapied) {
                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
            }
            
        }
#########################################FIN LIER DEUX TABLES t_h_nuit et t_h_travail#############################################################################
    ?>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">COLLECTION HEURES TRAVAIL JOURS NUIT CONGE</h5>
                    <div class="card-body">
                        <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                            <label>Date debut nuit: </label>
                            <input type="date" name="DateBegin">
                            <!-- <label>Date fin nuit:</label> <input type="date" name="DateEnd"> -->
                            <label>Insertion </label>
                            <button class="btn btn-success" type="submit" name="btn_jours_nuit">INSERTION</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php  
        $connection = mysqli_connect("localhost", "root", "");
        $db = mysqli_select_db($connection, 'ebp');
        ############################## INSERTION HEURES TRAVAIL JOURS NUIT ########################################################################################
        if (isset($_POST['btn_semaine_jours_nuit'])) {
            $DateBegin = $_POST['DateBegin'];
            $DateEnd = $_POST['DateEnd'];
            /*$query = "INSERT INTO t_semaine_jours_nuit(UserId, Name, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_semaine_jours, H_semaine_nuit, H_conge,H_repos, H_permission, H_autoabs, H_commission, H_miseapied)
            SELECT UserId, Name,DeptId,Code, MIN( Dates ) AS Dates_debut, MAX( Dates ) AS Dates_fin, ABS( DATEDIFF( MIN( Dates ) , MAX( Dates ) ) ) AS Nb_jours, WEEK( Dates ) AS Num_semaine, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_jours ) ) ) AS H_semaine_jours,SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_nuit) ) ) AS H_semaine_nuit,SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_conge) ) ) AS H_conge, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_repos) ) ) AS H_repos, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_permission) ) ) AS H_permission, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_autoabs) ) ) AS H_autoabs, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_commission) ) ) AS H_commission, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_miseapied) ) ) AS H_miseapied
            FROM t_jours_nuit WHERE (Dates BETWEEN  '$DateBegin' AND  '$DateEnd') GROUP BY UserId, Name";*/

            $query = "INSERT INTO t_semaine_jours_nuit(UserId, Name, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_semaine_jours, H_semaine_nuit, H_conge,H_repos, H_permission, H_autoabs, H_commission, H_miseapied)
            SELECT UserId, Name,DeptId,Code, MIN(DISTINCT Dates ) AS Dates_debut, MAX(DISTINCT Dates ) AS Dates_fin, ABS( DATEDIFF( MIN(DISTINCT Dates ) , MAX(DISTINCT Dates ) ) ) AS Nb_jours, WEEK(Dates ) AS Num_semaine, SEC_TO_TIME(SUM(TIME_TO_SEC( H_jours ) ) ) AS H_semaine_jours,SEC_TO_TIME( SUM(TIME_TO_SEC( H_nuit) ) ) AS H_semaine_nuit,SEC_TO_TIME( SUM(TIME_TO_SEC( H_conge) ) ) AS H_conge, SEC_TO_TIME( SUM(TIME_TO_SEC( H_repos) ) ) AS H_repos, SEC_TO_TIME( SUM(TIME_TO_SEC( H_permission) ) ) AS H_permission, SEC_TO_TIME( SUM(TIME_TO_SEC( H_autoabs) ) ) AS H_autoabs, SEC_TO_TIME( SUM(TIME_TO_SEC( H_commission) ) ) AS H_commission, SEC_TO_TIME( SUM(TIME_TO_SEC( H_miseapied) ) ) AS H_miseapied
            FROM t_jours_nuit WHERE (Dates BETWEEN  '$DateBegin' AND  '$DateEnd') GROUP BY UserId
            ";

            
/*            SELECT UserId, Name,DeptId,Code, MIN( Dates ) AS Dates_debut, MAX( Dates ) AS Dates_fin, ABS( DATEDIFF( MIN( Dates ) , MAX( Dates ) ) ) AS Nb_jours, WEEK( Dates ) AS Num_semaine, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_jours ) ) ) AS H_semaine_jours,SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_nuit) ) ) AS H_semaine_nuit FROM t_jours_nuit WHERE (Dates BETWEEN  '$DateBegin' AND  '$DateEnd')
            GROUP BY UserId, Name*/
            $r_query = mysqli_query($connection, $query);
            if ($r_query) {
                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                }
        }
        ############################# FIN INSERTION HEURES TRAVAIL JOURS NUIT ####################################################################################
        ?>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">COLLECTION HEURES SEMAINE JOURS NUIT AVEC MOTIF</h5>
                    <div class="card-body">
                        <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                            <label>Date debut : </label>
                            <input type="date" name="DateBegin">
                            <label>Date fin :</label>
                            <input type="date" name="DateEnd">
                            <label>Insertion </label>
                            <button class="btn btn-primary" type="submit" name="btn_semaine_jours_nuit">H SEMAINES</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




                    <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
############################################ HEURES SEMAINE ###################################################################################
                    if (isset($_POST['btn_jour_ferie_dimanche'])) {
                        $DateBeginJour = $_POST['DateBeginJour'];
                        $DateEndJour = $_POST['DateEndJour'];
                        $DateFerie = $_POST['DateFerie'];
                        $DateDimanche = $_POST['DateDimanche'];
                        /*$query="INSERT INTO t_h_total(UserId, Name, DeptId, Code, Dates_semaine, Num_semaine, H_semaine, Dates_ferie, H_ferie, Dates_dimanche, H_dimanche)
                        SELECT t.UserId, t.Name, t.DeptId, t.Code,MIN(t.Dates_debut) AS Dates_semaine,t.Num_semaine, t.H_semaine, f.Dates AS Dates_ferie ,f.H_travail AS H_ferie , d.Dates AS Dates_dimanche ,d.H_travail AS H_dimanche
                        FROM t_hs_semaine t
                        LEFT JOIN t_h_ferie f ON t.UserId=f.UserId AND f.Dates='$DateFerie'
                        LEFT JOIN t_h_dimanche d ON t.UserId=d.UserId AND d.Dates='$DateDimanche'
                        WHERE t.Num_semaine BETWEEN WEEK('$DateBeginJour') AND WEEK('$DateEndJour')
                        GROUP BY t.UserId";*/
                        $query="INSERT INTO t_h_supp(UserId, Name, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_jours, H_nuit, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied, H_ferie, H_dimanche)
                        SELECT t.UserId, t.Name, t.DeptId, t.Code, t.Dates_debut, t.Dates_fin, t.Nb_jours, t.Num_semaine, t.H_semaine_jours AS H_jours, t.H_semaine_nuit AS H_nuit, t.H_conge AS H_conge, t.H_repos AS H_repos, t.H_permission AS H_permission, t.H_autoabs AS H_autoabs, t.H_commission AS H_commission, t.H_miseapied AS H_miseapied, 
                        f.H_travail AS H_ferie, d.H_travail AS H_dimanche
                        FROM t_semaine_jours_nuit t
                        LEFT JOIN t_h_ferie f ON t.UserId=f.UserId AND f.Dates='$DateFerie'
                        LEFT JOIN t_h_dimanche d ON t.UserId=d.UserId AND d.Dates='$DateDimanche'
                        WHERE t.Num_semaine BETWEEN WEEK('$DateBeginJour') AND WEEK('$DateEndJour')
                        GROUP BY t.UserId,t.Name";
                        $r_query = mysqli_query($connection, $query);
                        
                        /**/
                        $qu1="UPDATE t_h_supp SET H_total=(CASE 
                             WHEN H_conge IS NULL THEN H_jours
                             WHEN H_jours IS NULL THEN H_conge 
                             ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
                         END)"; 
                         $r_qu1 = mysqli_query($connection, $qu1);

                        $qu2="UPDATE t_h_supp SET H_total=(CASE 
                                                     WHEN H_repos IS NULL THEN H_total
                                                     WHEN H_total IS NULL THEN H_repos 
                                                     ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_repos))
                                                 END)"; 
                        $r_qu2 = mysqli_query($connection, $qu2);
                        $qu3="UPDATE t_h_supp SET H_total=(CASE 
                                                    WHEN H_permission IS NULL THEN H_total
                                                    WHEN H_total IS NULL THEN H_permission 
                                                    ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_permission))
                                                END) ";
                        $r_qu3 = mysqli_query($connection, $qu3);
                        $qu4="UPDATE t_h_supp SET H_total=(CASE 
                                                    WHEN H_autoabs IS NULL THEN H_total
                                                    WHEN H_total IS NULL THEN H_autoabs 
                                                    ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_autoabs))
                                                END)";
                        $r_qu4 = mysqli_query($connection, $qu4);

                        $qu5="UPDATE t_h_supp SET H_total=(CASE 
                                                    WHEN H_commission IS NULL THEN H_total
                                                    WHEN H_total IS NULL THEN H_commission 
                                                    ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_commission))
                                                END)";
                        $r_qu5 = mysqli_query($connection, $qu5);
                        $qu6="UPDATE t_h_supp SET H_total=(CASE 
                                                    WHEN H_miseapied IS NULL THEN H_total
                                                    WHEN H_total IS NULL THEN H_miseapied 
                                                    ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_miseapied))
                                                END)";
                        $r_qu6 = mysqli_query($connection, $qu6);


                        $qu7="UPDATE t_h_supp SET H_normale='40:00:00'";
                        $r_qu7 = mysqli_query($connection, $qu7);

                        $qu8="UPDATE t_h_supp SET H_brut=(CASE WHEN H_total>H_normale THEN TIMEDIFF(H_total, H_normale) END)";
                        $r_qu8 = mysqli_query($connection, $qu8);

                        $qu9="UPDATE t_h_supp SET H30='08:00:00'";
                        $r_qu9 = mysqli_query($connection, $qu9);

                        $qu10="UPDATE t_h_supp SET HS30=(CASE 
                                                WHEN (H_brut>H30) THEN H30
                                                WHEN (H_brut<H30) THEN H_brut
                                                END)
                                                WHERE H_brut IS NOT NULL";
                        $r_qu10 = mysqli_query($connection, $qu10);

                        $qu11="UPDATE t_h_supp SET H50='12:00:00'";
                        $r_qu11 = mysqli_query($connection, $qu11);

                        $qu12="UPDATE t_h_supp SET HS50=(CASE 
                                                WHEN (H_total>H_normale AND TIMEDIFF(H_total, H_normale)>H30 AND TIMEDIFF(TIMEDIFF(H_total, H30), H_normale)<H50) THEN TIMEDIFF(TIMEDIFF(H_total, H30), H_normale)
                                                WHEN (H_total>H_normale AND TIMEDIFF(H_total, H_normale)>H30 AND TIMEDIFF(TIMEDIFF(H_total, H30), H_normale)>H50) THEN H50  
                                                END)";
                        $r_qu12 = mysqli_query($connection, $qu12);

                        $qu13="UPDATE t_h_supp SET H60='60:00:00'";
                        $r_qu13 = mysqli_query($connection, $qu13);

                        $qu14="UPDATE t_h_supp SET HS60=(CASE 
                                                WHEN (H_total>H60) THEN TIMEDIFF(H_total, H60)
                                                END)";
                        $r_qu14 = mysqli_query($connection, $qu14);

                        $qu15="UPDATE t_h_supp SET H_abs=(CASE WHEN H_total<H_normale THEN ABS(TIMEDIFF(H_total, H_normale))  END)";
                        $r_qu15 = mysqli_query($connection, $qu15);

                        $qu16="UPDATE t_h_supp SET Nb_jours=(CASE WHEN H_dimanche IS NULL THEN Nb_jours+1 ELSE Nb_jours+2 END)";
                        $r_qu16 = mysqli_query($connection, $qu16);
                        /**/
                        if($r_query && $r_qu1 && $r_qu2 && $r_qu3 && $r_qu4 && $r_qu5 && $r_qu6 && $r_qu7 && $r_qu8 && $r_qu9 && $r_qu10  && $r_qu11 && $r_qu12 && $r_qu13 && $r_qu14 && $r_qu15){
                                echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                        }
                    
                    }
############################################END HEURES SEMAINE #####################################################################################
                     ?>
        <!-- heures semaine -->
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">COLLECTION DE DONNEES JOURS  FERIES DIMANCHE</h5>
                <div class="card-body">
                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                        <label>Date debut jour: </label>
                        <input type="date" name="DateBeginJour">
                        <label>Date fin jour:</label>
                        <input type="date" name="DateEndJour">
                        <label>Date ferie:</label>
                        <input type="date" name="DateFerie">
                        <label>Date dimanche:</label>
                        <input type="date" name="DateDimanche">
                        <label>Insertion </label>
                        <button class="btn btn-primary" type="submit" name="btn_jour_ferie_dimanche">H SUPPLEMENTAIRES</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <!-- fin heures semaine -->

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
