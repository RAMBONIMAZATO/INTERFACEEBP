<?php
$connect = mysqli_connect("localhost", "root", "", "ebp");
$columns = array('UserId',  'Code',   'Dates', 'H_E', 'P_E', 'H_ret');

$query = "SELECT * FROM t_retard_jours WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'Dates BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (UserId LIKE "%'.$_POST["search"]["value"].'%" 
  OR Code LIKE "%'.$_POST["search"]["value"].'%" 
  OR Dates LIKE "%'.$_POST["search"]["value"].'%" 
  OR H_E LIKE "%'.$_POST["search"]["value"].'%"
  OR P_E LIKE "%'.$_POST["search"]["value"].'%"
  OR H_ret LIKE "%'.$_POST["search"]["value"].'%")
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['2']['column']].' '.$_POST['order']['2']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY Dates ASC ';
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
 $sub_array[] = $row["UserId"];
 $sub_array[] = $row["Code"];
 $sub_array[] = $row["Dates"];
 $sub_array[] = $row["H_E"];
 $sub_array[] = $row["P_E"];
 $sub_array[] = $row["H_ret"];
 $data[] = $sub_array;
	

}

function get_all_data($connect)
{
 $query = "SELECT * FROM t_retard_jours";
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