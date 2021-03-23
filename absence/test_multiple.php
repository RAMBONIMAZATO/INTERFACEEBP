<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php  
$objConnect = odbc_connect("mklen","","");  
  
//*** Update Condition ***//  
if($_GET["Action"] == "Save")  
{  
	for($i=1;$i<=$_POST["hdnLine"];$i++)  
	{  
		$strSQL = "UPDATE t_dept_save SET ";  
		$strSQL .="DeptId = '".$_POST["txtDeptId$i"]."' ";  
		$strSQL .=",Code = '".$_POST["txtCode$i"]."' ";  
		$strSQL .=",Effectif = '".$_POST["txtEffectif$i"]."' ";
		$strSQL .="WHERE DeptId = '".$_POST["hdnDeptId$i"]."' ";  
		$objQuery = odbc_exec($objConnect,$strSQL);  
	}  
//header("location:$_SERVER[PHP_SELF]");  
//exit();  
}  
  
	$strSQL = "SELECT * FROM t_dept_save";  
	$objExec = odbc_exec($objConnect, $strSQL) or die ("Error Execute [".$strSQL."]");  
?>  
<form name="frmMain" method="post" action="test_multiple.php?Action=Save">  
	<table width="600" border="1">  
		<tr>  
			<th width="91"> <div align="center">DeptId </div></th>  
			<th width="98"> <div align="center">Code </div></th>  
			<th width="198"> <div align="center">Effectif </div></th>  
		</tr>  
		<?php  
		$i =0;  
		while($objResult = odbc_fetch_array($objExec))  
		{  
		$i = $i + 1;  
		?>  
		<tr>  
			<td><div align="center">  
			<input type="hidden" name="hdnDeptId<?=$i;?>" size="5" value="<?=$objResult["DeptId"];?>">  
			<input type="text" name="txtDeptId<?=$i;?>" size="5" value="<?=$objResult["DeptId"];?>">  
			</div></td>  
			<td><input type="text" name="txtCode<?=$i;?>" size="20" value="<?=$objResult["Code"];?>"></td>  
			<td><input type="text" name="txtEffectif<?=$i;?>" size="20" value="<?=$objResult["Effectif"];?>"></td>  
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