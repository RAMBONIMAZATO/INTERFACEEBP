<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php  
		$objConnect = odbc_connect("mklen", "", "");
		if ($_GET["Action"]=="Save") {
			for ($i=0; $i <=$_POST["hdnLine"] ; $i++) { 
				$strSQL="UPDATE t_h_jours SET ";
				$strSQL="Name='".$_POST["txtName"]."'";
				$strSQL=",Fonction='".$_POST["txtFonction"]."'";
				$strSQL="WHERE UserId='".$_POST["txtUserId$i"]."'";
				$objQuery=odbc_exec($objConnect, $strSQL);
			}
		}
		$strSQL = "SELECT * FROM t_h_jours";  
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
	<?  
	$i =0;  
	while($objResult = odbc_fetch_array($objExec))  
	{  
	$i = $i + 1;  
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
	<?  
	}  
	?>  
	</table>  
	<input type="submit" name="submit" value="submit">  
	<input type="hidden" name="hdnLine" value="<?=$i;?>">  
</form>  
<?  
odbc_close($objConnect); 
?>
</body>
</html>