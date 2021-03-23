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
        <!-- left sidebar  -->
        <!-- ============================================================== -->
        <?php include('../config/template/leftbar_data.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <!-- <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Absent </h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                            </div>
                        </div>
                    </div> -->
                    <!-- INSERTION JOURS -->
                    <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        ################  RETARD JOURS #####################################################################
                        if (isset($_POST['insert_btn_1'])) {
                                $insert_l_ret="
                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE ((Dates=DATE(NOW())) AND (Code != 'ADM')AND (Code != 'GNR') AND (H_E BETWEEN  '07:05:00' AND  '10:00:00'))
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE ((Dates=DATE(NOW( ) )) AND ( Code ='ADM' ) AND (H_E BETWEEN  '08:05:00' AND  '10:00:00'))
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE ((Dates=DATE(NOW( ) )) AND (Code ='GNR') AND (H_E BETWEEN  '06:05:00' AND  '10:00:00'))
                                ";
                                $r_insert_l_ret = mysqli_query($connection, $insert_l_ret);
                                if($insert_l_ret){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
                                }
                        }
                        ################  UPDATE RETARD JOURS ##############################################################
                        if (isset($_POST['update_btn_1'])) {
                            $q_update=" UPDATE t_retard_jours  
                                        SET P_E=(
                                        CASE
                                           WHEN Code='GNR' THEN '06:00:00'
                                           WHEN Code='ADM' THEN '08:00:00'
                                           ELSE '07:00:00'
                                        END),
                                        H_ret=abs(TIMEDIFF(H_E, P_E))  WHERE Dates=Date(now())
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '<div class="alert alert-success" role="alert">The data is updated!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not updated!</div>';
                            }
                        }
                        ################  POURCENTAGE JOURS ################################################################
                        if (isset($_POST['insert_btn_2'])) {
                                $insert_p_ret = "
                                        INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                        SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                        FROM t_retard_jours WHERE Dates=Date(now()) GROUP BY DeptId
                                        ";
                                $r_insert_p_ret = mysqli_query($connection, $insert_p_ret);
                                if($r_insert_p_ret){
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is not inserted!</div>';
                                }
                        }
                        ################  ABSENCE JOURS ####################################################################
                        if (isset($_POST['insert_btn_3'])) {
                                $insert_l_abs = "
                                            INSERT INTO t_absence_jours(UserId, Name, DeptId, Code,Effectif, Dates)
                                            SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, DATE( NOW( ) ) AS Dates
                                            FROM t_dept_user WHERE UserId NOT IN (SELECT DISTINCT UserId FROM t_present_jours WHERE Dates = DATE( NOW( )))
                                            ";
                                $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                                if($r_insert_l_abs){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                                }
                        }
                        ################  POURCENTAGE ABSENCE JOURS ########################################################
                        if (isset($_POST['insert_btn_4'])) {
                            $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs) 
                                    SELECT DISTINCT DeptId as DeptId, DeptCode as Code, DeptEff as Effectif, Dates, COUNT( UserId ) as Nb_pres , (
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) as Nb_abs, ((
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) *100 / DeptEff) as p_abs
                                    FROM  `t_present_jours` WHERE Dates =  Date(now()) GROUP BY DeptId 
                                ";
                                $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
                                if($r_insert_p_abs){
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is not inserted!</div>';
                                }
                        }
                    ?> 
                    <?php
                    	$connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        ################  INSERTION HEURES ENTREE SORTIE EMPLOYEE JOURS-1 ###################################
                        if (isset($_POST['insert_btn_5'])) {
                             $q="INSERT INTO t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_entree, P_sortie, H_travail)
	                            SELECT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie,
	                            (CASE
	                               WHEN Code='ADM' THEN '08:00:00'
	                               ELSE '06:30:00'
	                            END) AS P_entree,
	                            (CASE
	                               WHEN Code='ADM' THEN '16:00:00'
	                               ELSE '17:00:00'
	                            END) AS P_sortie,
	                            H_travail
	                            FROM t_h_e_s WHERE Dates=date_add(curdate(), interval -1 day)
                                ";
                                $r_q = mysqli_query($connection, $q);
                                if($r_q){
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is not inserted!</div>';
                                }
                        }
                        ################  UPDATE HEURES ENTREE SORTIE JOURS-1 ###############################################
                        if (isset($_POST['update_btn_2'])) {
                            $q_update=" UPDATE t_h_travail 
                                        SET H_Retard=(timediff(H_entree, P_entree))
                                        WHERE SIGN(TIMEDIFF(H_entree, P_entree))>0
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '<div class="alert alert-success" role="alert">The data is updated!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not updated!</div>';
                            }
                        }
                        ################  UPDATE PLAGE PAUSE JOURS-1 #########################################################
                        if (isset($_POST['update_btn_3'])) {
                            $q_update=" UPDATE t_h_travail 
                                        SET Pause=(
                                        CASE
                                            WHEN H_entree!=H_sortie THEN '00:45:00'
                                        END)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '<div class="alert alert-success" role="alert">The data is updated!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not updated!</div>';
                            }
                        }
                        ################  UPDATE HEURES TRAVAIL JOURS-1 ######################################################
                        if (isset($_POST['update_btn_4'])) {
                            $q_update=" UPDATE t_h_travail SET H_travail=TIMEDIFF(H_travail, Pause)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '<div class="alert alert-success" role="alert">The data is updated!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not updated!</div>';
                            }
                        }

                       ################  INSERTION MOTIF JOURS ###############################################################
                        if (isset($_POST['insert_btn_6'])) {
                            $absence_motif="INSERT INTO t_motif(UserId, Name, DeptId, Code, Effectif, Dates, Obs, Dates_fin)
                                            SELECT * FROM t_absence_jours WHERE ((Obs IS NOT NULL) AND Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')";
                                $r_absence_motif = mysqli_query($connection, $absence_motif);
                                if($r_absence_motif){
                                    echo '
                                    <div class="alert alert-success" role="alert">Absence motif is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is not inserted!</div>';
                                }
                        }
                        ################  INSERTION CONGE JOURS ##############################################################
                        if (isset($_POST['insert_btn_7'])) {
                            $q = "INSERT INTO conge(DeptId, Code, Dates, C)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS C FROM  `t_motif` WHERE Obs =  'conge' AND Dates = DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">conge is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">conge is not inserted!</div>';
                            }
                        }
                        ################  INSERTION CONGE DE MATERNITE JOURS #################################################
                        if (isset($_POST['insert_btn_8'])) {
                            $q = "INSERT INTO conge_mat(DeptId, Code, Dates, CM)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS CM FROM  `t_motif`  WHERE Obs =  'conge maternite' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">conge maternite is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">conge maternite is not inserted!</div>';
                            }
                        }
                        ################  INSERTION REPOS MEDICAL JOURS ######################################################
                        if (isset($_POST['insert_btn_9'])) {
                            $q = "INSERT INTO rep_med(DeptId, Code, Dates, RM)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS RM FROM  `t_motif` WHERE Obs =  'repos medical' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">repos medical is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">repos medical is not inserted!</div>';
                            }
                        }
                        ################  INSERTION ABSENCE AUTORISE JOURS ###################################################
                        if (isset($_POST['insert_btn_10'])) {
                            $q = "INSERT INTO abs_auto(DeptId, Code, Dates, AA)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS AA FROM  `t_motif` WHERE Obs =  'absence autorise' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">absence autorise is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">absence autorise is not inserted!</div>';
                            }
                        }
                        ################  INSERTION PERMISSION JOURS #########################################################
                        if (isset($_POST['insert_btn_11'])) {
                            $q = "INSERT INTO permission(DeptId, Code, Dates, P)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS P FROM  `t_motif` WHERE Obs =  'permission' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">permission is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">permission is not inserted!</div>';
                            }
                        }
                        ################  INSERTION PERMISSION JOURS #########################################################
                        if (isset($_POST['insert_btn_12'])) {
                            $q = "INSERT INTO suspendu(DeptId, Code, Dates, Susp)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Susp FROM  `t_motif`  WHERE Obs='suspendu' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">suspendu is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">suspendu is not inserted!</div>';
                            }
                        }
                        ################  INSERTION RECUPERATION JOURS #######################################################
                        if (isset($_POST['insert_btn_13'])) {
                            $q = "INSERT INTO recup(DeptId, Code, Dates, Recup)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Recup FROM  `t_motif` WHERE Obs =  'recuperation' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">recuperation is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">Pourcentage is not inserted!</div>';
                            }
                        }
                        ################  INSERTION COMISSION JOURS ##########################################################
                        if (isset($_POST['insert_btn_14'])) {
                            $q = "INSERT INTO comission(DeptId, Code, Dates, Com)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Com FROM  `t_motif` WHERE Obs =  'comission' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">comission is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">comission is not inserted!</div>';
                            }
                        }
                        ################  INSERTION HOSPITALISE JOURS ########################################################
                        if (isset($_POST['insert_btn_15'])) {
                            $q = "INSERT INTO hospitalise(DeptId, Code, Dates, HP)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS HP FROM  `t_motif`  WHERE Obs =  'hospitalise' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">hospitalise is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">hospitalise is not inserted!</div>';
                            }
                        }
                        ################  INSERTION MISE A PIED JOURS ########################################################
                        if (isset($_POST['insert_btn_16'])) {
                            $q = "INSERT INTO miseapied(DeptId, Code, Dates, MAP)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS MAP FROM  `t_motif`  WHERE Obs='miseapied' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates
                                ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">mise à pied is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">mise à pied  is not inserted!</div>';
                            }
                        }
                        ################  INSERTION NIGHT SHIFT JOURS ########################################################
                        if (isset($_POST['insert_btn_17'])) {
                            $q = "INSERT INTO nightshift(DeptId, Code, Dates, NF) 
                                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(UserId) as NF FROM t_absence_jours WHERE Obs='night shift' AND Dates=DATE(NOW()) GROUP BY DeptId
                                ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">night shift is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">night shift  is not inserted!</div>';
                            }
                        }
                        ################  INSERTION SANS MOTIF JOURS #########################################################
                        if (isset($_POST['insert_btn_18'])) {
                            $q = "INSERT INTO sans_motif(DeptId, Code, Dates, SM) 
                                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(UserId) as SM FROM t_absence_jours WHERE Obs IS NULL AND Dates=DATE(NOW()) GROUP BY DeptId
                                ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">mise à pied is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">mise à pied  is not inserted!</div>';
                            }
                        }
                        ################  INSERTION POURCENTAGE  JOURS ######################################################
                        if (isset($_POST['insert_btn_19'])) {
                            $q ="
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
                            WHERE A.Dates=DATE( NOW( ) ) AND A.Code!='EXP' AND A.Code!='GNBR'
                            GROUP BY A.DeptId
                            ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '<div class="alert alert-success" role="alert">pourcentage is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">pourcentage is not inserted!</div>';
                            }
                        }
                    ?>  
                    <!-- END INSERTION JOURS -->
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <!-- <div class="row"> -->
                    <!-- ============================================================== -->
                    <!-- begin  pagebody  -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- begin collectioin des données jours  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTIOIN DES DONNÉES JOURS</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_1">RETARD</button>
                                                <button class="btn btn-success" type="submit" name="update_btn_1">UPDATE</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_2">%RETARD</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_3">ABSENT</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_4">%ABSENT</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- ============================================================== -->
	                    <!-- end collectioin des données jours  -->
	                    <!-- ============================================================== -->
                        <!-- heures travail -->
                        <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTION DES HEURES</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_5">ENTREE SORTIE</button>
                                                <button class="btn btn-success" type="submit" name="update_btn_3">UPDATE</button>
                                                <button class="btn btn-primary" type="submit" name="update_btn_4">PLAGE</button>
                                                <button class="btn btn-success" type="submit" name="update_btn_2">UPDATE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- Fin heures travail -->
                        <!-- absence motif -->
                        <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">ABSENCE MOTIF</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_6">MOTIF</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_7">CONGE</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_8">MATER</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_9">REP MED</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_10">ABS AUTO</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_11">PERM</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_12">SUSP</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_13">RECUP</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_14">COM</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_15">HOSP</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_16">MAP</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_17">NF</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_18">SM</button>
                                                <button class="btn btn-success" type="submit" name="insert_btn_19">POURCENTAGE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- fin absence motif -->
                    <!-- INSERTION JOURS -1 OU DIMANCHE -->
                        <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        ################  INSERTION RETARD JOURS-1 ##############################################
                        if (isset($_POST['insert_btn_20'])) {
                                $insert_l_ret=" INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
				                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours`
				                                WHERE ((Dates=date_add(curdate(), interval -1 day)) AND (Code!='ADM') AND (Code!='GNR') AND (H_E between '07:05:00' and '10:00:00'))
				                                UNION DISTINCT
				                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
				                                WHERE ((Dates=date_add(curdate(), interval -1 day)) AND (Code='ADM') AND (H_E between '08:05:00' and '10:00:00'))
				                                UNION DISTINCT
				                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
				                                WHERE ((Dates=date_add(curdate(), interval -1 day)) AND (Code='GNR') AND (H_E between '06:05:00' and '10:00:00'))
                                ";
                                $r_insert_l_ret = mysqli_query($connection, $insert_l_ret);
                                if($insert_l_ret){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
                                }
                        }
                        ################  UPDATE RETARD JOURS-1 #################################################
                        if (isset($_POST['update_btn_5'])) {
                            $q_update=" UPDATE t_retard_jours  
                                        SET P_E=(
                                        CASE
                                           WHEN Code='GNR' THEN '06:00:00'
                                           WHEN Code='ADM' THEN '08:00:00'
                                           ELSE '07:00:00'
                                        END),
                                        H_ret=abs(TIMEDIFF(H_E, P_E))  
                                        WHERE Dates=date_add(curdate(), interval -1 day)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
                            }
                        }
                        ################  INSERTION POURCENTAGE RETARD JOURS-1 ##################################
                        if (isset($_POST['insert_btn_21'])) {
                                $insert_p_ret = "
                                        INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                        SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                        FROM t_retard_jours WHERE Dates=date_add(curdate(), interval -1 day) GROUP BY DeptId
                                        ";
                                $r_insert_p_ret = mysqli_query($connection, $insert_p_ret);
                                if($r_insert_p_ret){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
                                }
                        }
                        ################  INSERTION ABSENCE JOURS-1 #############################################
                        if (isset($_POST['insert_btn_22'])) {
                                $insert_l_abs ="INSERT INTO t_absence_jours(UserId, Name, DeptId, Code,Effectif, Dates)
                                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, date_add(curdate(), interval -1 day) AS Dates
                                                FROM t_dept_user
                                                WHERE UserId NOT IN (
                                                SELECT DISTINCT UserId
                                                FROM t_present_jours
                                                WHERE Dates=date_add(curdate(), interval -1 day))
                                            ";
                                $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                                if($r_insert_l_abs){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
                                }
                        }
                        ################  INSERTION POURCENTAGE ABSENCE JOURS ###################################
                        if (isset($_POST['insert_btn_23'])) {
                            $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs) 
                                    SELECT DISTINCT DeptId as DeptId, DeptCode as Code, DeptEff as Effectif, Dates, COUNT( UserId ) as Nb_pres , (
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) as Nb_abs, ((
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) *100 / DeptEff) as p_abs
                                    FROM  `t_present_jours` 
                                    WHERE Dates =  date_add(curdate(), interval -1 day)
                                    GROUP BY DeptId 
                                ";
                                $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
                                if($r_insert_p_abs){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not inserted!</div>';
                                }
                        }
                    ?>
                    <!-- END INSERTION JOURS -1 OU DIMANCHE  -->
                        <!-- ============================================================== -->
	                    <!-- begin collectioin des données jours -1 -->
	                    <!-- ============================================================== -->
                        <div class="row">		
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTIOIN DES DONNÉES DIMANCHE</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                        <button class="btn btn-info" type="submit" name="insert_btn_20">RETARD J-1</button>
                                        <button class="btn btn-success" type="submit" name="update_btn_5">UPDATE J-1</button>
                                        <button class="btn btn-info" type="submit" name="insert_btn_21">%RETARD J-1</button>
                                        <button class="btn btn-info" type="submit" name="insert_btn_22">ABSENCE J-1</button>
                                        <button class="btn btn-info" type="submit" name="insert_btn_23">%ABSENCE J-1</button>
                                    </form>
                                </div>
                            </div>
                        </div></div>
                        <!-- ============================================================== -->
	                    <!-- end collectioin des données jours -1 -->
	                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- end pagebody  -->
                    <!-- ============================================================== -->
                       <!-- </div> -->
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../config/template/footer.php'); ?>
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