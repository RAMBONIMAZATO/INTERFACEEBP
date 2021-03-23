<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Etat de pointage hebdomadaire</title>
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
        <?php include('../config/template/leftbar_etat.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Liste etat hebdomadaire</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Département</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">État</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Hebdomadaire</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- page body -->
                <!-- ============================================================== -->
                <div class="row">
                    <?php  
                                                                                
                        /*$hostname = "localhost";
                        $dbname = "ebp";
                        $Username = "root";
                        $Password = "";*/
                        $connection = mysqli_connect("localhost", "root", "");
                        $bd = mysqli_select_db($connection, 'ebp');

                        /*$conn = mysqli_connect($hostname, $Username, $Password, $dbname);*/
                        /*if(!$conn){
                            die("Connection failed" .mysqli_connect_error());
                        }*/
                        if (isset($_POST['search'])) {
                            $txtUser = $_POST['txtUser'];
                            $txtCode = $_POST['txtCode'];
                            $txtStartDate = $_POST['txtStartDate'];
                            $txtEndDate = $_POST['txtEndDate'];

                            /*$query = mysqli_query($connection, 
                                "SELECT UserId, Name, Code, Dates, H_E, P_E, H_ret FROM t_retard_jours WHERE (Dates BETWEEN '$txtStartDate' AND '$txtEndDate') AND (UserId='$txtUser') AND (Code='$txtCode')");*/
                            /*$count = mysqli_num_rows($query);*/
                        }
                    ?>
                <!-- ============================================================== -->
                <!-- table retard journalier -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">État hebdomadaire</h5>
                                    <form method="post">
                                    	<div>
                                    		<label>N°Mat</label>
                                    		<input type="text" name="txtUser">
                                    		<label>Dept</label>
                                    		<input type="text" name="txtCode">
                                    		<label>Debut</label>
                                    		<input type="date" name="txtStartDate">
                                    		<label>Fin</label>
                                    		<input type="date" name="txtEndDate">
                                    		<input type="submit" name="search" value="Affiche">
                                    	</div>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Mat</th>
                                                    <th>Code</th>
                                                    <th>Date entree</th>
                                                    <th>Date fin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                        <td><?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtUser;
                                        } ?> 
                                                        </td>
                                                        <td> <?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtCode; 
                                        } ?>
                                                        </td>
                                                        <td><?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtStartDate; 
                                        } ?>
                                                        </td>
                                                        <td><?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtEndDate; 
                                        } ?>
                                                        </td>
<!--                                                 <tr>
                                                    <td><?php 
                                        if (isset($_POST['search'])) {                                    
                                                echo $_POST['txtUser']; 
                                                echo $_POST['txtCode']; 
                                                echo $_POST['txtStartDate']; 
                                                echo $_POST['txtEndDate']; 
                                        }
                                        ?> </td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">

                                        
                                        <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Mat</th>
                                                    <th>Code</th>
                                                    <th>Date entre</th>
                                                    <th>Date sortie</th>
                                                    <!-- <th>Matricule</th>
                                                    <th>Name</th>
                                                    <th>Departement</th>
                                                    <th>Dates</th>
                                                    <th>Heure entrée</th>
                                                    <th>Plage heures</th>
                                                    <th>Heure retard</th> -->
                                                </tr>
                                            </thead>
                                        <!-- <?php 
                                            while ($row = mysqli_fetch_array($query)) {
                                        ?> -->
                                                    <tr>
                                                        <td><?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtUser;
                                        } ?> 
                                                        </td>
                                                        <td> <?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtCode; 
                                        } ?>
                                                        </td>
                                                        <td><?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtStartDate; 
                                        } ?>
                                                        </td>
                                                        <td><?php 
                                        if (isset($_POST['search'])) { 
                                            echo $txtEndDate; 
                                        } ?>
                                                        </td>
                                                       <!--  <td><?php echo $row["UserId"]; ?></td>
                                                        <td><?php echo $row['Name']; ?></td>
                                                        <td><?php echo $row["Code"]; ?></td>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                        <td><?php echo $row["H_E"]; ?></td>
                                                        <td><?php echo $row["P_E"]; ?></td>
                                                        <td><?php echo $row["H_ret"]; ?></td> -->
                                                    </tr>
                                        <!-- <?php
                                            }
                                        ?> -->
                                        </table>
                                    </div> 
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

<div class="card-body">
                                      <!--   <table class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Mat</th>
                                                    <th>Name</th>
                                                    <th>Code</th>
                                                    <th>Date</th>
                                                    <th>H entree</th>
                                                </tr>
                                            </thead> -->
                                                <?php 
                                                    if (isset($_POST['search'])) { 
                                                        while ($row = mysqli_fetch_array($r_query)) {
                                                            echo $row['UserId'];
                                                            echo $row['Name'];
                                                            echo $row['Code'];
                                                            echo $row['Dates'];
                                                            echo $row['H_E'];
                                                        }
                                                    }
                                                ?>
                                               <!--  <tr>
                                                    <td><?php echo $row['UserId']; ?></td>    
                                                    <td><?php echo $row['Name']; ?></td>    
                                                    <td><?php echo $row['Code']; ?></td>    
                                                    <td><?php echo $row['Dates']; ?></td>    
                                                    <td><?php echo $row['H_E']; ?></td>    
                                                </tr>
                                                <?php 
                                                    }
                                                }
                                                ?> -->
                                        <!-- </table> -->
                                </div>

insert into t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_heure, H_travail)
select UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie,
(CASE
   WHEN Code='ADM' THEN '08:00:00'
   ELSE '06:30:00'
END) as P_heure,
H_travail
from t_h_e_s



update t_h_travail 
set H_Retard=timediff(H_entree, P_heure)
WHERE Dates=date_add(curdate(), interval -1 day) AND SIGN( TIME_TO_SEC( timediff(H_Retard, P_heure) ) ) >0

SELECT DISTINCT H_Retard
FROM  `t_h_travail` 
WHERE SIGN( TIME_TO_SEC( H_Retard ) ) >0

update t_h_travail 
set 
 H_Retard=timediff(H_entree, P_heure)
WHERE Dates BETWEEN '2020-08-01' AND '2020-08-30' 

SELECT DeptId,Code, Dates,
(case
   when Obs='conge maternite' then count(distinct UserId) end) as cm,
(case   when Obs='repos medical' then count(distinct UserId) end) as rm,
(case   when Obs='sans motif' then count(distinct UserId) end) as sm,
(case   when Obs='conge' then count(distinct UserId) end) as c,
(case   when Obs='absence autorise' then count(distinct UserId)
end) as abs
FROM `t_absence_jours` WHERE (Obs IS NOT NULL) AND Dates='2020-09-04'
GROUP BY DeptId, Dates

SELECT DeptId,Code, Dates,
(case
   when Obs='conge maternite' then count(distinct UserId) end) as cm
FROM `t_absence_jours` WHERE (Obs IS NOT NULL) AND Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   when Obs='repos medical' then count(distinct UserId) end) as rm
FROM `t_absence_jours` WHERE (Obs IS NOT NULL) AND Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   
	when Obs='sans motif' then count(distinct UserId) 
end) as sm
FROM `t_absence_jours` WHERE (Obs IS NOT NULL) AND Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   when Obs='conge' then count(distinct UserId) end) as c
FROM `t_absence_jours` WHERE (Obs IS NOT NULL) AND Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   when Obs='absence autorise' then count(distinct UserId)
end) as abs
FROM `t_absence_jours` WHERE (Obs IS NOT NULL) AND Dates='2020-09-04'
GROUP BY DeptId, Dates


SELECT DeptId,Code, Dates,
(case
   when (Obs IS NOT NULL) then count(distinct UserId) end) as cm
FROM `t_absence_jours` WHERE Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   when (Obs IS NOT NULL) then count(distinct UserId) end) as rm
FROM `t_absence_jours` WHERE Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   
	when (Obs IS NOT NULL) then count(distinct UserId) 
end) as sm
FROM `t_absence_jours` WHERE Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   when (Obs IS NOT NULL) then count(distinct UserId) end) as c
FROM `t_absence_jours` WHERE Dates='2020-09-04'
GROUP BY DeptId, Dates
UNION DISTINCT
SELECT DeptId,Code, Dates,
(case   when (Obs IS NOT NULL) then count(distinct UserId)
end) as abs
FROM `t_absence_jours` WHERE Dates='2020-09-04'
GROUP BY DeptId, Dates

SELECT DeptId, 
count(UserId)
FROM `t_motif` WHERE Obs='repos medical'
UNION 
SELECT DeptId, 
count(UserId)
FROM `t_motif` WHERE Obs='permission'
UNION 
SELECT DeptId, 
count(UserId)
FROM `t_motif` WHERE Obs='sans motif'
UNION 
SELECT DeptId, 
count(UserId)
FROM `t_motif` WHERE Obs='conge maternite'
UNION 
SELECT DeptId, 
count(UserId)
FROM `t_motif` WHERE Obs='conge'


SELECT DeptId, 
(case
when Obs='repos medical' then Obs
end) as 'test1',
(case 
when Obs='permission' then Obs
end) as 'test2',
(case 
when Obs='sans motif' then Obs
end) as 'test3',
(case 
when Obs='conge maternite' then Obs
end) as 'test4',
(case 
when Obs='conge' then Obs
end) as 'test5'
FROM `t_motif` 
WHERE Dates='2020-09-04'
GROUP BY DeptId


SELECT DeptId, 
(case
when Obs='repos medical' then Obs
end) as 'test1',
(case 
when Obs='permission' then Obs
end) as 'test2',
(case 
when Obs='sans motif' then Obs
end) as 'test3',
(case 
when Obs='conge maternite' then Obs
end) as 'test4',
(case 
when Obs='conge' then Obs
end) as 'test5'
FROM `t_motif` 
WHERE Dates='2020-09-04'


SELECT DeptId, (

CASE 
WHEN Obs =  'repos medical'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'RM', (

CASE 
WHEN Obs =  'permission'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'P', (

CASE 
WHEN Obs =  'sans motif'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'SM', (

CASE 
WHEN Obs =  'conge maternite'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'CM', (

CASE 
WHEN Obs =  'conge'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'C'
FROM  `t_motif` 
WHERE Dates =  '2020-09-04'
GROUP BY DeptId


INSERT INTO `ebp`.`t_motif` (`UserId`, `Name`, `DeptId`, `Code`, `Effectif`, `Dates`, `Obs`, `Dates_fin`) VALUES ('321', 'ose', '34', 'GNR', '52', '2020-09-04', 'repos medical', NULL);


INSERT INTO t_m(DeptId, RM, P, SM, CM, C)
SELECT DeptId, (
CASE 
WHEN Obs =  'repos medical'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'RM', (
CASE 
WHEN Obs =  'permission'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'P', (
CASE 
WHEN Obs =  'sans motif'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'SM', (
CASE 
WHEN Obs =  'conge maternite'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'CM', (
CASE 
WHEN Obs =  'conge'
THEN COUNT( DISTINCT UserId ) 
END
) AS  'C'
FROM  `t_motif` 
WHERE Dates =  '2020-09-04'
GROUP BY DeptId


SELECT DISTINCT DeptId, Code, (

CASE 
WHEN Obs =  'repos medical'
THEN Obs
END
) AS  'test1', (

CASE 
WHEN Obs =  'permission'
THEN Obs
END
) AS  'test2', (

CASE 
WHEN Obs =  'sans motif'
THEN Obs
END
) AS  'test3', (

CASE 
WHEN Obs =  'conge maternite'
THEN Obs
END
) AS  'test4', (

CASE 
WHEN Obs =  'conge'
THEN Obs
END
) AS  'test5'
FROM  `t_motif` 
WHERE Dates =  '2020-09-04'