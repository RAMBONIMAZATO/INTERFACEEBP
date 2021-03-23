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
                    <!-- ============================================================== -->
                    <!-- begin collectioin des données jours  action="insertion_dept.php"-->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">INSERTION MS ACCESS</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate=""  method="post">
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste departement</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert">INSERTION</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end collectioin des données jours  -->
                    <!-- ============================================================== -->
                    <!-- INSERTION JOURS -->
                        <?php 
                        if (isset($_POST['insert'])) {
                        	echo "baby";
                        }
                        $connection = odbc_connect("mklen", "", "");
                        if (isset($_POST['insert2'])) {
                                $sql="
                                	INSERT INTO t_dept_save(DeptId, Code, Effectif) VALUES('5','TEST','55')
                                ";
                                $r_q = odbc_do($connection, $sql);
                                if($r_q){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
						/*$con=odbc_connect("mklen", "", "");

                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours`  
                                WHERE ((Dates=Date(now())) AND (Code!='ADM') AND (Code!='GNR') AND (H_E between '07:10:00' and '10:00:00'))
                                UNION
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
                                WHERE ((Dates=Date(now())) AND (Code='ADM') AND (H_E between '08:10:00' and '10:00:00'))
                                UNION
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
                                WHERE ((Dates=Date(now())) AND (Code='GNR') AND (H_E between '06:10:00' and '10:00:00'))

						$sql="INSERT INTO t_dept_save(DeptId, Code, Effectif) VALUES('5','TEST','55')";
                        if (isset($_POST['insert'])) {
                        	echo "string";
							$res=odbc_do($con, $sql) or die(odbc_error());
							if ($res) {
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
						}else{
							echo "not insert";
						}*/
                    ?>  
                    <!-- END INSERTION DEPT -->
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <!-- <div class="row"> -->
                    <!-- ============================================================== -->
                    <!-- begin  pagebody  -->
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