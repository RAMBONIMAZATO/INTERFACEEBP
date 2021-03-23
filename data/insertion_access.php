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
    <!-- ajax selector -->
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
     <form method="post">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label>UserId : </label>
                        <input type="text" name="txtUserId">
                    </td>
                    <td>
                        <label>Name : </label>
                        <input type="text" name="txtName">
                    </td>
                    <td>
                        <label>Fonction :</label>
                        <input type="text" name="txtFonction">
                    </td>
                    <td>
                        <label>Adresse:</label>
                        <input type="text" name="txtAddress">
                    </td>
                    <td>
                        <label for="txtSex">Sex :</label>
                        <select name="txtSex">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </td>
                    <td>
                        <label for="txtDept">Dept :</label>
                        <select name="txtDept">
                            <option selected="selected">Choix</option>
                            <?php  
                                $con = odbc_connect("mklen", "", "");
                                $q_dept ="SELECT Deptid, DeptName FROM Dept WHERE Deptid<>65
                                ORDER BY DeptName";
                                $r_q_dept = odbc_exec($con, $q_dept);
                                while ($row = odbc_fetch_array($r_q_dept)) {
                            ?>
                            <option value="<?php echo $row['Deptid']; ?>"><?php echo $row['DeptName']; ?></option>
                            <?php
                                }
                            ?>
                            <?php odbc_close($con); ?>
                        </select>
                    </td>
                    <td>
                        <label for="txtNation">Nation :</label>
                        <select name="txtNation">
                            <option value="MALAGASY">MALAGASY</option>
                            <option value="Français">Français</option>
                            <option value="KENYA">KENYA</option>
                            <option value="PHILIPPIAN">PHILIPPIAN</option>
                            <option value="MAURITIAN">MAURITIAN</option>
                            <option value="SRI LANKA">SRI LANKA</option>
                            <option value="BANGLADESH">BANGLADESH</option>
                        </select>
                    </td>
                    <td>
                        <label>Date d'embauche : </label>
                        <input type="date" name="Dates">
                    </td>
                    <td>
                        <label>Heure entrée :</label>
                        <input type="time" name="txtPlageE">
                    </td>
                    <td>
                        <label>Insertion :</label>
                        <button class="btn btn-primary" type="submit" name="search">AJOUT</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div>
        <?php 
            $con=odbc_connect("mklen", "", "");
            
            if (isset($_POST['search'])) {
                $user=$_POST['txtUserId'];
                $name=$_POST['txtName'];
                $fonction=$_POST['txtFonction'];
                $adresse=$_POST['txtAddress'];
                $sex=$_POST['txtSex'];
                $dept=$_POST['txtDept'];
                $nation=$_POST['txtNation'];
                $dates =$_POST['Dates'];
                $heures =$_POST['txtPlageE'];
                $sql1="INSERT INTO Userinfo(Userid, Name, Sex, Deptid, Nation, EmployDate, Duty, Address, Plage_E) 
                VALUES('$user', '$name', '$sex', '$dept', '$nation', '$dates', '$fonction','$adresse', '$heures')";
                $res1=odbc_exec($con, $sql1);
                if ($res1) {
                    header("Location: insertion_access.php");
                }else{
                    echo "The data is not inserted";
                }

            }
            odbc_close($con);
        ?>
    </div>
<!-- ######################################################################################################################################################### -->

        
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
