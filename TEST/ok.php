<?php
// Connection to the database
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="test"; // Database name 
$tbl_name="test_mysql"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

	if(isset($_POST['checkbox'])){
		$checkbox = $_POST['checkbox'];
		if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
			$id = "('" . implode( "','", $checkbox ) . "');" ;
			$sql="UPDATE test_mysql SET status = '".(isset($activate)?'Y':'N')."' WHERE id IN $id" ;
			$result = mysql_query($sql) or die(mysql_error());
	}
 
		$sql="SELECT * FROM $tbl_name";
		$result=mysql_query($sql);

		$count=mysql_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Update multiple rows in mysql with checkbox</title>

<script type="text/javascript">
<!--
function un_check(){
	for (var i = 0; i < document.frmactive.elements.length; i++) {
		var e = document.frmactive.elements[i];
		if ((e.name != 'allbox') && (e.type == 'checkbox')) {
		e.checked = document.frmactive.allbox.checked;
		}
	}
}
//-->
</script>

</head>
<body>

	<table width="400" border="0" cellspacing="1" cellpadding="0">
		<tr>
			<td>
				<form name="frmactive" method="post" action="">
						<table width="400" border="0" cellpadding="3" cellspacing="1">
							<tr>
								<td colspan="5"><input name="activate" type="submit" id="activate" value="Activate" />
								<input name="deactivate" type="submit" id="deactivate" value="Deactivate" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="4"><strong>Update multiple rows in mysql with checkbox</strong> </td>
							</tr><tr>
								<td align="center"><input type="checkbox" name="allbox" title="Select or Deselct ALL" style="background-color:#ccc;"/></td>
								<td align="center"><strong>Id</strong></td>
								<td align="center"><strong>Firstname</strong></td>
								<td align="center"><strong>Lastname</strong></td>
								<td align="center"><strong>Status</strong></td>
							</tr>
							<?php
							while($rows=mysql_fetch_array($result)){
							?>
								<tr>
									<td align="center"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $rows['id']; ?>"></td>
									<td><?php echo $rows['id']; ?></td>
									<td><?php echo $rows['name']; ?></td>
									<td><?php echo $rows['lastname']; ?></td>
									<td><?php echo $rows['status']; ?></td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td colspan="5" align="center">&nbsp;</td>
							</tr>
						</table>
				</form>
			</td>
		</tr>
	</table>
</body>
</html>