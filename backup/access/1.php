<!DOCTYPE html>
<html>
<head>
<title>PHP isset() example</title>
</head>
<body>

<form method="post">

<!-- Enter value1 :<input type="text" name="str1"><br/>
Enter value2 :<input type="text" name="str2"><br/> -->
<input type="submit" value="Sum" name="Submit1"><br/><br/>

<?php
if(isset($_POST["Submit1"]))
{
/*$sum=$_POST["str1"] + $_POST["str2"];*/
/*echo "The sum = ". $sum;*/
	echo "string";

}
?>

</form>
</body>
</html>


    <!--

		INSERT INTO t_user_dept(UserId, Name, Fonction, DeptId, Code, Effectif)
		SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, t_dept_save.DeptId AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif
		FROM Userinfo, t_dept_save
		WHERE (((t_dept_save.Code)<>'STC') And ((Userinfo.Deptid)=t_dept_save.DeptId))
		 -->
<!--
INSERTION TABLE DEPT SAVE IN MS ACCESS
		INSERT INTO t_dept_save(DeptId, Code, Effectif) 
		SELECT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((Dept.DeptName)<>'STC' And (Dept.DeptName)<>'MKLEN INTERNATIONAL'))
		GROUP BY Dept.Deptid 		
 -->
 <!-- INSERT INTO t_user_dept(UserId, Name, Fonction, DeptId, Code, Effectif) 	
    SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, t_dept_save.DeptId AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif
	FROM Userinfo, t_dept_save
	WHERE (((t_dept_save.Code)<>'STC') And ((Userinfo.Deptid)=t_dept_save.DeptId)); -->


	<!-- SELECT DISTINCT Dept.Deptid AS DeptId, Min(Dept.DeptName) AS Code, Count(Userinfo.Userid) AS Effectif
		FROM Userinfo INNER JOIN Dept ON Userinfo.Deptid=Dept.Deptid
		WHERE (((t_dept_save.Code)<>'BDRJ') AND ((t_dept_save.Code)<>'CPEJ') AND ((t_dept_save.Code)<>'CPLJ') AND ((t_dept_save.Code)<>'LVGJ') AND ((t_dept_save.Code)<>'MNTJ') AND ((t_dept_save.Code)<>'MECJ') AND ((t_dept_save.Code)<>'MROJ') AND ((t_dept_save.Code)<>'SMPJ') AND ((t_dept_save.Code)<>'STRJ') AND ((t_dept_save.Code)<>'DPRJ') AND ((t_dept_save.Code)<>'FNTJ') AND ((t_dept_save.Code)<>'GNRJ') AND ((t_dept_save.Code)<>'ADMJ')  AND ((t_dept_save.Code)<>'STC') And ((Dept.DeptName)<>('MKLEN INTERNATIONAL')))
		GROUP BY Dept.Deptid -->