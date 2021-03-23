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
############################################ heures supplementaires ####################################################################################
        /*HEURES JOURS NUIT*/
        if (isset($_POST['btn_jour_nuit'])) {
            $StartDate = $_POST['StartDate'];
########################################### LES HEURES CONGES #########################################################################################################
            $h_conge="INSERT INTO t_h_conge(UserId, Name, Fonction, DeptId, Code,Dates,H_conge)
                    SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_conge FROM t_motif WHERE Obs='conge' AND Dates='$StartDate'";
            $r_h_conge=mysqli_query($connection, $h_conge);

            $h_repos="INSERT INTO t_h_repos(UserId, Name, Fonction, DeptId, Code, Dates, H_repos)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_repos FROM t_motif WHERE Obs='repos' AND Dates='$StartDate'";
            $r_h_repos=mysqli_query($connection, $h_repos);

            $h_permission="INSERT INTO t_h_permission(UserId, Name, Fonction, DeptId, Code, Dates, H_permission)
                SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_permission FROM t_motif WHERE Obs='permission' AND Dates='$StartDate'";
            $r_h_permission=mysqli_query($connection, $h_permission);

            $h_autoabs="INSERT INTO t_h_autoabs(UserId, Name, Fonction, DeptId, Code, Dates,H_autoabs)
                        SELECT UserId, Name, Fonction, DeptId, Code,Dates, '08:00:00' AS H_autoabs FROM t_motif WHERE Obs='absence autorise' AND Dates='$StartDate'";
            $r_h_autoabs=mysqli_query($connection, $h_autoabs);

            $h_commission="INSERT INTO t_h_commission(UserId, Name, Fonction, DeptId, Code, Dates, H_commission)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_commission FROM t_motif WHERE Obs='comission' AND Dates='$StartDate'";
            $r_h_commission=mysqli_query($connection, $h_commission);

            $h_miseapied="INSERT INTO t_h_miseapied(UserId, Name, Fonction, DeptId, Code,Dates, H_miseapied)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_miseapied FROM t_motif WHERE Obs='miseapied' AND Dates='$StartDate'";
            $r_h_miseapied=mysqli_query($connection, $h_miseapied);

            $q_jours_conge="INSERT INTO t_jours_conge(UserId, Name, Fonction, DeptId, Code, Dates, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code,'$StartDate' AS Dates
            ,c.H_conge AS H_conge, r.H_repos AS H_repos, p.H_permission AS H_permission,
            abs.H_autoabs AS H_autoabs, com.H_commission AS H_commission, m.H_miseapied AS H_miseapied FROM t_dept_user t 
            LEFT JOIN t_h_conge c ON t.UserId=c.UserId AND c.Dates='$StartDate'
            LEFT JOIN t_h_repos r ON t.UserId=r.UserId AND r.Dates='$StartDate'
            LEFT JOIN t_h_permission p ON t.UserId=p.UserId AND p.Dates='$StartDate'
            LEFT JOIN t_h_autoabs abs ON t.UserId=abs.UserId AND abs.Dates='$StartDate'
            LEFT JOIN t_h_commission com ON t.UserId=com.UserId AND com.Dates='$StartDate'
            LEFT JOIN t_h_miseapied m ON t.UserId=m.UserId AND m.Dates='$StartDate'
            WHERE (c.H_conge IS NOT NULL OR r.H_repos IS NOT NULL OR p.H_permission IS NOT NULL OR abs.H_autoabs IS NOT NULL OR com.H_commission IS NOT NULL OR m.H_miseapied IS NOT NULL)
            GROUP BY t.UserId
            ";
            $r_q_jours_conge=mysqli_query($connection, $q_jours_conge);

########################################### FIN HEURES CONGES ############################################################################################################

############################################ HEURES CONGE JOURS NUIT DIMANCHE ############################################################################################
            $q_j_n="INSERT INTO t_jours_nuit(UserId, Name,Fonction, DeptId, Code, Dates, H_jours, H_nuit)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDate' AS Dates, j.H_travail AS H_jours, n.H_travail AS H_nuit
            FROM t_dept_user t
            LEFT JOIN t_h_travail j ON t.UserId = j.UserId AND j.Dates='$StartDate'
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND j.Dates=n.Dates
            WHERE j.Dates='$StartDate' AND (j.Commentaire IS NULL)
            GROUP BY t.UserId, t.Name";
            $r_q_j_n=mysqli_query($connection, $q_j_n);
            /*les travailleur nuits*/
            $q_j_nuit="INSERT INTO t_jours_nuit(UserId, Name,Fonction, DeptId, Code, Dates, H_nuit)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDate' AS Dates, n.H_travail AS H_nuit
            FROM t_dept_user t
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND t.DeptId=n.DeptId
            WHERE n.Dates='$StartDate' 
            GROUP BY t.UserId, t.Name";
            $r_q_j_nuit=mysqli_query($connection, $q_j_nuit);

            $q_j_n_conge="INSERT INTO t_jours_nuit_ferie_dimanche(UserId, Name,Fonction, DeptId, Code, Dates, H_jours, H_nuit, H_conge, H_repos, H_permission, H_autoabs,
            H_commission, H_miseapied)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDate' AS Dates, j.H_jours AS H_jours, j.H_nuit AS H_nuit,
            c.H_conge AS H_conge, c.H_repos AS H_repos, c.H_permission AS H_permission, c.H_autoabs AS H_autoabs, c.H_commission AS H_commission, c.H_miseapied AS H_miseapied
            FROM t_dept_user t
            LEFT JOIN t_jours_nuit j ON t.UserId=j.UserId AND j.Dates='$StartDate'
            LEFT JOIN t_jours_conge c ON t.UserId=c.UserId AND j.Dates=c.Dates
            WHERE j.Dates='$StartDate'
            GROUP BY  t.UserId, t.Name";
            $r_q_j_conge=mysqli_query($connection, $q_j_n_conge);

			
            if($r_h_conge && $r_h_repos && $r_h_permission && $r_h_autoabs && $r_h_commission && $r_h_miseapied && $r_q_jours_conge && $r_q_j_n && $r_q_j_nuit && $r_q_j_conge){
                    echo '<div class="alert alert-success" role="alert">The data of '.' '.$StartDate.' '.'is inserted!</div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
            }
        }
######################################### FIN CONGE JOURS NUIT ###########################################################################################################
        /*FIN HEURES JOURS NUIT*/
        /*HEURES FERIES NUIT*/
        if (isset($_POST['btn_ferie_nuit'])) {
            $StartDateFerie = $_POST['StartDateFerie'];
########################################### LES HEURES CONGES DIMANCHE #########################################################################################
            $h_conge="INSERT INTO t_h_conge(UserId, Name, Fonction, DeptId, Code,Dates,H_conge)
                    SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_conge FROM t_motif WHERE Obs='conge' AND Dates='$StartDateFerie '";
            $r_h_conge=mysqli_query($connection, $h_conge);

            $h_repos="INSERT INTO t_h_repos(UserId, Name, Fonction, DeptId, Code, Dates, H_repos)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_repos FROM t_motif WHERE Obs='repos' AND Dates='$StartDateFerie '";
            $r_h_repos=mysqli_query($connection, $h_repos);

            $h_permission="INSERT INTO t_h_permission(UserId, Name, Fonction, DeptId, Code, Dates, H_permission)
                SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_permission FROM t_motif WHERE Obs='permission' AND Dates='$StartDateFerie '";
            $r_h_permission=mysqli_query($connection, $h_permission);

            $h_autoabs="INSERT INTO t_h_autoabs(UserId, Name, Fonction, DeptId, Code, Dates,H_autoabs)
                        SELECT UserId, Name, Fonction, DeptId, Code,Dates, '08:00:00' AS H_autoabs FROM t_motif WHERE Obs='absence autorise' AND Dates='$StartDateFerie '";
            $r_h_autoabs=mysqli_query($connection, $h_autoabs);

            $h_commission="INSERT INTO t_h_commission(UserId, Name, Fonction, DeptId, Code, Dates, H_commission)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_commission FROM t_motif WHERE Obs='comission' AND Dates='$StartDateFerie '";
            $r_h_commission=mysqli_query($connection, $h_commission);

            $h_miseapied="INSERT INTO t_h_miseapied(UserId, Name, Fonction, DeptId, Code,Dates, H_miseapied)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_miseapied FROM t_motif WHERE Obs='miseapied' AND Dates='$StartDateFerie '";
            $r_h_miseapied=mysqli_query($connection, $h_miseapied);


            $q_jours_conge="INSERT INTO t_jours_conge(UserId, Name, Fonction, DeptId, Code, Dates, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateFerie' AS Dates
            ,c.H_conge AS H_conge, r.H_repos AS H_repos, p.H_permission AS H_permission,
            abs.H_autoabs AS H_autoabs, com.H_commission AS H_commission, m.H_miseapied AS H_miseapied FROM t_dept_user t 
            LEFT JOIN t_h_conge c ON t.UserId=c.UserId AND c.Dates='$StartDateFerie'
            LEFT JOIN t_h_repos r ON t.UserId=r.UserId AND r.Dates='$StartDateFerie'
            LEFT JOIN t_h_permission p ON t.UserId=p.UserId AND p.Dates='$StartDateFerie'
            LEFT JOIN t_h_autoabs abs ON t.UserId=abs.UserId AND abs.Dates='$StartDateFerie'
            LEFT JOIN t_h_commission com ON t.UserId=com.UserId AND com.Dates='$StartDateFerie'
            LEFT JOIN t_h_miseapied m ON t.UserId=m.UserId AND m.Dates='$StartDateFerie'
            WHERE (c.H_conge IS NOT NULL OR r.H_repos IS NOT NULL OR p.H_permission IS NOT NULL OR abs.H_autoabs IS NOT NULL OR com.H_commission IS NOT NULL OR m.H_miseapied IS NOT NULL)
            GROUP BY t.UserId";
            $r_q_jours_conge=mysqli_query($connection, $q_jours_conge);

########################################### FIN HEURES CONGES DIMANCHE #########################################################################################
############################################ HEURES CONGE JOURS NUIT DIMANCHE ############################################################################################
            $q_j_n="INSERT INTO t_jours_nuit(UserId, Name,Fonction, DeptId, Code, Dates, H_jours, H_nuit, H_ferie)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, j.Dates AS Dates, j.H_travail AS H_jours, n.H_travail AS H_nuit
            , j.H_travail AS H_ferie
            FROM t_dept_user t
            LEFT JOIN t_h_travail j ON t.UserId = j.UserId AND j.Dates='$StartDateFerie'
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND j.Dates=n.Dates
            WHERE  j.Dates='$StartDateFerie ' GROUP BY t.UserId, t.Name";
            $r_q_j_n=mysqli_query($connection, $q_j_n);

            /*les heures de travail nuits*/
            $q_j_nuit="INSERT INTO t_jours_nuit(UserId, Name,Fonction, DeptId, Code, Dates, H_nuit)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateFerie' AS Dates, n.H_travail AS H_nuit
            FROM t_dept_user t
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND t.DeptId=n.DeptId
            WHERE n.Dates='$StartDateFerie' 
            GROUP BY t.UserId, t.Name";
            $r_q_j_nuit=mysqli_query($connection, $q_j_nuit);

            $q_j_n_conge="INSERT INTO t_jours_nuit_ferie_dimanche(UserId, Name,Fonction, DeptId, Code, Dates, H_jours, H_nuit, H_ferie, H_conge, H_repos, H_permission, H_autoabs,
            H_commission, H_miseapied)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateFerie' AS Dates, j.H_jours AS H_jours, j.H_nuit AS H_nuit, j.H_dimanche AS H_ferie,
            c.H_conge AS H_conge, c.H_repos AS H_repos, c.H_permission AS H_permission, c.H_autoabs AS H_autoabs, c.H_commission AS H_commission, c.H_miseapied AS H_miseapied
            FROM t_dept_user t
            LEFT JOIN t_jours_nuit j ON t.UserId=j.UserId AND j.Dates='$StartDateFerie'
            LEFT JOIN t_jours_conge c ON t.UserId=c.UserId AND j.Dates=c.Dates
            WHERE j.Dates='$StartDateFerie'
            GROUP BY  t.UserId, t.Name";
            $r_q_j_conge=mysqli_query($connection, $q_j_n_conge);

            if($r_h_conge && $r_h_repos && $r_h_permission && $r_h_autoabs && $r_h_commission && $r_h_miseapied && $r_q_jours_conge &&  $r_q_j_nuit && $r_q_j_n && $r_q_j_conge){
                    echo '<div class="alert alert-success" role="alert">The data of '.' '.$StartDateFerie.' '.'is inserted!</div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
            }
        }
        /*FIN HEURES FERIES NUIT*/

        /*HEURES DIMANCHE NUIT*/
        if (isset($_POST['btn_dimanche_nuit'])) {
            $StartDateDimanche = $_POST['StartDateDimanche'];
########################################### LES HEURES CONGES DIMANCHE #########################################################################################
            $h_conge="INSERT INTO t_h_conge(UserId, Name, Fonction, DeptId, Code,Dates,H_conge)
                    SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_conge FROM t_motif WHERE Obs='conge' AND Dates='$StartDateDimanche '";
            $r_h_conge=mysqli_query($connection, $h_conge);

            $h_repos="INSERT INTO t_h_repos(UserId, Name, Fonction, DeptId, Code, Dates, H_repos)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_repos FROM t_motif WHERE Obs='repos' AND Dates='$StartDateDimanche '";
            $r_h_repos=mysqli_query($connection, $h_repos);

            $h_permission="INSERT INTO t_h_permission(UserId, Name, Fonction, DeptId, Code, Dates, H_permission)
                SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_permission FROM t_motif WHERE Obs='permission' AND Dates='$StartDateDimanche '";
            $r_h_permission=mysqli_query($connection, $h_permission);

            $h_autoabs="INSERT INTO t_h_autoabs(UserId, Name, Fonction, DeptId, Code, Dates,H_autoabs)
                        SELECT UserId, Name, Fonction, DeptId, Code,Dates, '08:00:00' AS H_autoabs FROM t_motif WHERE Obs='absence autorise' AND Dates='$StartDateDimanche '";
            $r_h_autoabs=mysqli_query($connection, $h_autoabs);

            $h_commission="INSERT INTO t_h_commission(UserId, Name, Fonction, DeptId, Code, Dates, H_commission)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_commission FROM t_motif WHERE Obs='comission' AND Dates='$StartDateDimanche '";
            $r_h_commission=mysqli_query($connection, $h_commission);

            $h_miseapied="INSERT INTO t_h_miseapied(UserId, Name, Fonction, DeptId, Code,Dates, H_miseapied)
                        SELECT UserId, Name, Fonction, DeptId, Code, Dates, '08:00:00' AS H_miseapied FROM t_motif WHERE Obs='miseapied' AND Dates='$StartDateDimanche '";
            $r_h_miseapied=mysqli_query($connection, $h_miseapied);


            $q_jours_conge="INSERT INTO t_jours_conge(UserId, Name, Fonction, DeptId, Code, Dates, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateDimanche' AS Dates
            ,c.H_conge AS H_conge, r.H_repos AS H_repos, p.H_permission AS H_permission,
            abs.H_autoabs AS H_autoabs, com.H_commission AS H_commission, m.H_miseapied AS H_miseapied FROM t_dept_user t 
            LEFT JOIN t_h_conge c ON t.UserId=c.UserId AND c.Dates='$StartDateDimanche'
            LEFT JOIN t_h_repos r ON t.UserId=r.UserId AND r.Dates='$StartDateDimanche'
            LEFT JOIN t_h_permission p ON t.UserId=p.UserId AND p.Dates='$StartDateDimanche'
            LEFT JOIN t_h_autoabs abs ON t.UserId=abs.UserId AND abs.Dates='$StartDateDimanche'
            LEFT JOIN t_h_commission com ON t.UserId=com.UserId AND com.Dates='$StartDateDimanche'
            LEFT JOIN t_h_miseapied m ON t.UserId=m.UserId AND m.Dates='$StartDateDimanche'
            WHERE (c.H_conge IS NOT NULL OR r.H_repos IS NOT NULL OR p.H_permission IS NOT NULL OR abs.H_autoabs IS NOT NULL OR com.H_commission IS NOT NULL OR m.H_miseapied IS NOT NULL)
            GROUP BY t.UserId";
            $r_q_jours_conge=mysqli_query($connection, $q_jours_conge);

########################################### FIN HEURES CONGES DIMANCHE #########################################################################################
############################################ HEURES CONGE JOURS NUIT DIMANCHE ############################################################################################
            $q_j_n="INSERT INTO t_jours_nuit(UserId, Name,Fonction, DeptId, Code, Dates, H_jours, H_nuit, H_dimanche)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateDimanche' AS Dates, j.H_travail AS H_jours, n.H_travail AS H_nuit
            , j.H_travail AS H_dimanche
            FROM t_dept_user t
            LEFT JOIN t_h_travail j ON t.UserId = j.UserId AND j.Dates='$StartDateDimanche'
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND j.Dates=n.Dates
            WHERE j.Dates='$StartDateDimanche'
            GROUP BY t.UserId, t.Name";
            $r_q_j_n=mysqli_query($connection, $q_j_n);

            /*les heures de travail nuits*/
            $q_j_nuit="INSERT INTO t_jours_nuit(UserId, Name,Fonction, DeptId, Code, Dates, H_nuit)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateDimanche' AS Dates, n.H_travail AS H_nuit
            FROM t_dept_user t
            LEFT JOIN t_h_nuit n ON t.UserId=n.UserId AND t.DeptId=n.DeptId
            WHERE n.Dates='$StartDateDimanche' 
            GROUP BY t.UserId, t.Name";
            $r_q_j_nuit=mysqli_query($connection, $q_j_nuit);
            
            $q_j_n_conge="INSERT INTO t_jours_nuit_ferie_dimanche(UserId, Name,Fonction, DeptId, Code, Dates, H_jours, H_nuit, H_dimanche, H_conge, H_repos, H_permission, H_autoabs,
            H_commission, H_miseapied)
            SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, '$StartDateDimanche' AS Dates, j.H_jours AS H_jours, j.H_nuit AS H_nuit, j.H_dimanche AS H_dimanche,
            c.H_conge AS H_conge, c.H_repos AS H_repos, c.H_permission AS H_permission, c.H_autoabs AS H_autoabs, c.H_commission AS H_commission, c.H_miseapied AS H_miseapied
            FROM t_dept_user t
            LEFT JOIN t_jours_nuit j ON t.UserId=j.UserId AND j.Dates='$StartDateDimanche'
            LEFT JOIN t_jours_conge c ON t.UserId=c.UserId AND j.Dates=c.Dates
            WHERE j.Dates='$StartDateDimanche'
            GROUP BY  t.UserId, t.Name";
            $r_q_j_conge=mysqli_query($connection, $q_j_n_conge);

            if($r_h_conge && $r_h_repos && $r_h_permission && $r_h_autoabs && $r_h_commission && $r_h_miseapied && $r_q_jours_conge && $r_q_j_n && $r_q_j_conge){
                    echo '<div class="alert alert-success" role="alert">The data of '.' '.$StartDateDimanche.' '.'is inserted!</div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
            }
        }
        /*FIN HEURES DIMANCHE NUIT*/
############################################ fin heures supplementaires ################################################################################
?>
	<div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">COLLECTION HEURES TRAVAIL JOURS NUIT CONGE</h5>
                <div class="card-body">
                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                        <label>Date debut jour: </label>
                        <input type="date" name="StartDate">
                        <!-- <label>Date fin nuit:</label> <input type="date" name="DateEnd"> -->
                        <label>Insertion: </label>
                        <button class="btn btn-primary" type="submit" name="btn_jour_nuit">JOUR</button>
                        <label>Date debut ferie: </label>
                        <input type="date" name="StartDateFerie">
                        <!-- <label>Date fin nuit:</label> <input type="date" name="DateEnd"> -->
                        <label>Insertion: </label>
                        <button class="btn btn-primary" type="submit" name="btn_ferie_nuit">FERIE</button>
                        <label>Date debut dimanche: </label>
                        <input type="date" name="StartDateDimanche">
                        <!-- <label>Date fin nuit:</label> <input type="date" name="DateEnd"> -->
                        <label>Insertion: </label>
                        <button class="btn btn-primary" type="submit" name="btn_dimanche_nuit">DIMANCHE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php  

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'ebp'); 
############################################################## HEURES SUPPLEMENTAIRES SEMAINE ################################################################################
if (isset($_POST['btn_semaine_supp'])) {
    $StartDateSemaine = $_POST['StartDateSemaine'];
    $EndDateSemaine = $_POST['EndDateSemaine'];
    $q_semaine="
    INSERT INTO t_h_supp(UserId, Name, Fonction,DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_jours, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied, H_nuit, H_ferie, H_dimanche)
    SELECT DISTINCT UserId, Name, Fonction, DeptId, Code, MIN(Dates) AS Dates_debut, MAX(Dates) AS Dates_fin, COUNT(Dates) AS Nb_jours, WEEK(MIN(Dates)) AS Num_semaine, SEC_TO_TIME(SUM(TIME_TO_SEC(H_jours))) AS H_jours, SEC_TO_TIME(SUM(TIME_TO_SEC(H_conge))) AS H_conge, 
    SEC_TO_TIME(SUM(TIME_TO_SEC(H_repos))) AS H_repos,
    SEC_TO_TIME(SUM(TIME_TO_SEC(H_permission))) AS H_permission, 
    SEC_TO_TIME(SUM(TIME_TO_SEC(H_autoabs))) AS H_autoabs, SEC_TO_TIME(SUM(TIME_TO_SEC(H_commission))) AS H_commission, 
    SEC_TO_TIME(SUM(TIME_TO_SEC(H_miseapied))) AS H_miseapied,
    SEC_TO_TIME(SUM(TIME_TO_SEC(H_nuit))) AS H_nuit,
    SEC_TO_TIME(SUM(TIME_TO_SEC(H_ferie))) AS H_ferie, SEC_TO_TIME(SUM(TIME_TO_SEC(H_dimanche))) AS H_dimanche 
    FROM t_jours_nuit_ferie_dimanche
    WHERE (Dates BETWEEN '$StartDateSemaine' AND '$EndDateSemaine')
    GROUP BY UserId, Name";
    $r_q_semaine=mysqli_query($connection, $q_semaine);

    /*SELECT `UserId`, `Name`, `Fonction`, `DeptId`, `Code`, MIN(`Dates`) AS Dates_debut, MAX(`Dates`) AS Dates_fin, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_jours`))) AS H_jours, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_nuit`))) AS H_nuit, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_ferie`))) AS H_ferie, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_dimanche`))) AS H_dimanche, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_conge`))) AS H_conge, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_repos`))) AS H_repos, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_permission`))) AS H_permission, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_autoabs`))) AS H_autoabs, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_commission`))) AS H_commission, SEC_TO_TIME(SUM(TIME_TO_SEC(`H_miseapied`))) AS H_miseapied FROM `t_jours_nuit_ferie_dimanche` WHERE (Dates BETWEEN '2020-11-23' AND '2020-11-29') 
GROUP BY UserId*/
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

   /* $qu16="UPDATE t_h_supp SET Nb_jours=(CASE WHEN H_dimanche IS NULL THEN Nb_jours+1 ELSE Nb_jours+2 END)";
    $r_qu16 = mysqli_query($connection, $qu16);*/
                        /**/
    if($r_q_semaine && $r_qu1 && $r_qu2 && $r_qu3 && $r_qu4 && $r_qu5 && $r_qu6 && $r_qu7 && $r_qu8 && $r_qu9 && $r_qu10  && $r_qu11 && $r_qu12 && $r_qu13 && $r_qu14 && $r_qu15){
            echo '<div class="alert alert-success" role="alert">The data '.' '.$StartDateSemaine.' '.' is inserted!</div>';
        }else{
            echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
    }
}

############################################################## FIN HEURES SUPPLEMENTAIRES SEMAINE ################################################################################
?>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">HEURES SUPPLEMENTAIRES SEMAINE</h5>
                <div class="card-body">
                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                        <label>Date debut : </label>
                        <input type="date" name="StartDateSemaine">
                        <label>Date fin :</label> 
                        <input type="date" name="EndDateSemaine">
                        <label>Insertion: </label>
                        <button class="btn btn-primary" type="submit" name="btn_semaine_supp">SEMAINE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<!-- ###########################################SUPPRESION DATA SEMAINE############################################################################## -->
    <?php  
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ebp'); 
    if (isset($_POST['suppr_h_semaine'])) {
        $SupprDebut=$_POST['SupprDebut'];
        
        $del_h_conge="DELETE FROM t_h_conge WHERE Dates='$SupprDebut'";
        $r_h_conge=mysqli_query($connection, $del_h_conge);
        
        $del_h_repos="DELETE FROM t_h_repos WHERE Dates='$SupprDebut'";
        $r_h_repos=mysqli_query($connection, $del_h_repos);
        
        $del_h_permission="DELETE FROM t_h_permission WHERE Dates='$SupprDebut'";
        $r_h_permission=mysqli_query($connection, $del_h_permission);
        
        $del_h_autoabs="DELETE FROM t_h_autoabs WHERE Dates='$SupprDebut'";
        $r_h_autoabs=mysqli_query($connection, $del_h_autoabs);
        
        $del_h_commission="DELETE FROM t_h_commission WHERE Dates='$SupprDebut'";
        $r_h_commission=mysqli_query($connection, $del_h_commission);
        
        $del_h_miseapied="DELETE FROM t_h_miseapied WHERE Dates='$SupprDebut'";
        $r_h_miseapied=mysqli_query($connection, $del_h_miseapied);
        
        $del_jours_conge="DELETE FROM t_jours_conge WHERE Dates='$SupprDebut'";
        $r_jours_conge=mysqli_query($connection, $del_jours_conge);
        
        $del_jours_nuit="DELETE FROM t_jours_nuit WHERE Dates='$SupprDebut'";
        $r_jours_nuit=mysqli_query($connection, $del_jours_nuit);
        
        $del_jours_nuit_ferie_dimanche="DELETE FROM t_jours_nuit_ferie_dimanche WHERE Dates='$SupprDebut'";
        $r_jours_nuit_ferie_dimanche=mysqli_query($connection, $del_jours_nuit_ferie_dimanche);

        $del_h_supp="DELETE FROM t_h_supp WHERE Dates_debut='$SupprDebut'";
        $r_h_supp=mysqli_query($connection, $del_h_supp);
        if ($r_h_conge && $r_h_repos && $r_h_permission && $r_h_autoabs && $r_h_commission && $r_h_miseapied && $r_jours_conge && $r_jours_nuit && $r_jours_nuit_ferie_dimanche && $r_h_supp) {
            echo '<div class="alert alert-success" role="alert">The data '.' '.$SupprDebut.' '.' is inserted!</div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
        }
    }
    ?>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">SUPPRESSIOIN DES DONNEES SEMAINE</h5>
                <div class="card-body">
                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data_semaine.php" method="post">
                        <label>DATE DU JOUR : </label>
                        <input type="date" name="SupprDebut">
                        <label>SUPPRESSION: </label>
                        <button class="btn btn-danger" type="submit" name="suppr_h_semaine">SUPPRIMER</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- ###########################################FIN SUPPRESION DATA SEMAINE############################################################################## -->
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