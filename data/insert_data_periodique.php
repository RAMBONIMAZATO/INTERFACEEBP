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
    <title>Collection de données périodique</title>
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
					<div class="row">       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h2 class="card-header">ENREGISTREMENTS DES EMPLOYEES AVEC LES MOTIFS CONSECUTIFS</h2>
                                <div class="card-body">
                                    <form method="post">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label for="txtUser">N° MATRICULE :</label>
                                                        <input type="text" name="txtUser">
                                                    </td>
                                                    <td>
                                                        <label for="txtObs">MOTIF : </label>
                                                        <select   name="txtObs"  id="txtObs">
                                                            <option value="conge">Congé</option>
                                                            <option value="night shift">Night Shift</option>
                                                            <option value="miseapied">Mise à pied</option>
                                                            <option value="suspendu">Suspendu</option>
                                                            <option value="conge maternite">Congé de Maternité</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label> <div></div></label>
                                                        <label>DATE JOUR-1 DU MOTIF : </label>
                                                        <input type="date" name="txtStartDate">
                                                    </td>
                                                    <td>
                                                        <label> <div></div></label>
                                                        <label>DATE JOUR FIN DU MOTIF : </label>
                                                        <input type="date" name="txtEndDate">
                                                    </td>
                                                    <td>
                                                        <label>INSERTION :</label>
                                                        <button class="btn btn-info" type="submit" name="search">INSERT/SHOW</button>
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
                                                <th>Matricule</th>
                                                <th>Dates</th>
                                                <th>Motif</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $bd = mysqli_select_db($connection, 'ebp');
                                           if (isset($_POST['search'])) { 
                                                $txtUser = $_POST['txtUser'];
                                                $txtObs = $_POST['txtObs'];
                                                $txtStartDate = $_POST['txtStartDate'];
                                                $txtEndDate = $_POST['txtEndDate'];

                                                $day_count=0;
                                                while (0==0) {
                                                    $day_count++; 
                                        ?>
                                        <tr> 
                                            <td><?php echo $txtUser; ?></td>
                                            <td> <?php  echo $txtStartDate = date('Y-m-d', strtotime($txtStartDate . '+1 days')); ?></td>
                                            <td><?php echo $txtObs; ?></td>
                                        </tr>  
                                        <?php 
                                                $query = "INSERT INTO t_present_jours(UserId, Fonction, Name, DeptId, DeptCode, DeptEff, Dates,Motif)
                                                        SELECT UserId, Fonction, Name, DeptId, Code, Effectif, '$txtStartDate', '$txtObs' FROM t_dept_user
                                                        WHERE UserId='$txtUser'";
                                                $r_query = mysqli_query($connection, $query);
                                                if ($txtStartDate==$txtEndDate) {
                                                    break;
                                                }
                                            } 
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- ######################################################################################################################################################### -->
                    <!-- INSERTION JOURS -->
                    <?php  
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        /* COLLECTION DE DONNEES POUR LES RETARDS */
                        if (isset($_POST['btn_journalier'])) {
                            $DateRetard = $_POST['DateRetard'];
							/*insertion conge consécutif*/
							$conge_consecutif = "INSERT INTO t_absence_jours(UserId, Name, Fonction, DeptId, Code,Effectif, Dates, Obs)
							SELECT UserId, Name, Fonction, DeptId, DeptCode, DeptEff, Dates, Motif FROM t_present_jours WHERE (Dates='$DateRetard' AND Motif IS NOT NULL)
							";
							$r_conge_consecutif = mysqli_query($connection,$conge_consecutif);
							/*fin insertion conge consécutif*/
                            /*$StartDate = $_POST['StartDate'];*/
                            $q_retard_journalier = "
                                INSERT INTO t_retard_journalier(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_heures_journalier` 
                                WHERE ((Dates='$DateRetard' ) AND (Code!='ADMJ')AND (Code!='GNRJ') AND (H_E BETWEEN  '07:05:00' AND  '10:00:00'))
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_heures_journalier` 
                                WHERE ((Dates='$DateRetard' ) AND ( Code='ADMJ' ) AND (H_E BETWEEN  '08:05:00' AND  '10:00:00'))
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_heures_journalier` 
                                WHERE ((Dates='$DateRetard' ) AND (Code='GNRJ') AND (H_E BETWEEN  '06:05:00' AND  '10:00:00'))";
                            $r_q_journalier = mysqli_query($connection, $q_retard_journalier);

                            $q_update_journalier = "
                                UPDATE t_retard_journalier  
                                SET P_E=(
                                CASE
                                   WHEN Code='GNRJ' THEN '06:00:00'
                                   WHEN Code='ADMJ' THEN '08:00:00'
                                   ELSE '07:00:00'
                                END),
                                H_Ret=abs(TIMEDIFF(H_E, P_E))  WHERE Dates='$DateRetard'";
                            $r_q_update_journalier = mysqli_query($connection, $q_update_journalier);


                            $q_pourcentage_retard_journalier = "
                                INSERT INTO t_pourcentage_retard_journalier(DeptId, Code, Effectif, Nb_Ret, P_Ret, Dates)
                                SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_Ret, (count(UserId)*100/Effectif) AS P_Ret, Dates 
                                FROM t_retard_journalier WHERE Dates='$DateRetard' GROUP BY DeptId";
                            $r_q_pourcentage_retard_journalier = mysqli_query($connection, $q_pourcentage_retard_journalier);

                            $q_absence_journalier = "
                                INSERT INTO t_absence_journalier(UserId, Name, Fonction, DeptId, Code,Effectif, Dates)
                                SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, '$DateRetard' AS Dates
                                FROM t_dept_journalier 
                                WHERE UserId NOT IN (SELECT DISTINCT UserId FROM t_presence_journalier WHERE Dates = '$DateRetard' )";
                            $r_q_absence_journalier = mysqli_query($connection, $q_absence_journalier);

                            $q_pourcentage_absence_journalier = "
                                INSERT INTO `t_abs_journalier`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, P_abs) 
                                SELECT DISTINCT DeptId as DeptId, DeptCode as Code, DeptEff as Effectif, Dates, COUNT( UserId ) as Nb_pres , (
                                DeptEff - COUNT( distinct(Userid) )
                                ) as Nb_abs, ((
                                DeptEff - COUNT( distinct(Userid) )
                                ) *100 / DeptEff) as p_abs
                                FROM  `t_presence_journalier` WHERE Dates='$DateRetard' GROUP BY DeptId ";
                            $r_q_pourcentage_absence_journalier = mysqli_query($connection, $q_pourcentage_absence_journalier);

                            /* REQUETE HEURES RETARD PERMANANT*/
                            $insert_l_ret="
                                    INSERT INTO t_retard_jours(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E)
                                    SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E
                                    FROM  `t_pres_h_jours` 
                                    WHERE ((Dates='$DateRetard') AND (Code != 'ADM')AND (Code != 'GNR') AND (H_E BETWEEN  '07:05:00' AND  '10:00:00'))
                                    UNION DISTINCT
                                    SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E
                                    FROM  `t_pres_h_jours` 
                                    WHERE ((Dates='$DateRetard') AND ( Code ='ADM' ) AND (H_E BETWEEN  '08:05:00' AND  '10:00:00'))
                                    UNION DISTINCT
                                    SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_E
                                    FROM  `t_pres_h_jours` 
                                    WHERE ((Dates='$DateRetard') AND (Code ='GNR') AND (H_E BETWEEN  '06:05:00' AND  '10:00:00'))
                                    ";
                            $r_insert_l_ret = mysqli_query($connection, $insert_l_ret);

                            $q_retard_permanant=" UPDATE t_retard_jours  
                                            SET P_E=(
                                            CASE
                                               WHEN Code='GNR' THEN '06:00:00'
                                               WHEN Code='ADM' THEN '08:00:00'
                                               ELSE '07:00:00'
                                            END),
                                            H_ret=abs(TIMEDIFF(H_E, P_E))  WHERE Dates='$DateRetard'
                                            ";
                            $r_q_retard_permanant = mysqli_query($connection, $q_retard_permanant);

                            $pourcentage_retard_permanant = "
                                            INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                            SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                            FROM t_retard_jours WHERE Dates='$DateRetard' GROUP BY DeptId
                                            ";
                            $r_pourcentage_retard_permanant = mysqli_query($connection, $pourcentage_retard_permanant);


                            /*$insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs)
                            SELECT DISTINCT u.DeptId as DeptId, u.Code as Code, u.Effectif as Effectif,(CASE WHEN p.Dates IS NULL THEN '$DateRetard' ELSE p.Dates END) AS Dates, 
                            COUNT( p.UserId ) as Nb_pres , (u.Effectif-COUNT(distinct(p.UserId))) as Nb_abs, ((u.Effectif-COUNT(distinct(p.UserId)))*100/u.Effectif) as p_abs
                            FROM  t_dept u LEFT JOIN t_present_jours p ON u.DeptId=p.DeptId AND p.Dates='$DateRetard'
                            WHERE p.Motif IS NULL  
                            GROUP BY u.DeptId";
                            $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);*/

                            if($r_q_journalier && $r_q_update_journalier && $r_q_pourcentage_retard_journalier && $r_q_absence_journalier && $r_q_pourcentage_absence_journalier && 
                                $r_insert_l_ret && $r_q_retard_permanant && $r_pourcentage_retard_permanant){
                                        echo '<div class="alert alert-success" role="alert">Les retards du ' .$DateRetard. ' is inserted!</div>';
                                    }else{
                                        echo '<div class="alert alert-danger" role="alert">Erreur d enregistrement des retards!</div>';
                            }
                        }
                        ?>
                        <?php  
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        /* COLLECTION DE DONNEES POUR L'ABSENCE */
                        /*REQUETES ABSENCE PERMANANT*/
                        if (isset($_POST['btn_absence'])) {
                            $DateAbsent = $_POST['DateAbsent'];
                            $insert_l_abs = "
                                            INSERT INTO t_absence_jours(UserId, Name, Fonction, DeptId, Code,Effectif, Dates)
                                            SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, '$DateAbsent' AS Dates
                                            FROM t_dept_user WHERE UserId NOT IN (SELECT DISTINCT UserId FROM t_present_jours WHERE (Dates='$DateAbsent'))
                                            ";
                            $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                            if($r_insert_l_abs){
                                echo '<div class="alert alert-success" role="alert">The data is '.$DateAbsent.' inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                            }
                        }
                        ?>
                        <?php  
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        /* COLLECTION DE DONNEES POUR LES POURCENTAGES */
                        if (isset($_POST['btn_pourcentage'])) {
                            /*$StartDatePourcentage = $_POST['StartDatePourcentage'];*/
                            $EndDatePourcentage = $_POST['EndDatePourcentage'];

                            $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs)
                            SELECT DISTINCT u.DeptId as DeptId, u.Code as Code, u.Effectif as Effectif,
                            (CASE WHEN p.Dates IS NULL THEN '$EndDatePourcentage' ELSE p.Dates END) AS Dates, COUNT( p.UserId ) as Nb_pres , 
                            (u.Effectif-COUNT(distinct(p.UserId))) as Nb_abs, ((u.Effectif-COUNT(distinct(p.UserId)))*100/u.Effectif) as p_abs
                            FROM  t_dept u LEFT JOIN t_present_jours p ON u.DeptId=p.DeptId AND p.Dates='$EndDatePourcentage'
                            WHERE p.Motif IS NULL  
                            GROUP BY u.DeptId";
                            $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
                            if( $r_insert_p_abs){
                                echo '<div class="alert alert-success" role="alert">The data '.$EndDatePourcentage.'is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                            }
                        }

                    ?>
                    <div class="row">       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h2 class="card-header">COLLECTIOIN DES DONNÉES</h2>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_periodique.php" method="post">
                                        <label>DATE JOUR : </label>
                                        <input type="date" name="DateRetard">
                                        <!-- <label>INSERTION : </label> -->
                                        <button class="btn btn-primary" type="submit" name="btn_journalier">RETARD</button>                                        
                                        <label>DATE JOUR : </label>
                                        <input type="date" name="DateAbsent">
                                        <label>INSERTION : </label>
                                        <button class="btn btn-info" type="submit" name="btn_absence">ABSENCE</button>
                                        <!-- <label>DATE JOUR-1 : </label>
                                        <input type="date" name="StartDatePourcentage"> -->
                                        <!-- <label>INSERTION : </label> -->
                                        <!-- <label>DATE JOUR : </label>
                                        <input type="date" name="EndDatePourcentage"> 
                                        <button class="btn btn-success" type="submit" name="btn_pourcentage">POURCENTAGE</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
############################################ HEURES NIGHT SHIFT###################################################################################
                    if (isset($_POST['btn_sup_motif'])) {
                        $SuprDate = $_POST['SuprDate'];
                        $qt_abs="DELETE FROM t_abs WHERE Dates='$SuprDate'";
                        $r_qt_abs=mysqli_query($connection, $qt_abs);

                        $qmotif = "DELETE FROM `t_motif` WHERE Dates='$SuprDate'";
                        $r_qmotif = mysqli_query($connection, $qmotif);


                        $qconge = "DELETE FROM `conge` WHERE Dates='$SuprDate'";
                        $r_qconge = mysqli_query($connection, $qconge);

                        $qcongemat = "DELETE FROM `conge_mat` WHERE Dates='$SuprDate'";
                        $r_qcongemat = mysqli_query($connection, $qcongemat);

                        $qrepmed = "DELETE FROM `rep_med` WHERE Dates='$SuprDate'";
                        $r_qrepmed = mysqli_query($connection, $qrepmed);

                        $qabsauto = "DELETE FROM `abs_auto` WHERE Dates='$SuprDate'";
                        $r_qabsauto = mysqli_query($connection, $qabsauto);

                        $qpermission = "DELETE FROM `permission` WHERE Dates='$SuprDate'";
                        $r_qpermission = mysqli_query($connection, $qpermission);

                        $qsuspendu = "DELETE FROM `suspendu` WHERE Dates='$SuprDate'";
                        $r_qsuspendu = mysqli_query($connection, $qsuspendu);

                        $qrecup = "DELETE FROM `recup` WHERE Dates='$SuprDate'";
                        $r_qrecup = mysqli_query($connection, $qrecup);

                        $qcomission = "DELETE FROM `comission` WHERE Dates='$SuprDate'";
                        $r_qcomission = mysqli_query($connection, $qcomission);

                        $qhospitalise = "DELETE FROM `hospitalise` WHERE Dates='$SuprDate'";
                        $r_qhospitalise = mysqli_query($connection, $qhospitalise);

                        $qmiseapied = "DELETE FROM `miseapied` WHERE Dates='$SuprDate'";
                        $r_qmiseapied = mysqli_query($connection, $qmiseapied);

                        $qnightshift = "DELETE FROM `nightshift` WHERE Dates='$SuprDate'";
                        $r_qnightshift = mysqli_query($connection, $qnightshift);

                        $qsansmotif = "DELETE FROM `sans_motif` WHERE Dates='$SuprDate'";
                        $r_qsansmotif = mysqli_query($connection, $qsansmotif);

                        $qrepmed = "DELETE FROM `rep_med` WHERE Dates='$SuprDate'";
                        $r_qrepmed = mysqli_query($connection, $qrepmed);

                        $qpourabs = "DELETE FROM `t_pourcentage_abs` WHERE Dates='$SuprDate'";
                        $r_qpourabs = mysqli_query($connection, $qpourabs);
                        

                        $qpourccdi = "DELETE FROM `t_pourcentage_cdd_cdi` WHERE Dates='$SuprDate'";
                        $r_qpourccdi = mysqli_query($connection, $qpourccdi);

                        $qsum = "DELETE FROM `sumary` WHERE Dates='$SuprDate'";
                        $r_qsum = mysqli_query($connection, $qsum);

                        $qpourcabsence = "DELETE FROM `t_pourcentage_absence` WHERE Dates='$SuprDate'";
                        $r_qpourcabsence = mysqli_query($connection, $qpourcabsence);

                        if($r_qt_abs && $r_qmotif && $r_qconge && $r_qcongemat && $r_qrepmed && $r_qabsauto && $r_qpermission && $r_qsuspendu && $r_qrecup && $r_qcomission && $r_qhospitalise && 
                            $r_qmiseapied && $r_qnightshift && $r_qsansmotif && $r_qrepmed && $r_qpourabs && $r_qpourccdi &&  $r_qsum && $r_qpourcabsence){
                            echo '<div class="alert alert-primary" role="alert">The data ' .$SuprDate. ' is deleted!</div>';
                        }else{
                            echo '<div class="alert alert-danger" role="alert">The data is not deleted!</div>';
                        }
                    
                    }
############################################END HEURES NIGHT #####################################################################################
                     ?>
                    <div class="row">       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h2 class="card-header">SUPPRESSION DES EFFECTIFS</h2>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_periodique.php" method="post">
                                        <label>DATE DU JOUR : </label>
                                        <input type="date" name="SuprDate">
                                        <label>SUPPRESSION :</label>
                                        <button class="btn btn-danger" type="submit" name="btn_sup_motif">DELETE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

<?php  

    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ebp');                      
############################################################### REQUETE SUMARY MONTH #################################################################
    if (isset($_POST['btn_sumary_1'])) {
        $txtStartChoix = $_POST['txtStartChoix'];
        $txtEndChoix = $_POST['txtEndChoix'];
################################################ POURCENTAGE ABSENCE #######################################################################################
        $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs)
        SELECT DISTINCT u.DeptId as DeptId, u.Code as Code, u.Effectif as Effectif,
        '$txtEndChoix' AS Dates, COUNT(DISTINCT p.UserId ) as Nb_pres , 
        (u.Effectif-COUNT(DISTINCT p.UserId)) as Nb_abs, ((u.Effectif-COUNT(DISTINCT p.UserId))*100/u.Effectif) as p_abs
        FROM  t_dept u LEFT JOIN t_present_jours p ON u.DeptId=p.DeptId AND p.Dates='$txtEndChoix'
        WHERE p.Motif IS NULL  
        GROUP BY u.DeptId";
        $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
################################################ REQUETE MOTIF D'ABSENCE ###################################################################################
        /*requete absence motif*/
            $absence_motif="
            INSERT INTO t_motif(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, Obs, Dates_fin)
            SELECT  DISTINCT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, Obs, Dates_fin 
            FROM t_absence_jours WHERE ((Obs IS NOT NULL) AND Dates='$txtEndChoix' AND Code!='EXP' AND Code!='GNBR')
            GROUP BY UserId";
            $r_absence_motif = mysqli_query($connection, $absence_motif);
            /*requete conge*/
            $conge = "INSERT INTO conge(DeptId, Code, Dates, C)
                  SELECT DeptId, Code, Dates, COUNT(DISTINCT UserId ) AS C FROM  `t_motif` WHERE Obs='conge' AND Dates = '$txtEndChoix' GROUP BY DeptId, Dates";
            $r_conge = mysqli_query($connection, $conge);
            /*requete conge de maternite*/
            $maternite = "INSERT INTO conge_mat(DeptId, Code, Dates, CM)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS CM FROM  `t_motif`  WHERE Obs =  'conge maternite' AND Dates='$txtEndChoix' GROUP BY DeptId, Dates";
            $r_maternite = mysqli_query($connection, $maternite);
            /*requete repos medical*/
            $repos_medical = "INSERT INTO rep_med(DeptId, Code, Dates, RM)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS RM FROM  `t_motif` WHERE Obs =  'repos medical' AND Dates='$txtEndChoix'  GROUP BY DeptId, Dates";
            $r_repos_medical = mysqli_query($connection, $repos_medical);
            /*requete absence autorise*/
            $abs_auto = "INSERT INTO abs_auto(DeptId, Code, Dates, AA)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS AA FROM  `t_motif` WHERE Obs =  'absence autorise' AND Dates='$txtEndChoix' GROUP BY DeptId, Dates";
            $r_abs_auto = mysqli_query($connection, $abs_auto);
            /*requete permission*/
            $permission = "INSERT INTO permission(DeptId, Code, Dates, P)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS P FROM  `t_motif` WHERE Obs =  'permission' AND Dates='$txtEndChoix' GROUP BY DeptId, Dates";
            $r_permission = mysqli_query($connection, $permission);
            /*requete suspendu*/
            $suspendu = "INSERT INTO suspendu(DeptId, Code, Dates, Susp)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Susp FROM  `t_motif`  WHERE Obs='suspendu' AND Dates='$txtEndChoix' GROUP BY DeptId, Dates";
            $r_suspendu = mysqli_query($connection, $suspendu);
            /*requete recuperation*/
            $recuperation = "INSERT INTO recup(DeptId, Code, Dates, Recup)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Recup FROM  `t_motif` WHERE Obs =  'recuperation' AND Dates='$txtEndChoix'  GROUP BY DeptId, Dates";
            $r_recuperation = mysqli_query($connection, $recuperation);
            /*requete comissioin*/
            $comission = "INSERT INTO comission(DeptId, Code, Dates, Com)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Com FROM  `t_motif` WHERE Obs =  'comission' AND Dates='$txtEndChoix'  GROUP BY DeptId, Dates";
            $r_comission = mysqli_query($connection, $comission);
            /*requete hospitalise*/
            $hospitalise = "INSERT INTO hospitalise(DeptId, Code, Dates, HP)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS HP FROM  `t_motif`  WHERE Obs =  'hospitalise' AND Dates='$txtEndChoix' GROUP BY DeptId, Dates";
            $r_hospitalise = mysqli_query($connection, $hospitalise);
            /*requete mise à pied*/
            $miseapied = "INSERT INTO miseapied(DeptId, Code, Dates, MAP)
                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS MAP FROM  `t_motif`  WHERE Obs='miseapied' AND Dates='$txtEndChoix' GROUP BY DeptId, Dates
                ";
            $r_miseapied = mysqli_query($connection, $miseapied);
            /*requete night shift*/
            $nightshift = "INSERT INTO nightshift(DeptId, Code, Dates, NF) 
                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(DISTINCT UserId) as NF FROM t_absence_jours WHERE Obs='night shift' AND Dates='$txtEndChoix' GROUP BY DeptId
                ";
            $r_nightshift = mysqli_query($connection, $nightshift);
            /*requete sans motif*/
            $sansmotif = "INSERT INTO sans_motif(DeptId, Code, Dates, SM) 
                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(DISTINCT UserId) as SM FROM t_absence_jours WHERE Obs IS NULL AND Dates='$txtEndChoix' GROUP BY DeptId
                ";
            $r_sansmotif = mysqli_query($connection, $sansmotif);
            
            $pourcentage_motif ="
            INSERT INTO t_pourcentage_abs(DeptId,Code,Effectif, Nb_pres, Nb_abs,P_abs,C,CM,AA, P, Com,Susp,RM,Recup, HP, MAP, NF, SM, Dates)
            SELECT DISTINCT A.DeptId, A.Code, A.Effectif,A.Nb_pres,A.Nb_abs, (A.p_abs) AS P_abs, c.C, cm.CM, aa.AA,p.P, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, 
            m.MAP, nf.NF, sm.SM, A.Dates
            FROM t_abs A
            LEFT JOIN conge c ON A.DeptId = c.DeptId AND A.Dates=c.Dates
            LEFT JOIN conge_mat cm ON A.DeptId = cm.DeptId AND A.Dates=cm.Dates
            LEFT JOIN abs_auto aa ON A.DeptId = aa.DeptId AND A.Dates=aa.Dates
            LEFT JOIN permission p ON A.DeptId = p.DeptId AND A.Dates=p.Dates
            LEFT JOIN comission com ON A.DeptId = com.DeptId AND A.Dates=com.Dates
            LEFT JOIN suspendu sus ON A.DeptId = sus.DeptId AND A.Dates=sus.Dates
            LEFT JOIN rep_med rm ON A.DeptId = rm.DeptId AND A.Dates=rm.Dates
            LEFT JOIN hospitalise h ON A.DeptId = h.DeptId AND A.Dates=h.Dates
            LEFT JOIN recup rp ON A.DeptId = rp.DeptId AND A.Dates=rp.Dates
            LEFT JOIN miseapied m ON A.DeptId = m.DeptId AND A.Dates=m.Dates
            LEFT JOIN nightshift nf ON A.DeptId = nf.DeptId AND A.Dates=nf.Dates
            LEFT JOIN sans_motif sm ON A.DeptId=sm.DeptId AND A.Dates=sm.Dates
            WHERE A.Dates='$txtEndChoix' AND A.Code!='EXP' AND A.Code!='GNBR'
            GROUP BY A.DeptId
            ";
            $r_pourcentage_motif = mysqli_query($connection, $pourcentage_motif);
#######################################################FIN MOTIF D'ABSENCE #######################################################
########################################################REQUETE POURCENTAGE D'ABSENCE ############################################

            /*requete CDI*/
            $cdi = "
            INSERT INTO t_pourcentage_cdd_cdi(`DeptId`, `Code`, `EffJ_1`, `EffJ`, `Nb_pres`, `Nb_abs`, `P_abs`, `Conge`, `CM`, `AbsAuto`, `Perm`, `Com`, `Susp`, `RM`, `Recup`, `Hosp`, `Map`, `NS`, `SM`, `Dates`)
            SELECT DISTINCT A.DeptId, A.Code,E.Effectif AS EFFJ1, A.Effectif,A.Nb_pres,A.Nb_abs, ROUND(A.p_abs,1) AS P_abs, c.C, cm.CM, aa.AA,p.P, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, nf.NF, sm.SM, A.Dates
            FROM t_abs A
            LEFT JOIN conge c ON A.DeptId = c.DeptId AND A.Dates=c.Dates
            LEFT JOIN conge_mat cm ON A.DeptId = cm.DeptId AND A.Dates=cm.Dates
            LEFT JOIN abs_auto aa ON A.DeptId = aa.DeptId AND A.Dates=aa.Dates
            LEFT JOIN permission p ON A.DeptId = p.DeptId AND A.Dates=p.Dates
            LEFT JOIN comission com ON A.DeptId = com.DeptId AND A.Dates=com.Dates
            LEFT JOIN suspendu sus ON A.DeptId = sus.DeptId AND A.Dates=sus.Dates
            LEFT JOIN rep_med rm ON A.DeptId = rm.DeptId AND A.Dates=rm.Dates
            LEFT JOIN hospitalise h ON A.DeptId = h.DeptId AND A.Dates=h.Dates
            LEFT JOIN recup rp ON A.DeptId = rp.DeptId AND A.Dates=rp.Dates
            LEFT JOIN miseapied m ON A.DeptId = m.DeptId AND A.Dates=m.Dates
            LEFT JOIN nightshift nf ON A.DeptId = nf.DeptId AND A.Dates=nf.Dates
            LEFT JOIN sans_motif sm ON A.DeptId=sm.DeptId AND A.Dates=sm.Dates
            LEFT JOIN t_abs E  ON E.DeptId = A.DeptId AND E.Dates='$txtStartChoix'                         
            WHERE A.Dates='$txtEndChoix' AND A.Code!='BDRCDD' AND A.Code!='DPRCDD' AND A.Code!='FORMATION' AND A.Code!='LVGCDD' AND A.Code!='EXP' AND A.Code!='GNBR' AND
            A.Code!='FNTCDD'            
            GROUP BY A.Code";
            $r_cdi = mysqli_query($connection, $cdi);
            /*requete TOTAL CDI*/
            $tCDI="INSERT INTO `t_pourcentage_cdd_cdi`(`Code`, `EffJ_1`, `EffJ`, `Nb_pres`, `Nb_abs`, `P_abs`, `Conge`, `CM`, `AbsAuto`, `Perm`, `Com`, `Susp`, `RM`, `Recup`, `Hosp`, `Map`, `NS`, `SM`, `Dates`) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Total CDI' ELSE 'Total CDI' END), sum(EffJ_1), sum(EffJ), sum(Nb_pres), sum(Nb_abs), ROUND((sum(Nb_abs)*100/sum(EffJ)), 1), sum(Conge), sum(CM), sum(AbsAuto), sum(Perm), sum(Com), sum(Susp), sum(RM), sum(Recup), sum(Hosp), sum(Map), sum(NS), sum(SM), Dates 
            FROM `t_pourcentage_cdd_cdi` WHERE Dates='$txtEndChoix' AND Code!='EXP' AND Code!='GNBR' GROUP BY Dates";
            $r_tCDI = mysqli_query($connection, $tCDI);
            /*requete CDD*/
            $cdd = "INSERT INTO `t_pourcentage_cdd_cdi`(`DeptId`, `Code`, `EffJ_1`, `EffJ`, `Nb_pres`, `Nb_abs`, `P_abs`, `Conge`, `CM`, `AbsAuto`, `Perm`, `Com`, `Susp`, `RM`, `Recup`, `Hosp`, `Map`, `NS`, `SM`, `Dates`) 
            SELECT DISTINCT A.DeptId, A.Code,E.Effectif AS EFFJ1, A.Effectif,A.Nb_pres,A.Nb_abs, ROUND(A.p_abs,1) AS P_abs, c.C, cm.CM, aa.AA,p.P, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, nf.NF, sm.SM, A.Dates
            FROM t_abs A
            LEFT JOIN conge c ON A.DeptId = c.DeptId AND A.Dates=c.Dates
            LEFT JOIN conge_mat cm ON A.DeptId = cm.DeptId AND A.Dates=cm.Dates
            LEFT JOIN abs_auto aa ON A.DeptId = aa.DeptId AND A.Dates=aa.Dates
            LEFT JOIN permission p ON A.DeptId = p.DeptId AND A.Dates=p.Dates
            LEFT JOIN comission com ON A.DeptId = com.DeptId AND A.Dates=com.Dates
            LEFT JOIN suspendu sus ON A.DeptId = sus.DeptId AND A.Dates=sus.Dates
            LEFT JOIN rep_med rm ON A.DeptId = rm.DeptId AND A.Dates=rm.Dates
            LEFT JOIN hospitalise h ON A.DeptId = h.DeptId AND A.Dates=h.Dates
            LEFT JOIN recup rp ON A.DeptId = rp.DeptId AND A.Dates=rp.Dates
            LEFT JOIN miseapied m ON A.DeptId = m.DeptId AND A.Dates=m.Dates
            LEFT JOIN nightshift nf ON A.DeptId = nf.DeptId AND A.Dates=nf.Dates
            LEFT JOIN sans_motif sm ON A.DeptId=sm.DeptId AND A.Dates=sm.Dates
            LEFT JOIN t_abs E  ON E.DeptId = A.DeptId AND E.Dates='$txtStartChoix'                         
            WHERE A.Dates='$txtEndChoix' AND (A.Code='BDRCDD' OR A.Code='DPRCDD' OR A.Code='FORMATION' OR A.Code='LVGCDD' OR A.Code='FNTCDD')
            GROUP BY A.Code";
            $r_cdd = mysqli_query($connection, $cdd);
            /*requete TOTAL CDD*/
            $tCDD = "INSERT INTO `t_pourcentage_cdd_cdi`(`Code`, `EffJ_1`, `EffJ`, `Nb_pres`, `Nb_abs`, `P_abs`, `Conge`, `CM`, `AbsAuto`, `Perm`, `Com`, `Susp`, `RM`, `Recup`, `Hosp`, `Map`, `NS`, `SM`, `Dates`) 
            SELECT  (CASE WHEN Code IS NOT NULL THEN  'Total CDD' ELSE 'Total CDD' END), sum(EffJ_1), sum(EffJ), sum(Nb_pres), sum(Nb_abs), ROUND((sum(Nb_abs)*100/sum(EffJ)), 1), sum(Conge), sum(CM), sum(AbsAuto), sum(Perm), sum(Com), sum(Susp), sum(RM), sum(Recup), sum(Hosp), sum(Map), sum(NS), sum(SM), Dates FROM `t_pourcentage_cdd_cdi` 
            WHERE Dates='$txtEndChoix' AND (Code='BDRCDD' OR Code='DPRCDD' OR Code='FORMATION' OR Code='LVGCDD' OR Code='FNTCDD') GROUP BY Dates";
            $r_tCDD = mysqli_query($connection, $tCDD);
##################################################END REQUETE POURCENTAGE D'ABSENCE########################################
##################################################BEGIN REQUETE SUMARY WITH MOTH     ########################################
            /*requete administration / general */
            $adm = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Administration/General' ELSE 'Administration/General' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'ADM' OR Code = 'GNR')";
            $r_adm = mysqli_query($connection, $adm);
            /*requete compliance */
            $compliance = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Compliance' ELSE 'Compliance' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'CPL')";
            $r_compliance = mysqli_query($connection, $compliance);
            /*requete cleaners */
            $cleaners = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Cleanears/Tree planting/Plant nursery' ELSE 'Cleanears/Tree planting/Plant nursery'END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'CPLC')";
            $r_cleaners = mysqli_query($connection, $cleaners);
            /*requete security */
            $security = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Security' ELSE 'Security' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'GNRS')";
            $r_security = mysqli_query($connection, $security);
            /*requete store*/
            $store = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Raw Materials/Parts' ELSE 'Raw Materials/Parts' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'STR')";
            $r_store= mysqli_query($connection, $store);
            /*requete zipper*/
            $zipper = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Zipper Assembly' ELSE 'Zipper Assembly'END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'ZPR')";
            $r_zipper = mysqli_query($connection, $zipper);
            /*requete Pre production*/
            $preproduction = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Pre_Production' ELSE 'Pre_Production' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'SMP' OR Code ='MRO' OR Code ='TRAIN' OR Code ='IE')";
            $r_preproduction = mysqli_query($connection, $preproduction);
            /*requete Pocket Setter*/
            $pocket_setter = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Pocket setter' ELSE 'Pocket setter' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'BDRPS')";
            $r_pocket_setter = mysqli_query($connection, $pocket_setter);
            /*requete embroidery*/
            $embroidery = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Embroidery' ELSE 'Embroidery' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'BDR')";
            $r_embroidery = mysqli_query($connection, $embroidery);
            /*requete cutting */
            $cutting = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Cutting' ELSE 'Cutting' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'CPE')";
            $r_cutting = mysqli_query($connection, $cutting);
            /*requete fusing*/
            $fusing = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Fusing' ELSE 'Fusing' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'CPEF')";
            $r_fusing = mysqli_query($connection, $fusing);
            /*requete sewing */
            $sewing = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Sewing' ELSE 'Sewing' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'LN1' OR Code='LN2' OR Code='LN3' OR Code='LN4' OR Code='LN5' OR Code='LN6' OR Code='LN7'
            OR Code = 'LN8' OR Code='LN9' OR Code='LN10' OR Code = 'LN11' OR Code='LN12' OR Code='LN13' OR Code='LN14' OR Code='LN15' OR Code='LN16' OR Code='LN17')";
            $r_sewing = mysqli_query($connection, $sewing);
            /*requete dry-process*/
            $dry_process = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Dry Process' ELSE 'Dry Process' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'DPR')";
            $r_dry_process= mysqli_query($connection, $dry_process);
            /*requete laundry*/
            $laundry = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Laundry' ELSE 'Laundry' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'LVG')";
            $r_laundry = mysqli_query($connection, $laundry);
            /*requete finishing */
            $finishing = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Finishing' ELSE 'Finishing' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'FNT')";
            $r_finishing = mysqli_query($connection, $finishing);
            /*requete ind left over*/
            $left_over = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Left over' ELSE 'Left over' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'FNTLO')";
            $r_left_over = mysqli_query($connection, $left_over);
            /*requete recycling */
            $recycling = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Recycling' ELSE 'Recycling' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'RCL')";
            $r_recycling = mysqli_query($connection, $recycling);
            /*requete Sewing maintenance*/
            $sewing_maintenance = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Sewing Maintenance' ELSE 'Sewing Maintenance' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'MEC')";
            $r_sewing_maintenance = mysqli_query($connection, $sewing_maintenance);
            /*requete general maintenance*/
            $general_maintenance = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'General Maintenance' ELSE 'General Maintenance' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'MNT')";
            $r_general_maintenance = mysqli_query($connection, $general_maintenance);
            /*requete Water treatement*/
            $water_treatement = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Water treatement/River service' ELSE 'Water treatement/River service' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'MNTWT')";
            $r_water_treatement = mysqli_query($connection, $water_treatement);
            /*requete QA*/
            $qa = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'QA' ELSE 'QA' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND (Code = 'QA')";
            $r_qa = mysqli_query($connection, $qa);
            /*requete total cdi DATE(NOW())*/
            $cdi = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Total' ELSE 'Total' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
            FROM  `t_pourcentage_abs`  WHERE Dates = '$txtEndChoix' AND Code!='BDRCDD'  AND Code!='DPRCDD' AND Code!='LVGCDD' AND Code!='FORMATION' AND Code!='FNTCDD' AND Code!='GNBR' AND Code!='EXP'";
            $r_cdi = mysqli_query($connection, $cdi);
####################################################### END REQUETE SUMARY OF MONTH     ##############################################################################

        /*motif des employée*/

################################################################REQUETE MISE EN FORME RESULTATS ##########################################################
            /*ADM*/
            $q1="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'ADM' ELSE 'ADM' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres, SUM(Nb_abs) AS Nb_abs,SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'ADM') AND Dates='$txtEndChoix'";
            $r_q1=mysqli_query($connection, $q1);

            /*BRODERIE*/
            $q2="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'BRODERIE' ELSE 'BRODERIE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs,  SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'BDR' OR Code='BDRPS') AND Dates='$txtEndChoix'";
            $r_q2=mysqli_query($connection, $q2);

            /*COMPLIANCE*/
            $q3="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'COMPLIANCE' ELSE 'COMPLIANCE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'CPL' OR Code='CPLC') AND Dates='$txtEndChoix'";
            $r_q3=mysqli_query($connection, $q3);

            /*COUPE MK1 ET MK3*/
            $q4="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'COUPE MK 01 ET MK3' ELSE 'COUPE MK 01 ET MK3' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'CPE' OR Code='CPEF') AND Dates='$txtEndChoix'";
            $r_q4=mysqli_query($connection, $q4);


            /*DRY PROCESS*/
            $q5="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'DRY-PROCESS' ELSE 'DRY-PROCESS' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'DPR' OR Code='DPR') AND Dates='$txtEndChoix'";
            $r_q5=mysqli_query($connection, $q5);

            /*FINITION*/
            $q6="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'FINITION' ELSE 'FINITION' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'FNT' OR Code='FNTLO') AND Dates='$txtEndChoix'";
            $r_q6=mysqli_query($connection, $q6);

            /*GENERAL*/
            $q7="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'GENERAL' ELSE 'GENERAL' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'GNR' OR Code='GNRS') AND Dates='$txtEndChoix'";
            $r_q7=mysqli_query($connection, $q7);


            /*IE*/
            $q8="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'IE' ELSE 'IE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'IE') AND Dates='$txtEndChoix'";
            $r_q8=mysqli_query($connection, $q8);

            /*LAVERIE*/
            $q9="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'LAVERIE' ELSE 'LAVERIE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'LVG') AND Dates='$txtEndChoix'";
            $r_q9=mysqli_query($connection, $q9);

            /*maintenance*/
            $q10="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'MAINTENANCE' ELSE 'MAINTENANCE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'MNT' OR Code='MNTWT') AND Dates='$txtEndChoix'";
            $r_q10=mysqli_query($connection, $q10);

            /*marker*/
            $q11="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'MARKER' ELSE 'MARKER' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'MRO') AND Dates='$txtEndChoix'";
            $r_q11=mysqli_query($connection, $q11);

            /*MECANO*/
            $q12="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'MECANO' ELSE 'MECANO' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'MEC') AND Dates='$txtEndChoix'";
            $r_q12=mysqli_query($connection, $q12);

            /*QA*/
            $q13="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'QA' ELSE 'QA' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'QA') AND Dates='$txtEndChoix'";
            $r_q13=mysqli_query($connection, $q13);

            /*RECYCLING*/
            $q14="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'RECYCLING' ELSE 'RECYCLING' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'RCL') AND Dates='$txtEndChoix'";
            $r_q14=mysqli_query($connection, $q14);

            /*SAMPLE*/
            $q15="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'SAMPLE' ELSE 'SAMPLE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'SMP') AND Dates='$txtEndChoix'";
            $r_q15=mysqli_query($connection, $q15);

            /*sewing*/
            $q16="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'SEWING' ELSE 'SEWING' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'LN1' OR Code='LN10' OR Code='LN11' OR Code='LN12' OR Code='LN13' OR Code='LN14' OR Code='LN15' OR Code='LN16' OR Code='LN17' OR Code='LN2' OR Code='LN3' OR Code='LN4' OR Code='LN5' OR Code='LN6' OR Code='LN7' OR Code='LN8' OR Code='LN9') AND Dates='$txtEndChoix'";
            $r_q16=mysqli_query($connection, $q16);

            /*STORE*/
            $q17="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'STORE' ELSE 'STORE' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'STR') AND Dates='$txtEndChoix'";
            $r_q17=mysqli_query($connection, $q17);

            /*TRAINING*/
            $q18="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'TRAINING' ELSE 'TRAINING' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'TRAIN') AND Dates='$txtEndChoix'";
            $r_q18=mysqli_query($connection, $q18);

            /*ZIPPER*/
            $q19="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'ZIPPER' ELSE 'ZIPPER' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'ZPR') AND Dates='$txtEndChoix'";
            $r_q19=mysqli_query($connection, $q19);

            /*total cdi*/
            $q20="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Total CDI' ELSE 'Total CDI' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'Total CDI') AND Dates='$txtEndChoix'";
            $r_q20=mysqli_query($connection, $q20);

            /*broderie*/
            $q21="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'BDRCDD' ELSE 'BDRCDD' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'BDRCDD') AND Dates='$txtEndChoix'";
            $r_q21=mysqli_query($connection, $q21);

            /*DRY PROCESS CDD*/
            $q22="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'DPRCDD' ELSE 'DPRCDD' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'DPRCDD') AND Dates='$txtEndChoix'";
            $r_q22=mysqli_query($connection, $q22);

            /*LAVERIE CDD*/
            $q23="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'LVGCDD' ELSE 'LVGCDD' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'LVGCDD') AND Dates='$txtEndChoix'";
            $r_q23=mysqli_query($connection, $q23);

            /*FNTCDD*/
            $q24="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'FNTCDD' ELSE 'FNTCDD' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'FNTCDD') AND Dates='$txtEndChoix'";
            $r_q24=mysqli_query($connection, $q24);

            /*FORMATION*/
            $q25="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates) 
            SELECT (CASE WHEN Code IS NOT NULL THEN  'FORMATION' ELSE 'FORMATION' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'FORMATION') AND Dates='$txtEndChoix'";
            $r_q25=mysqli_query($connection, $q25);



            /*Total CDD*/
            $q26="INSERT INTO t_pourcentage_absence(Code, EffJ_1, EffJ, Nb_pres, Nb_abs, P_abs, Conge, CM, AbsAuto, Perm, Com, Susp, RM, Recup, Hosp, Map, NS, SM, Dates)
            SELECT (CASE WHEN Code IS NOT NULL THEN  'Total CDD' ELSE 'Total CDD' END) AS Code, SUM(EffJ_1) AS EffJ_1, SUM(EffJ) AS EffJ, SUM(Nb_pres) AS Nb_pres,SUM(Nb_abs) AS Nb_abs, SUM(P_abs) AS P_abs, SUM(Conge) AS Conge, SUM(CM) AS CM,
            SUM(AbsAuto) AS AbsAuto, SUM(Perm) AS Perm, SUM(Com) AS Com, SUM(Susp) AS Susp, SUM(RM) AS RM, SUM(Recup) AS Recup, SUM(Hosp) AS Hosp, SUM(Map) AS Map, SUM(NS) AS NS, SUM(SM) AS SM, Dates
            FROM  `t_pourcentage_cdd_cdi` 
            WHERE (Code= 'Total CDD') AND Dates='$txtEndChoix'";
            $r_q26=mysqli_query($connection, $q26);
############################################################################# FIN REQUETE MISE EN FORME RESULTAT #######################################################

        /*end motif des employée*/
        if ($r_insert_p_abs && $r_absence_motif && $r_conge && $r_maternite && $r_repos_medical && $r_abs_auto && $r_permission && $r_suspendu && $r_recuperation && $r_comission && $r_hospitalise && $r_miseapied && $r_nightshift && $r_sansmotif && $r_pourcentage_motif && $r_cdi && $r_tCDI && $r_cdd &&  $r_tCDD && $r_adm && $r_compliance && $r_cleaners && $r_security && $r_store && $r_zipper && $r_preproduction && $r_pocket_setter && $r_embroidery && $r_cutting && $r_fusing && $r_sewing && $r_dry_process && $r_laundry && $r_finishing && $r_left_over && $r_recycling && $r_sewing_maintenance && $r_general_maintenance && $r_water_treatement && $r_qa && $r_cdi && $r_q1 && $r_q2 && $r_q3 && $r_q4 && $r_q5 && $r_q6 && $r_q7 && $r_q8 && $r_q9 && $r_q10 && $r_q11 && $r_q12 && $r_q13 && $r_q14 && $r_q15 && $r_q16 && $r_q17
            && $r_q18 && $r_q19 && $r_q20 && $r_q21 && $r_q22 && $r_q23 && $r_q24 && $r_q25 && $r_q26) {
            echo '<div class="alert alert-success" role="alert">The data '.$txtStartChoix.' and '.$txtEndChoix.' is inserted!</div>';
        }else{
            echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
        }

    }
################################################################ END SUMARY MONTH #################################################################################

?>
        <!-- absence motif -->
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h2 class="card-header">ENREGISTREMENT EFFECTIF JOUR-1 ET JOUR</h2>
                <div class="card-body">
                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_periodique.php" method="post">
                        <label>Debut : </label>
                        <input type="date" name="txtStartChoix">
                        <label>Fin :</label>
                        <input type="date" name="txtEndChoix">
                        <label>Insertion :</label>
                        <button class="btn btn-success" type="submit" name="btn_sumary_1">MOTIF</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <!-- fin absence motif -->
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
