<?php
$connect = mysqli_connect("localhost", "root", "", "ebp");
//$columns = array('UserId','DeptId', 'Code', 'Effectif', 'Dates');
$columns = array('Code', 'Effectif', 'Dates', 'Nb_pres', 'Nb_abs', 'p_abs');
$query = "SELECT DISTINCT DeptId AS DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, ROUND(p_abs, 2) AS p_abs FROM t_abs WHERE ";
//$query = "SELECT UserId, DeptId, Code, Effectif, Dates FROM  t_absence_jours WHERE";
if($_POST["is_date_search"] == "yes")
{
 $query .= 'Dates BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (Code LIKE "%'.$_POST["search"]["value"].'%"
  OR Effectif LIKE "%'.$_POST["search"]["value"].'%" 
  OR Dates LIKE "%'.$_POST["search"]["value"].'%" 
  OR Nb_pres LIKE "%'.$_POST["search"]["value"].'%"
  OR Nb_abs LIKE "%'.$_POST["search"]["value"].'%"
  OR p_abs LIKE "%'.$_POST["search"]["value"].'%")
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY Code ASC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}else{
	$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['end'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["Code"];
 $sub_array[] = $row["Effectif"];
 $sub_array[] = $row["Dates"];
 $sub_array[] = $row["Nb_pres"];
 $sub_array[] = $row["Nb_abs"];
 $sub_array[] = $row["p_abs"];

 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs FROM t_abs";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
} 
/*SELECT * FROM `t_absence_jours` WHERE Dates BETWEEN '2020-07-10' AND '2020-07-17' ORDER BY UserId*/
$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>