<!DOCTYPE html>
<html>  
<head>  
<title>TEST MS ACCESS</title>  
</head>  
<body>  
<form action="insert2.php" name="frmAdd" method="post">  
<table width="600" border="1">  
<tr>  
<th width="91"> <div align="center">CustomerID </div></th>  
<th width="160"> <div align="center">Name </div></th>  
<th width="198"> <div align="center">Email </div></th>  
<th width="97"> <div align="center">CountryCode </div></th>  
<th width="70"> <div align="center">Budget </div></th>  
<th width="70"> <div align="center">Used </div></th>  
</tr>  
<tr>  
<td><div align="center"><input type="text" name="txtCustomerID" size="5"></div></td>  
<td><input type="text" name="txtName" size="20"></td>  
<td><input type="text" name="txtEmail" size="20"></td>  
<td><div align="center"><input type="text" name="txtCountryCode" size="2"></div></td>  
<td align="right"><input type="text" name="txtBudget" size="5"></td>  
<td align="right"><input type="text" name="txtUsed" size="5"></td>  
</tr>  
</table>  
<input type="submit" name="submit" value="submit">  
</form>  
</body>  
</html>  