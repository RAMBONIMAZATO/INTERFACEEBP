<?php  
    $connection = mysqli_connect("localhost", "root", "");
    $bd = mysqli_select_db($connection, 'ebp');

// index dept
    $query = "SELECT DeptId AS Deptid, min(Code) AS DeptCode, count(UserId) AS DeptEff FROM t_dept_user GROUP BY  DeptId";
    $query_run = mysqli_query($connection, $query);
//  user
    if (isset($_POST['show_btn'])) {
    	$Deptid = $_POST['show_id'];
        $q_user = "SELECT UserId, Name, Fonction, Code FROM t_dept_user WHERE DeptId=$Deptid";
        $r_user = mysqli_query($connection, $q_user);
    }
// Pourcentage jours tsy mety
    $p_abs_jours = "
    		SELECT Code, Effectif, Dates, Nb_pres, Nb_abs, ROUND(p_abs, 2) AS p_abs FROM t_abs WHERE Dates=Date(now()) AND Code!='STC'
            ";
    $r_abs_jours = mysqli_query($connection, $p_abs_jours);
// Liste absent jours
	$l_abs_jours = "SELECT distinct UserId AS UserId, Name, DeptId, Code, Effectif, Dates 
					FROM t_absence_jours WHERE Dates=Date(now())";
    $r_abs_jours = mysqli_query($connection, $l_abs_jours);
// Pourcentage jours -1 tsy mety
    $p_abs_jours_1 = "SELECT distinct DeptId AS DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, ROUND(p_abs, 2) AS p_abs FROM t_abs 
    					WHERE Dates=date_add(curdate(), interval - 1 day) AND Code!='STC'";
    $r_abs_jours_1 = mysqli_query($connection, $p_abs_jours_1);
// Liste absent jours -1 
    $l_abs_jours_1 = "SELECT distinct UserId AS UserId, Name, DeptId, Code, Effectif, Dates FROM t_absence_jours WHERE (Dates=date_add(curdate(), interval - 1 day)) AND (Obs IS NULL)";
    $r_abs_jours_1 = mysqli_query($connection, $l_abs_jours_1);
// Liste absent jours motif
    $l_abs_motif = "SELECT distinct(UserId) AS UserId, Name, DeptId, Code, Effectif, Dates, Obs FROM t_absence_jours WHERE (Dates=date_add(curdate(), interval - 1 day)) AND (Obs IS NOT NULL)";
    $r_abs_motif = mysqli_query($connection, $l_abs_motif);
// Pourcentage retard jours
    $p_ret_jours = "SELECT DISTINCT DeptId AS DeptId, Code, Effectif, Nb_ret, ROUND(P_ret, 1) AS P_ret, Dates 
                    FROM t_pourcentage_retard WHERE (Dates=Date(now())) AND (Code!='STC')";
    $r_p_ret_jours = mysqli_query($connection, $p_ret_jours);
// Liste retard jours
    $l_ret_jours = "SELECT DISTINCT UserId,  Code, H_E, P_E, H_ret, Dates FROM t_retard_jours WHERE (Dates=Date(now())) AND (Code!='STC') ORDER BY UserId";
    $r_l_ret_jours = mysqli_query($connection, $l_ret_jours);

// Pourcentage retard hebdomadaire
if (isset($_POST['search'])) {    
    $txtStartDate = $_POST['txtStartDate'];
    $txtEndDate = $_POST['txtEndDate'];   
    $p_ret_hebdo = "SELECT DISTINCT DeptId AS DeptId, Code, Effectif, Nb_ret, ROUND(P_ret, 2) AS P_ret, Dates 
                    FROM t_pourcentage_retard WHERE (Dates BETWEEN '$txtStartDate' AND '$txtEndDate') AND (Code!='STC') GROUP BY DeptId, Dates";
    $r_p_ret_hebdo = mysqli_query($connection, $p_ret_hebdo);
}
// Pourcentage retard mensuel
if (isset($_POST['search'])) {    
    $txtStartDate = $_POST['txtStartDate'];
    $txtEndDate = $_POST['txtEndDate'];   
    $p_ret_mens = "SELECT DISTINCT DeptId AS DeptId, Code, Effectif, Nb_ret, ROUND(P_ret, 2) AS P_ret, Dates 
                    FROM t_pourcentage_retard WHERE (Dates BETWEEN '$txtStartDate' AND '$txtEndDate') AND (Code!='STC') GROUP BY DeptId, Dates";
    $r_p_ret_mens = mysqli_query($connection, $p_ret_mens);
}

// Liste heures travail jours
$h_w_jours = "SELECT DISTINCT UserId,  Name, Fonction, Code, Dates, H_entree, H_sortie, P_entree, P_sortie, Pause, H_travail FROM t_h_travail WHERE (Dates=date_add(curdate(), interval -1 day)) GROUP BY UserId";
$r_h_w_jours = mysqli_query($connection, $h_w_jours);
/*$h_w_jours = "SELECT DISTINCT UserId,  Name, Fonction, Code, Dates, H_entree, H_sortie, P_entree, P_sortie, Pause, H_travail FROM t_h_travail WHERE (Dates='2020-11-29') GROUP BY UserId";

*/

// Liste heures travail hebdomadaire

if (isset($_POST['search'])) { 
    $txtStartDate = $_POST['txtStartDate'];
    $txtEndDate = $_POST['txtEndDate'];
    $h_w_hebdo = "
    SELECT UserId,  Code, Dates, H_entree, H_sortie, Pause, H_travail 
    FROM t_h_travail WHERE (Dates BETWEEN '$txtStartDate' AND '$txtEndDate') ORDER BY UserId";
    $r_h_w_hebdo = mysqli_query($connection, $h_w_hebdo);
}
?>