<?php
$connect = mysqli_connect("localhost", "root", "", "ebp");
//$columns = array('DeptId', 'Code', 'Effectif',  'Nb_ret', 'P_ret', 'Dates');
$columns = array('Code', 'Effectif',  'Nb_ret', 'P_ret', 'Dates');
$query = "SELECT Code, Effectif, Nb_ret, ROUND(P_ret, 2) AS P_ret, Dates FROM t_pourcentage_retard WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'Dates BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (Code LIKE "%'.$_POST["search"]["value"].'%" 
  OR Effectif LIKE "%'.$_POST["search"]["value"].'%" 
  OR Nb_ret LIKE "%'.$_POST["search"]["value"].'%"
  OR P_ret LIKE "%'.$_POST["search"]["value"].'%"
  OR Dates LIKE "%'.$_POST["search"]["value"].'%")
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
 $sub_array[] = $row["Nb_ret"];
 $sub_array[] = $row["P_ret"];
 $sub_array[] = $row["Dates"];
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT Code, Effectif, Nb_ret, ROUND(P_ret, 2) AS P_ret, Dates FROM t_pourcentage_retard";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
} 

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>