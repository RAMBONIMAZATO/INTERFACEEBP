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
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <!-- <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce"> -->
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
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
                        #######################################################################################################
                        ############## INSERTION MOTIF ########################################################################
                        if (isset($_POST['btn_motif'])) {
                            /*requete absence motif*/
                            $absence_motif="
                            INSERT INTO t_motif(UserId, Name, DeptId, Code, Effectif, Dates, Obs, Dates_fin)
                            SELECT  DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, Obs, Dates_fin 
                            FROM t_absence_jours WHERE ((Obs IS NOT NULL) AND Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')
                            GROUP BY UserId";
                            $r_absence_motif = mysqli_query($connection, $absence_motif);
                            /*requete conge*/
                            $conge = "INSERT INTO conge(DeptId, Code, Dates, C)
                                  SELECT DeptId, Code, Dates, COUNT(DISTINCT UserId ) AS C FROM  `t_motif` WHERE Obs =  'conge' AND Dates = DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_conge = mysqli_query($connection, $conge);
                            /*requete conge de maternite*/
                            $maternite = "INSERT INTO conge_mat(DeptId, Code, Dates, CM)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS CM FROM  `t_motif`  WHERE Obs =  'conge maternite' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_maternite = mysqli_query($connection, $maternite);
                            /*requete repos medical*/
                            $repos_medical = "INSERT INTO rep_med(DeptId, Code, Dates, RM)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS RM FROM  `t_motif` WHERE Obs =  'repos medical' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_repos_medical = mysqli_query($connection, $repos_medical);
                            /*requete absence autorise*/
                            $abs_auto = "INSERT INTO abs_auto(DeptId, Code, Dates, AA)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS AA FROM  `t_motif` WHERE Obs =  'absence autorise' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_abs_auto = mysqli_query($connection, $abs_auto);
                            /*requete permission*/
                            $permission = "INSERT INTO permission(DeptId, Code, Dates, P)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS P FROM  `t_motif` WHERE Obs =  'permission' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_permission = mysqli_query($connection, $permission);
                            /*requete suspendu*/
                            $suspendu = "INSERT INTO suspendu(DeptId, Code, Dates, Susp)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Susp FROM  `t_motif`  WHERE Obs='suspendu' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_suspendu = mysqli_query($connection, $suspendu);
                            /*requete recuperation*/
                            $recuperation = "INSERT INTO recup(DeptId, Code, Dates, Recup)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Recup FROM  `t_motif` WHERE Obs =  'recuperation' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_recuperation = mysqli_query($connection, $recuperation);
                            /*requete comissioin*/
                            $comission = "INSERT INTO comission(DeptId, Code, Dates, Com)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS Com FROM  `t_motif` WHERE Obs =  'comission' AND Dates=DATE(NOW())  GROUP BY DeptId, Dates";
                            $r_comission = mysqli_query($connection, $comission);
                            /*requete hospitalise*/
                            $hospitalise = "INSERT INTO hospitalise(DeptId, Code, Dates, HP)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS HP FROM  `t_motif`  WHERE Obs =  'hospitalise' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates";
                            $r_hospitalise = mysqli_query($connection, $hospitalise);
                            /*requete mise à pied*/
                            $miseapied = "INSERT INTO miseapied(DeptId, Code, Dates, MAP)
                                  SELECT DeptId, Code, Dates, COUNT( UserId ) AS MAP FROM  `t_motif`  WHERE Obs='miseapied' AND Dates=DATE(NOW()) GROUP BY DeptId, Dates
                                ";
                            $r_miseapied = mysqli_query($connection, $miseapied);
                            /*requete night shift*/
                            $nightshift = "INSERT INTO nightshift(DeptId, Code, Dates, NF) 
                                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(DISTINCT UserId) as NF FROM t_absence_jours WHERE Obs='night shift' AND Dates=DATE(NOW()) GROUP BY DeptId
                                ";
                            $r_nightshift = mysqli_query($connection, $nightshift);
                            /*requete sans motif*/
                            $sansmotif = "INSERT INTO sans_motif(DeptId, Code, Dates, SM) 
                                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(DISTINCT UserId) as SM FROM t_absence_jours WHERE Obs IS NULL AND Dates=DATE(NOW()) GROUP BY DeptId
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
                            WHERE A.Dates=DATE( NOW( ) ) AND A.Code!='EXP' AND A.Code!='GNBR'
                            GROUP BY A.DeptId
                            ";
                            $r_pourcentage_motif = mysqli_query($connection, $pourcentage_motif);

                            if($r_absence_motif && $r_sansmotif && $r_nightshift && $r_miseapied && $r_hospitalise && $r_comission && $r_recuperation 
                                && $r_suspendu && $r_permission && $r_abs_auto && $r_repos_medical && $r_maternite && $r_conge && $r_pourcentage_motif){
                                echo '
                                <div class="alert alert-success" role="alert">Absence motif is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">Absence motif is not inserted!</div>';
                            }
                        }
                        ############## INSERTION MOTIF ########################################################################

                        ################################### INSERTION POURCENTAGE D'ABSENCE JOURS######################################################
                        if (isset($_POST['btn_cdi'])) {
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
                            LEFT JOIN t_abs E  ON E.DeptId = A.DeptId AND E.Dates=Date_add(Date(now()), interval -1 day)                         
                            WHERE A.Dates=DATE( NOW( ) ) AND A.Code!='BDRCDD' AND A.Code!='DPRCDD' AND A.Code!='FORMATION' AND A.Code!='LVGCDD'
                            GROUP BY A.Code";
                            $r_cdi = mysqli_query($connection, $cdi);
                            /*requete TOTAL CDI*/
                            $tCDI="INSERT INTO `t_pourcentage_cdd_cdi`(`Code`, `EffJ_1`, `EffJ`, `Nb_pres`, `Nb_abs`, `P_abs`, `Conge`, `CM`, `AbsAuto`, `Perm`, `Com`, `Susp`, `RM`, `Recup`, `Hosp`, `Map`, `NS`, `SM`, `Dates`) 
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Total CDI' ELSE 'Total CDI' END), sum(EffJ_1), sum(EffJ), sum(Nb_pres), sum(Nb_abs), ROUND(sum(P_abs), 1), sum(Conge), sum(CM), sum(AbsAuto), sum(Perm), sum(Com), sum(Susp), sum(RM), sum(Recup), sum(Hosp), sum(Map), sum(NS), sum(SM), Dates 
                            FROM `t_pourcentage_cdd_cdi` WHERE Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR' GROUP BY Dates";
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
                            LEFT JOIN t_abs E  ON E.DeptId = A.DeptId AND E.Dates=Date_add(Date(now()), interval -1 day)                         
                            WHERE A.Dates=DATE( NOW( ) ) AND (A.Code='BDRCDD' OR A.Code='DPRCDD' OR A.Code='FORMATION' OR A.Code='LVGCDD')
                            GROUP BY A.Code";
                            $r_cdd = mysqli_query($connection, $cdd);
                            /*requete TOTAL CDD*/
                            $tCDD = "INSERT INTO `t_pourcentage_cdd_cdi`(`Code`, `EffJ_1`, `EffJ`, `Nb_pres`, `Nb_abs`, `P_abs`, `Conge`, `CM`, `AbsAuto`, `Perm`, `Com`, `Susp`, `RM`, `Recup`, `Hosp`, `Map`, `NS`, `SM`, `Dates`) 
                            SELECT  (CASE WHEN Code IS NOT NULL THEN  'Total CDD' ELSE 'Total CDD' END), sum(EffJ_1), sum(EffJ), sum(Nb_pres), sum(Nb_abs), sum(P_abs), sum(Conge), sum(CM), sum(AbsAuto), sum(Perm), sum(Com), sum(Susp), sum(RM), sum(Recup), sum(Hosp), sum(Map), sum(NS), sum(SM), Dates FROM `t_pourcentage_cdd_cdi` WHERE Dates=Date(now()) AND (Code='BDRCDD' OR Code='DPRCDD' OR Code='FORMATION' OR Code='LVGCDD') GROUP BY Dates";
                            $r_tCDD = mysqli_query($connection, $tCDD);


                            if($r_cdi && $r_tCDI && $r_cdd && $r_tCDD){
                                echo '
                                <div class="alert alert-success" role="alert">The data is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                            }
                        }
                        #######################################################################################################
                       
                        ############################ SUMARY MONTH #################################################################
                        if (isset($_POST['btn_sumary'])) {
                            /*requete administration / general */
                            $adm = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Administration/General' ELSE 'Administration/General' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'ADM' OR Code = 'GNR')";
                            $r_adm = mysqli_query($connection, $adm);
                            /*requete compliance */
                            $compliance = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Compliance' ELSE 'Compliance' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'CPL')";
                            $r_compliance = mysqli_query($connection, $compliance);
                            /*requete cleaners */
                            $cleaners = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Cleanears/Tree planting/Plant nursery' ELSE 'Cleanears/Tree planting/Plant nursery'END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'CPLC')";
                            $r_cleaners = mysqli_query($connection, $cleaners);
                            /*requete security */
                            $security = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Security' ELSE 'Security' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'GNRS')";
                            $r_security = mysqli_query($connection, $security);
                            /*requete store*/
                            $store = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Raw Materials/Parts' ELSE 'Raw Materials/Parts' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'STR')";
                            $r_store= mysqli_query($connection, $store);
                            /*requete zipper*/
                            $zipper = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Zipper Assembly' ELSE 'Zipper Assembly'END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'ZPR')";
                            $r_zipper = mysqli_query($connection, $zipper);
                            /*requete Pre production*/
                            $preproduction = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Pre_Production' ELSE 'Pre_Production' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'SMP' OR Code ='MRO' OR Code ='TRAIN' OR Code ='IE')";
                            $r_preproduction = mysqli_query($connection, $preproduction);
                            /*requete Pocket Setter*/
                            $pocket_setter = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Pocket setter' ELSE 'Pocket setter' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'BDRPS')";
                            $r_pocket_setter = mysqli_query($connection, $pocket_setter);
                            /*requete embroidery*/
                            $embroidery = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Embroidery' ELSE 'Embroidery' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'BDR')";
                            $r_embroidery = mysqli_query($connection, $embroidery);
                            /*requete cutting */
                            $cutting = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Cutting' ELSE 'Cutting' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'CPE')";
                            $r_cutting = mysqli_query($connection, $cutting);
                            /*requete fusing*/
                            $fusing = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Fusing' ELSE 'Fusing' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'CPEF')";
                            $r_fusing = mysqli_query($connection, $fusing);
                            /*requete sewing */
                            $sewing = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Sewing' ELSE 'Sewing' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'LN1' OR Code='LN2' OR Code='LN3' OR Code='LN4' OR Code='LN5' OR Code='LN6' OR Code='LN7'
                            OR Code = 'LN8' OR Code='LN9' OR Code='LN10' OR Code = 'LN11' OR Code='LN12' OR Code='LN13' OR Code='LN14' OR Code='LN15' OR Code='LN16' OR Code='LN17')";
                            $r_sewing = mysqli_query($connection, $sewing);
                            /*requete dry-process*/
                            $dry_process = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Dry Process' ELSE 'Dry Process' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'DPR')";
                            $r_dry_process= mysqli_query($connection, $dry_process);
                            /*requete laundry*/
                            $laundry = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Laundry' ELSE 'Laundry' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'LVG')";
                            $r_laundry = mysqli_query($connection, $laundry);
                            /*requete finishing */
                            $finishing = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Finishing' ELSE 'Finishing' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'FNT')";
                            $r_finishing = mysqli_query($connection, $finishing);
                            /*requete ind left over*/
                            $left_over = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Left over' ELSE 'Left over' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'FNTLO')";
                            $r_left_over = mysqli_query($connection, $left_over);
                            /*requete recycling */
                            $recycling = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Recycling' ELSE 'Recycling' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'RCL')";
                            $r_recycling = mysqli_query($connection, $recycling);
                            /*requete Sewing maintenance*/
                            $sewing_maintenance = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Sewing Maintenance' ELSE 'Sewing Maintenance' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'MEC')";
                            $r_sewing_maintenance = mysqli_query($connection, $sewing_maintenance);
                            /*requete general maintenance*/
                            $general_maintenance = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'General Maintenance' ELSE 'General Maintenance' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'MNT')";
                            $r_general_maintenance = mysqli_query($connection, $general_maintenance);
                            /*requete Water treatement*/
                            $water_treatement = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Water treatement/River service' ELSE 'Water treatement/River service' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'MNTWT')";
                            $r_water_treatement = mysqli_query($connection, $water_treatement);
                            /*requete QA*/
                            $qa = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'QA' ELSE 'QA' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now()) AND (Code = 'QA')";
                            $r_qa = mysqli_query($connection, $qa);
                            /*requete total cdi DATE(NOW())*/
                            $cdi = "INSERT INTO sumary(Code, TotalEmp, Nb_pres, Nb_abs, Dates)
                            SELECT (CASE WHEN Code IS NOT NULL THEN  'Total' ELSE 'Total' END) AS Code, SUM( Effectif ) AS Effectif, SUM( Nb_pres ) AS Nb_pres, SUM(Nb_abs) AS Nb_abs, Dates
                            FROM  `t_pourcentage_abs`  WHERE Dates = Date(now())";
                            $r_cdi = mysqli_query($connection, $cdi);

                        }
                        ############################# END SUMARY MONTH ############################################################
                       ################  INSERTION MOTIF JOURS ###############################################################
                        if (isset($_POST['insert_btn_6'])) {
                            $abs_motif="
                            INSERT INTO t_motif(UserId, Name, DeptId, Code, Effectif, Dates, Obs, Dates_fin)
                            SELECT  DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, Obs, Dates_fin 
                            FROM t_absence_jours WHERE ((Obs IS NOT NULL) AND Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR')
                            GROUP BY UserId";
                            $r_abs_motif = mysqli_query($connection, $abs_motif);
                            if($r_abs_motif){
                                echo '
                                <div class="alert alert-success" role="alert">Absence motif is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-success" role="alert">Pourcentage is not inserted!</div>';
                            }
                        }
                        ################  INSERTION CONGE JOURS ##############################################################
                        if (isset($_POST['insert_btn_7'])) {
                            $q = "INSERT INTO conge(DeptId, Code, Dates, C)
                                  SELECT DeptId, Code, Dates, COUNT(DISTINCT UserId ) AS C FROM  `t_motif` WHERE Obs =  'conge' AND Dates = DATE(NOW()) GROUP BY DeptId, Dates";
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
                                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(DISTINCT UserId) as NF FROM t_absence_jours WHERE Obs='night shift' AND Dates=DATE(NOW()) GROUP BY DeptId
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
                                  SELECT DISTINCT DeptId as DeptId, Code,Dates, count(DISTINCT UserId) as SM FROM t_absence_jours WHERE Obs IS NULL AND Dates=DATE(NOW()) GROUP BY DeptId
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
<!-- ###################################################################################################################### -->
                        <?php 

                        ################  INSERTION HEURES ENTREE SORTIE EMPLOYEE JOURS-1 ###################################
                        if (isset($_POST['insert_btn_24'])) {
                            $txtStartDate = $_POST['txtStartDate'];
                            $txtEndDate = $_POST['txtEndDate'];
                            // echo $txtStartDate;
                            // echo "<br>";
                            // echo $txtEndDate;
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
                                FROM t_h_e_s WHERE Dates BETWEEN '$txtStartDate' AND '$txtEndDate'
                                ";
                                $r_q = mysqli_query($connection, $q);
                                if($r_q){
                                    echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                                }else{
                                    echo '<div class="alert alert-success" role="alert">The data is not inserted!</div>';
                                }
                        }
                        ################  UPDATE HEURES ENTREE SORTIE JOURS-1 ###############################################
                        if (isset($_POST['update_btn_6'])) {
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
                        if (isset($_POST['update_btn_7'])) {
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
                        if (isset($_POST['update_btn_8'])) {
                            $q_update=" UPDATE t_h_travail SET H_travail=TIMEDIFF(H_travail, Pause)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '<div class="alert alert-success" role="alert">The data is updated!</div>';
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">The data is not updated!</div>';
                            }
                        }
                        ?>
                        <!-- heures travail périodique-->
                        <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTION DES HEURES PÉRIODIQUE</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                        <label>Debut : </label>
                                        <input type="date" name="txtStartDate">
                                        <label>Fin :</label>
                                        <input type="date" name="txtEndDate">
                                        <button class="btn btn-primary" type="submit" name="insert_btn_24">ENTREE SORTIE</button>
                                        <button class="btn btn-success" type="submit" name="update_btn_6">UPDATE</button>
                                        <button class="btn btn-primary" type="submit" name="update_btn_7">PLAGE</button>
                                        <button class="btn btn-success" type="submit" name="update_btn_8">UPDATE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- Fin heures travail périodique-->
<!-- ###################################################################################################################### -->
                        <!-- absence motif -->
                        <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">ABSENCE MOTIF</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                        <!-- btn_cdi -->
                                            <button class="btn btn-primary" type="submit" name="btn_motif">MOTIF</button>
                                            <button class="btn btn-primary" type="submit" name="btn_cdi">POURCENTAGE</button>
                                            <button class="btn btn-primary" type="submit" name="btn_sumary">SUMARY</button>
                                                <!-- <button class="btn btn-primary" type="submit" name="insert_btn_6">MOTIF</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_7">CONGE</button>
                                                <button class="btn btn-primary" type="submit" name="insert_btn_8">MAT</button>
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
                                                <button class="btn btn-success" type="submit" name="insert_btn_19">POURCENTAGE</button> -->
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
                        </div>
                    </div>
                        <!-- ============================================================== -->
                        <!-- end collectioin des données jours -1 -->
                        <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- end pagebody  -->
                    <!-- ============================================================== -->
                       <!-- </div> -->
                </div>
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