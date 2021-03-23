<?php

$link = mysql_connect('localhost', 'username', 'password');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br />';
mysql_select_db ("db", $link);

$tbl_name = "dani_1";


if($_POST['Submit'])
{
    foreach($_POST['id'] as $id)
    {
        $sql1="UPDATE ".$tbl_name." SET status=1, name='".$_POST["name".$id]."' WHERE id='".$id."'";
        //$sql1="UPDATE ".$tbl_name." SET name='".$_POST["name".$id]."' WHERE id='".$id."'";
        $result1=mysql_query($sql1,$link);
    }
    if($result1){
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=updatemultiple.php\">";
    }
}
else
{
	$sql="SELECT * FROM $tbl_name";
	$result=mysql_query($sql,$link);

	?>

	<strong>Update multiple rows in mysql</strong><br>
	<table width="500" border="0" cellspacing="1" cellpadding="0">
		<tr>
			<td>
				<form name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<table width="500" border="0" cellspacing="1" cellpadding="0">
				<tr>
					<td><strong>Id</strong></td>
					<td><strong>Status</strong></td>
					<td><strong>Name</strong></td>
				</tr>

				<?php
				while($rows=mysql_fetch_array($result))
				{
				?>
					<tr>
					<td><?php echo $rows['id']; ?></td>
					<td ><input name="id[]" type="checkbox" id="status<?php echo $rows['id']; ?>" value="<?php echo $rows['id']; ?>"
					<?php if ($rows['status'] ==1) { echo " checked";} else {} ?>></td>
					<td><input name="name<?php echo $rows['id']; ?>" type="text" id="name<?php echo $rows['id']; ?>" value="<?php echo $rows['name']; ?>"></td>
					</tr>
				<?php
				}
				?>
					<tr>
						<td colspan="3" align="center"><input type="submit" name="Submit" value="Submit"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	<?php
}
mysql_close($link);
?>