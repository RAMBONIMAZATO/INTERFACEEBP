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
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Absent </h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Liste</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Jours</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INSERTION JOURS -->
                        <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        if (isset($_POST['update_night_shift'])) {
                            /*$q_u="UPDATE t_sous_dept SET SousDept='07:00:00' WHERE UserId IN (SELECT UserId FROM t_present_jours WHERE Motif='night shift' AND Dates='2021-02-15')";
                            SELECT t_dept_user.UserId, t_dept_user.Name, t_dept_user.Fonction, t_dept_user.DeptId, t_dept_user.Code, t_dept_user.Effectif,DATE(NOW()) AS Dates ,t_present_jours.Dates AS TEST FROM t_dept_user 
LEFT JOIN t_present_jours ON t_dept_user.UserId = t_present_jours.UserId AND t_present_jours.Dates =  '2021-03-04' HAVING t_present_jours.Dates IS NULL LIMIT 10*/
                            $q_u="INSERT INTO test_abs(UserId, Name, Fonction, DeptId, Code, Effectif, Dates,Test)
SELECT t_dept_user.UserId AS Name, t_dept_user.Name AS Name, t_dept_user.Fonction AS Fonction, t_dept_user.DeptId AS DeptId, t_dept_user.Code AS Code, t_dept_user.Effectif AS Effectif, DATE(NOW()) AS Dates, t_present_jours.Dates AS Test
FROM t_dept_user LEFT JOIN t_present_jours ON t_dept_user.UserId = t_present_jours.UserId AND t_present_jours.Dates =  '2021-03-04' HAVING t_present_jours.Dates IS NULL";
                            $r_q_u = mysqli_query($connection, $q_u);
                            /*$q1="SELECT * FROM  `t_pres_h_jours` LIMIT 3";
                            $r_q1 = mysqli_query($connection, $q1);

                            $q2="SELECT * FROM  `t_abs` LIMIT 3";
                            $r_q2 = mysqli_query($connection, $q2);
                            $q3="SELECT * FROM  `t_pres_h_jours` LIMIT 3";
                            $r_q3 = mysqli_query($connection, $q3);

                            if($r_q1 && $r_q2 && $r_q3){*/
                            if($r_q_u){
                                echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-danger" role="alert">The data is not inserted!
                                    </div>';
                            }
                        }
                        echo "<br>";
                        /*if (isset($_POST['test2'])) {
                            
                            if ($r_q2) {
                                echo '<div class="alert alert-success" role="alert">The data is inserted!</div>';
                            }else{
                                echo '<div class="alert alert-danger" role="alert">The data is not inserted!
                                    </div>';
                            }
                        }*/


                        if (isset($_POST['insert_btn_1'])) {
                                $insert_l_ret="
                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE ((Dates = DATE( NOW( ) )) AND (Code !=  'ADM')AND (Code !=  'GNR') AND (H_E BETWEEN  '07:05:00' AND  '10:00:00'))
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE ((Dates = DATE( NOW( ) )) AND ( Code =  'ADM' ) AND (H_E BETWEEN  '08:05:00' AND  '10:00:00'))
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE ((Dates = DATE( NOW( ) )) AND (Code =  'GNR') AND (H_E BETWEEN  '06:05:00' AND  '10:00:00'))
                                ";
                                $r_insert_l_ret = mysqli_query($connection, $insert_l_ret);
                                if($insert_l_ret){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                    /*header("Location: insert_data.php");*/
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
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
                            /*if($r_update){
                                echo '<script> alert("Data Updated");</script>';
                                header("Location: insert_data.php");
                            }else{
                                echo '<script>alert("Data Not Updated");</script>';
                            }*/
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is updated!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not updated!
                                    </div>';
                            }
                        }
                        if (isset($_POST['insert_btn_2'])) {
                                $insert_p_ret = "
                                        INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                        SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                        FROM t_retard_jours WHERE Dates=Date(now()) GROUP BY DeptId
                                        ";
                                $r_insert_p_ret = mysqli_query($connection, $insert_p_ret);
                                if($r_insert_p_ret){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['insert_btn_3'])) {
                                $insert_l_abs = "
                                            INSERT INTO t_absence_jours(UserId, Name, DeptId, Code,Effectif, Dates)
                                            SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, DATE( NOW( ) ) AS Dates
                                            FROM t_dept_user
                                            WHERE UserId NOT IN (
                                            SELECT DISTINCT UserId
                                            FROM t_present_jours
                                            WHERE Dates = DATE( NOW( )))
                                            ";
                                            /*
                                            SELECT t_dept_user.UserId, t_dept_user.Name, t_dept_user.Fonction, t_dept_user.DeptId, t_dept_user.Code, t_dept_user.Effectif, t_present_jours.Dates
                                            FROM t_present_jours
                                            RIGHT JOIN t_dept_user ON t_present_jours.UserId = t_dept_user.UserId
                                            WHERE t_present_jours.Dates IS NULL 
                                            */
                                $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                                if($r_insert_l_abs){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['insert_btn_4'])) {
                            $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs) 
                                    SELECT DISTINCT DeptId as DeptId, DeptCode as Code, DeptEff as Effectif, Dates, COUNT( UserId ) as Nb_pres , (
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) as Nb_abs, ((
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) *100 / DeptEff) as p_abs
                                    FROM  `t_present_jours` 
                                    WHERE Dates =  Date(now())
                                    GROUP BY DeptId 
                                ";
                                $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
                                if($r_insert_p_abs){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                                }
                        }
                        // heures entreé sortie
                        if (isset($_POST['insert_btn_9'])) {
                             $insert_h_e="
                            INSERT INTO t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_entree, P_sortie, H_travail)
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
                           /* $insert_h_e="
                            INSERT INTO t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_entree, P_sortie, H_travail)
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
                            FROM t_h_e_s WHERE Dates BETWEEN '2020-08-01' AND '2020-09-08'
                                ";*/
                                $r_insert_h_e = mysqli_query($connection, $insert_h_e);
                                if($r_insert_h_e){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['update_btn_2'])) {
                            $q_update=" UPDATE t_h_travail 
                                            SET H_Retard=(timediff(H_entree, P_entree))
                                            WHERE SIGN(TIMEDIFF(H_entree, P_entree))>0
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is updated!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not updated!
                                    </div>';
                            }
                        }
                        if (isset($_POST['update_btn_3'])) {
                            $q_update=" UPDATE t_h_travail 
                                        SET Pause=(
                                        CASE
                                            WHEN H_entree!=H_sortie THEN '00:45:00'
                                        END)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is updated!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not updated!
                                    </div>';
                            }
                        }
                        if (isset($_POST['update_btn_4'])) {
                            $q_update=" UPDATE t_h_travail SET H_travail=TIMEDIFF(H_travail, Pause)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is updated!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not updated!
                                    </div>';
                            }
                        }

                        
                        // absence motif t_motif
                        if (isset($_POST['insert_btn_10'])) {
                            $absence_motif="
                                        INSERT INTO t_motif(UserId, Name, DeptId, Code, Effectif, Dates, Obs, Dates_fin)
                                        SELECT * FROM t_absence_jours WHERE ((Obs IS NOT NULL) AND Dates=Date(now()) AND Code!='EXP' AND Code!='GNBR' AND UserId<70000)
                                ";
                                $r_absence_motif = mysqli_query($connection, $absence_motif);
                                if($r_absence_motif){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Absence motif is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                                }
                        }


                        /*conge*/
                        if (isset($_POST['insert_btn_11'])) {
                            $q = "
                                INSERT INTO conge(DeptId, Code, Dates, C)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS C
                                FROM  `t_motif` 
                                WHERE Obs =  'conge'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      conge is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      conge is not inserted!
                                    </div>';
                            }
                        }
                        /*conge de maternite*/
                        if (isset($_POST['insert_btn_12'])) {
                            $q = "
                                INSERT INTO conge_mat(DeptId, Code, Dates, CM)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS CM
                                FROM  `t_motif` 
                                WHERE Obs =  'conge maternite'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      conge maternite is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      conge maternite is not inserted!
                                    </div>';
                            }
                        }
                        /*repos medical*/
                        if (isset($_POST['insert_btn_13'])) {
                            $q = "
                                INSERT INTO rep_med(DeptId, Code, Dates, RM)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS RM
                                FROM  `t_motif` 
                                WHERE Obs =  'repos medical'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      repos medical is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      repos medical is not inserted!
                                    </div>';
                            }
                        }
                        /*absence autorise*/
                        if (isset($_POST['insert_btn_14'])) {
                            $q = "
                                INSERT INTO abs_auto(DeptId, Code, Dates, AA)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS AA
                                FROM  `t_motif` 
                                WHERE Obs =  'absence autorise'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      absence autorise is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      absence autorise is not inserted!
                                    </div>';
                            }
                        }
                        /*permission*/
                        if (isset($_POST['insert_btn_15'])) {
                            $q = "
                                INSERT INTO permission(DeptId, Code, Dates, P)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS P
                                FROM  `t_motif` 
                                WHERE Obs =  'permission'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      permission is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      permission is not inserted!
                                    </div>';
                            }
                        }
                        /*suspendu*/
                        if (isset($_POST['insert_btn_16'])) {
                            $q = "
                                INSERT INTO suspendu(DeptId, Code, Dates, Susp)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS Susp
                                FROM  `t_motif` 
                                WHERE Obs =  'suspendu'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      suspendu is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      suspendu is not inserted!
                                    </div>';
                            }
                        }
                        /*recuperation*/
                        if (isset($_POST['insert_btn_17'])) {
                            $q = "
                                INSERT INTO recup(DeptId, Code, Dates, Recup)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS Recup
                                FROM  `t_motif` 
                                WHERE Obs =  'recuperation'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      recuperation is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                            }
                        }
                        /*comission*/
                        if (isset($_POST['insert_btn_18'])) {
                            $q = "
                                INSERT INTO comission(DeptId, Code, Dates, Com)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS Com
                                FROM  `t_motif` 
                                WHERE Obs =  'comission'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      comission is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      comission is not inserted!
                                    </div>';
                            }
                        }
                        /*hospitalise*/
                        if (isset($_POST['insert_btn_19'])) {
                            $q = "
                                INSERT INTO hospitalise(DeptId, Code, Dates, HP)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS HP
                                FROM  `t_motif` 
                                WHERE Obs =  'hospitalise'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      hospitalise is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      hospitalise is not inserted!
                                    </div>';
                            }
                        }
                        /*mise a jours*/
                        if (isset($_POST['insert_btn_20'])) {
                            $q = "
                                INSERT INTO miseapied(DeptId, Code, Dates, MAP)
                                SELECT DeptId, Code, Dates, COUNT( UserId ) AS MAP
                                FROM  `t_motif` 
                                WHERE Obs =  'miseapied'
                                AND Dates = DATE( NOW( ) ) 
                                GROUP BY DeptId, Dates
                                ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      mise à pied is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      mise à pied  is not inserted!
                                    </div>';
                            }
                        }
                        /*sans motif*/
                        if (isset($_POST['insert_btn_20'])) {
                            $q = "
                                INSERT INTO sans_motif(DeptId, Code, Dates, SM) 
                                SELECT DISTINCT DeptId as DeptId, Code,Dates, count(UserId) as SM
                                FROM t_absence_jours
                                WHERE Obs IS NULL 
                                AND Dates = DATE( NOW( ) )
                                GROUP BY DeptId
                                ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      mise à pied is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      mise à pied  is not inserted!
                                    </div>';
                            }
                        }
                        /*Insertion pourcentage absence

                        */
                        
                        if (isset($_POST['insert_btn_21'])) {
                            $q ="
                            INSERT INTO t_pourcentage_abs(DeptId,Code,Effectif, Nb_pres, Nb_abs,P_abs,C,CM,AA, P, Com,Susp,RM,Recup, HP, MAP,SM, Dates)
                            SELECT DISTINCT A.DeptId, A.Code, A.Effectif,A.Nb_pres,A.Nb_abs, (A.p_abs) AS P_abs, c.C, cm.CM, aa.AA,p.P, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, sm.SM, A.Dates
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
                            LEFT JOIN sans_motif sm ON A.DeptId=sm.DeptId AND A.Dates=sm.Dates
                            LEFT JOIN miseapied m ON A.DeptId = m.DeptId AND A.Dates=m.Dates
                            WHERE A.Dates = DATE( NOW( ) ) AND A.Code!='EXP' AND A.Code!='GNBR'
                            GROUP BY A.DeptId
                            /*SELECT DISTINCT A.DeptId, A.Code, A.Effectif,A.Nb_pres,A.Nb_abs, (A.p_abs) AS P_abs, c.C, cm.CM, aa.AA,p.P, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, A.Dates
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
                            WHERE A.Dates = DATE( NOW( ) ) 
                            GROUP BY A.DeptId*/
                            /*SELECT DISTINCT A.DeptId, A.Code, A.Effectif,A.Nb_pres,A.Nb_abs, (A.p_abs) AS P_abs, c.C, cm.CM, aa.AA, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, A.Dates
                            FROM t_abs A
                            LEFT JOIN conge c ON A.DeptId = c.DeptId
                            LEFT JOIN conge_mat cm ON A.DeptId = cm.DeptId
                            LEFT JOIN abs_auto aa ON A.DeptId = aa.DeptId
                            LEFT JOIN comission com ON A.DeptId = com.DeptId
                            LEFT JOIN suspendu sus ON A.DeptId = sus.DeptId
                            LEFT JOIN rep_med rm ON A.DeptId = rm.DeptId
                            LEFT JOIN hospitalise h ON A.DeptId = h.DeptId
                            LEFT JOIN recup rp ON A.DeptId = rp.DeptId
                            LEFT JOIN miseapied m ON A.DeptId = m.DeptId
                            WHERE A.Dates = DATE( NOW( ) ) 
                            GROUP BY A.DeptId*/
                            ";
                            $r_q = mysqli_query($connection, $q);
                            if ($r_q) {
                                echo '
                                    <div class="alert alert-success" role="alert">
                                      pourcentage is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      pourcentage is not inserted!
                                    </div>';
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
                    <?php 
                        if (isset($_POST['test1'])) { 
                            while ($row = mysqli_fetch_array($r_q1)) {
                                echo $row['UserId'];
                                echo "<br>";
                            }
                        }
                    ?>

                    <?php 
                        if (isset($_POST['test1'])) {
                            while ($row2 = mysqli_fetch_array($r_q2)) {
                                echo $row2['DeptId'];
                                echo "<br>";
                            } 
                        }

                    ?>

                    <?php 
                        if (isset($_POST['test1'])) {
                            while ($row3 = mysqli_fetch_array($r_q3)) {
                                echo $row3['UserId'];
                                echo "<br>";
                            } 
                        }

                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTIOIN DES DONNÉES</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.back.php" method="post">
                                        <button class="btn btn-primary" type="submit" name="update_night_shift">update night shift</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTIOIN DES DONNÉES JOURS</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                    	<!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste retard jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->

                                                <button class="btn btn-primary" type="submit" name="insert_btn_1">RETARD</button>

                                            <!-- </div> -->
                                        <!-- </div> -->
                                    	<!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours liste retard jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-success" type="submit" name="update_btn_1">UPDATE</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                    	<!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage retard jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_2">%RETARD</button>
                                            <!-- </div> -->
                                       <!--  </div> -->
                                    	<!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste absent jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_3">ABSENT</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                    	<!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage absent jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_4">%ABSENT</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
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
                                <h5 class="card-header">COLLECTIOIN DES HEURES</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                        <!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Heures entreé sortie</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_9">ENTREE SORTIE</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours Plage</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-success" type="submit" name="update_btn_3">UPDATE</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours heures travail</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-success" type="submit" name="update_btn_4">PLAGE</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <!-- <div class="form-group row"> -->
                                            <!-- <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours heures</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-success" type="submit" name="update_btn_2">UPDATE</button>
                                            <!-- </div> -->
                                        <!-- </div> -->
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
                                        <!-- <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Absence motif</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_10">MOTIF</button>
                                           <!--  </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Conge</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_11">CONGE</button>
                                          <!--   </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Maternite</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_12">MATERNITE</button>
                                           <!--  </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Repos Medical</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_13">REP MED</button>
                                            <!-- </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Absence Autorisé</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_14">ABS AUTO</button>
                                            <!-- </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Permissioni</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_15">PERM</button>
                                                
                                            <!-- </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Suspendu</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_16">SUSP</button>
                                            <!-- </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Recuperation</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_17">RECUP</button>
                                            <!-- </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Comission</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_18">COMISSION</button>
                                            <!-- </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Hospitalisé</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_19">HOSP</button>
                                           <!--  </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Hospitalisé</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_20">MAP</button>
                                               <!--  <br>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="body"></div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="body"></div>
                                                </div> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_21">POURCENTAGE</button>
                                            <!-- </div>
                                        </div> -->
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
                        if (isset($_POST['insert_btn_5'])) {
                                $insert_l_ret="
                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
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
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                    /*header("Location: insert_data.php");*/
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['update_btn_2'])) {
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
                            /*if($r_update){
                                echo '<script> alert("Data Updated");</script>';
                                header("Location: insert_data.php");
                            }else{
                                echo '<script>alert("Data Not Updated");</script>';
                            }*/
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                            }
                        }
                        if (isset($_POST['insert_btn_6'])) {
                                $insert_p_ret = "
                                        INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                        SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                        FROM t_retard_jours WHERE Dates=date_add(curdate(), interval -1 day) GROUP BY DeptId
                                        ";
                                $r_insert_p_ret = mysqli_query($connection, $insert_p_ret);
                                if($r_insert_p_ret){
                                    echo '<script> alert("Data Inserted");</script>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '<script>alert("Data Not Updated");</script>';
                                }
                        }
                        if (isset($_POST['insert_btn_7'])) {
                                $insert_l_abs = "
                                            INSERT INTO t_absence_jours(UserId, Name, DeptId, Code,Effectif, Dates)
                                            SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, date_add(curdate(), interval -1 day) AS Dates
                                            FROM t_dept_user
                                            WHERE UserId NOT IN (
                                            SELECT DISTINCT UserId
                                            FROM t_present_jours
                                            WHERE Dates = date_add(curdate(), interval -1 day)
                                            )
                                            ";
                                $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                                if($r_insert_l_abs){
                                    echo '<script> alert("Data Inserted");</script>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '<script>alert("Data Not Updated");</script>';
                                }
                        }
                        if (isset($_POST['insert_btn_8'])) {
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
                                    echo '<script> alert("Data Inserted");</script>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '<script>alert("Data Not Updated");</script>';
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
                                    	<!-- <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste retard dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_5">INSERTION</button>
                                            <!-- </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours liste retard dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-success" type="submit" name="update_btn_2">UPDATE</button>
                                            <!-- </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage retard dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_6">INSERTION</button>
                                            <!-- </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste absent dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_7">INSERTION</button>
                                            <!-- </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage absent dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6"> -->
                                                <button class="btn btn-primary" type="submit" name="insert_btn_8">INSERTION</button>
                                            <!-- </div>
                                        </div> -->
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