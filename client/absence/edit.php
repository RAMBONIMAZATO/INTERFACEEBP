
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php  
$connection = mysqli_connect("localhost", "root", "");
$bd = mysqli_select_db($connection, 'ebp');
if (isset($_POST['edit'])) {
	$user = $_POST['show_id'];
	$dates = $_POST['show_id2'];

	$query = "SELECT UserId, Dates ,Name FROM t_absence_jours WHERE UserId=$user AND Dates=$dates";
	$r_query = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_array($r_query)) {
		echo $row['UserId'];
	}
?>

<!-- <input type="text" name="" value="<?php echo $user; ?>">
<input type="text" name="" value="<?php echo $dates; ?>">
<form>
	<input type="button" name="" value="SAVE">
</form> -->
<?php } ?>
<?php 
	 ?>
</body>
</html>