<!DOCTYPE html>
<html>
<head>
<title>ShotDev.Com Tutorial</title>
</head>
<body>
<?php 
$objConnect = odbc_connect("mydatabase"," "," ");

//*** Update Condition ***//
if($_GET["Action"] == "Save")
{
	for($i=1;$i<=$_POST["hdnLine"];$i++)
	{
		$strSQL = "UPDATE customer SET ";
		$strSQL .="CustomerID = '".$_POST["txtCustomerID$i"]."' ";
		$strSQL .=",Name = '".$_POST["txtName$i"]."' ";
		$strSQL .=",Email = '".$_POST["txtEmail$i"]."' ";
		$strSQL .=",CountryCode = '".$_POST["txtCountryCode$i"]."' ";
		$strSQL .=",Budget = '".$_POST["txtBudget$i"]."' ";
		$strSQL .=",Used = '".$_POST["txtUsed$i"]."' ";
		$strSQL .="WHERE CustomerID = '".$_POST["hdnCustomerID$i"]."' ";
		$objQuery = odbc_exec($objConnect,$strSQL);
	}
	header("location:$_SERVER[PHP_SELF]");
	exit();
}

$strSQL = "SELECT * FROM customer";
$objExec = odbc_exec($objConnect, $strSQL) or die ("Error Execute [".$strSQL."]");
?>
<form name="frmMain" method="post" action="php_access_multiple_update.php?Action=Save">
<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">CustomerID </div></th>
    <th width="98"> <div align="center">Name </div></th>
    <th width="198"> <div align="center">Email </div></th>
    <th width="97"> <div align="center">CountryCode </div></th>
    <th width="59"> <div align="center">Budget </div></th>
    <th width="71"> <div align="center">Used </div></th>
  </tr>
<?php 
	$i=0;
	while($objResult = odbc_fetch_array($objExec)){
		$i=$i+1;
?>
  <tr>
    <td><div align="center">
	<input type="hidden" name="hdnCustomerID<?=$i;?>" size="5" value="<?=$objResult["CustomerID"];?>">
	<input type="text" name="txtCustomerID<?=$i;?>" size="5" value="<?=$objResult["CustomerID"];?>">
	</div></td>
    <td><input type="text" name="txtName<?=$i;?>" size="20" value="<?=$objResult["Name"];?>"></td>
    <td><input type="text" name="txtEmail<?=$i;?>" size="20" value="<?=$objResult["Email"];?>"></td>
    <td><div align="center"><input type="text" name="txtCountryCode<?=$i;?>" size="2" value="<?=$objResult["CountryCode"];?>"></div></td>
    <td align="right"><input type="text" name="txtBudget<?=$i;?>" size="5" value="<?=$objResult["Budget"];?>"></td>
    <td align="right"><input type="text" name="txtUsed<?=$i;?>" size="5" value="<?=$objResult["Used"];?>"></td>
  </tr>
<?php 
	}
?>
</table>
  <input type="submit" name="submit" value="submit">
  <input type="hidden" name="hdnLine" value="<?=$i;?>">
</form>
<?php
	odbc_close($objConnect);
?>
</body>
</html>
<!--- This file download from www.shotdev.com -->