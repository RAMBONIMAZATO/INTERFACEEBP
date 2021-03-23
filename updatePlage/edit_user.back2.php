<?php
/*$connection = mysqli_connect("localhost", "root", "");
$bd = mysqli_select_db($connection, 'ebp');*/

        /*$query="UPDATE t_sous_dept set Name='" . $_POST["Name"][$i] . "', Duty='" . $_POST["Fonction"][$i] . "', Code='" . $_POST["Code"][$i] . "'
        WHERE UserId='" . $_POST["UserId"][$i] . "'";
        mysqli_query($connection, $query); or die ("Error Execute [".$query."]")*/
        /*'" . $_POST["Userid"][$i] . "'*/
$connection = odbc_connect("mklen", "", "");
if(isset($_POST["save"]) && $_POST["save"]!="") {
    /*$txtTime=Format(,'hh:mm:ss');*/
    $usersCount = count($_POST["Name"]);
    for($i=0;$i<$usersCount;$i++) {
        $plage=$_POST["Plage_E"][$i];
        $matUser=$_POST["Userid"][$i];
        $plageE=$_POST['txtTime'];
        $query="UPDATE Userinfo SET  Plage_E='$plageE' WHERE Userid='$matUser'";
        odbc_exec($connection, $query); 
    }
    odbc_close($connection);
    header("Location: index.php");
}

?>
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
<title>Edit Multiple User</title>
</head>
<body>
<div class="dashboard-main-wrapper">
    <?php include('../config/template/header.php'); ?>
    <div class="row">
        <div class="card-body">
            <form name="frmUser" method="post" action="">
                <div class="table-responsive">
                    <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                        <thead>
                            <tr>
                                <td>UserId</td>
                                <!-- <td>Name</td>
                                <td>Fonction</td> -->
                                <td>Name</td>
                                <td>Plage</td>
                            </tr>
                        </thead>
                        <?php
                            $connection = odbc_connect("mklen", "", "");
                            $rowCount = count($_POST["users"]);
                            for($i=0;$i<$rowCount;$i++) {
                                /*$mat=$_POST["users"][$i];
                                $q="SELECT Userinfo.Userid AS Userid, Userinfo.Name AS Name, Format(Userinfo.Plage_E, 'hh:mm:ss') AS Plage_E FROM Userinfo WHERE Userid='$mat'";*/
                                $q="SELECT Userinfo.Userid AS Userid, Userinfo.Name AS Name, Format(Userinfo.Plage_E, 'hh:mm:ss') AS Plage_E FROM Userinfo WHERE Userid='" . $_POST["users"][$i] . "'";
                                $result = odbc_exec($connection, $q);
                                $row[$i]= odbc_fetch_array($result);
                        ?>
                        <tr>
                            <td><label><?php echo $row[$i]['Userid']; ?></label></td>
                            <td>
                                <input type="hidden" name="Userid[]" class="txtField" value="<?php echo $row[$i]['Userid']; ?>">
                                <input type="text" name="Name[]" class="txtField" value="<?php echo $row[$i]['Name']; ?>">
                                <!-- <label><?php echo $row[$i]['Name']; ?></label> -->
                            </td>
                            <td><input type="text" name="Plage_E[]" class="txtField" value="<?php echo $row[$i]['Plage_E']; ?>"></td>
                            <!-- <td><input type="text" name="Duty[]" class="txtField" value="<?php echo $row[$i]['Duty']; ?>"></td>
                            <td><input type="text" name="Code[]" class="txtField" value="<?php echo $row[$i]['Code']; ?>"></td> 
                            
                        -->
                            <!-- <td><label><?php echo $row[$i]['Plage_E']; ?></label></td> -->
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                        <?php odbc_close($connection); ?>
                    
                </div>

                <div class="card-footer">
                        <label>CHOIX : </label>
                        <input type="text" name="txtTime">
                        <input type="submit" name="save" value="SAVE" class="btn btn-success">
                    </div>
            </form>
        </div>
    </div>

        <?php include('../config/template/footer.php'); ?>
    </div>
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
    <script type="text/javascript" src="../assets/vendor/popper/popper.min.js"></script>
    <!--  print data-->
    <script type="text/javascript" language="javascript">
    
        $(document).ready(function() {
            $('#table_data').DataTable({
                dom: 'lBfrtip'              
            });
        });

    </script>
</body>
</html>