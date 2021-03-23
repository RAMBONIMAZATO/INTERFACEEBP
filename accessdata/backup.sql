SELECT DISTINCT (Checkinout.Userid) AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, Userinfo.Deptid AS DeptId, t_dept_save.Code AS DeptCode, t_dept_save.Effectif AS DeptEff, DateValue(Checkinout.CheckTime) AS Dates
FROM Checkinout, Userinfo, t_dept_save
WHERE (((Userinfo.Deptid)=t_dept_save.DeptId) And ((t_dept_save.Code)<>'BDRJ' And (t_dept_save.Code)<>'CPEJ' And (t_dept_save.Code)<>'CPLJ' And (t_dept_save.Code)<>'LVGJ' And (t_dept_save.Code)<>'MNTJ' And (t_dept_save.Code)<>'MECJ' And (t_dept_save.Code)<>'MROJ' And (t_dept_save.Code)<>'SMPJ' And (t_dept_save.Code)<>'STRJ' And (t_dept_save.Code)<>'DPRJ' And (t_dept_save.Code)<>'FNTJ' And (t_dept_save.Code)<>'GNRJ' And (t_dept_save.Code)<>'ADMJ' And (t_dept_save.Code)<>'STC') And ((Checkinout.Userid)=Userinfo.Userid) And ((DateValue(Checkinout.CheckTime))=(Date())));


SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, Userinfo.Deptid AS DeptId, t_dept_save.Code AS Code, t_dept_save.Effectif AS Effectif, DateValue(Checkinout.CheckTime) AS Dates, TimeValue(Checkinout.CheckTime) AS H_E
FROM Userinfo, t_dept_save, Checkinout
WHERE (((Userinfo.Deptid)=[t_dept_save].[DeptId]) AND ((t_dept_save.Code)<>'STC') AND ((Checkinout.Userid)=[Userinfo].[Userid]) AND ((DateValue([Checkinout].[CheckTime]))=(Date())));


SELECT Userinfo.Userid AS UserId, Userinfo.Name AS Name, Userinfo.Duty AS Fonction, Userinfo.Deptid AS DeptId, t_dept_save.Code AS Code, DateValue(Checkinout.CheckTime) AS Dates, COUNT(Userinfo.Userid) AS Nb_user
FROM Userinfo, t_dept_save, Checkinout
WHERE (((Userinfo.Deptid)=[t_dept_save].[DeptId]) AND ((t_dept_save.Code)<>'STC') AND ((Checkinout.Userid)=[Userinfo].[Userid]) AND ((DateValue([Checkinout].[CheckTime]))=(Date())))
GROUP BY Userinfo.Userid;


SELECT Userinfo.Userid AS UserId, MIN(Userinfo.Name) AS Name, MIN(Userinfo.Duty) AS Fonction, MIN(Userinfo.Deptid) AS DeptId, MIN(t_dept_save.Code) AS Code, MIN(DateValue(Checkinout.CheckTime)) AS Dates, COUNT(Userinfo.Userid) AS Nb_user
FROM Userinfo, t_dept_save, Checkinout
WHERE (((Userinfo.Deptid)=[t_dept_save].[DeptId]) AND ((t_dept_save.Code)<>'STC') AND ((Checkinout.Userid)=[Userinfo].[Userid]) AND ((DateValue([Checkinout].[CheckTime]))=(Date())))
GROUP BY Userinfo.Userid, Userinfo.Name;


SELECT DISTINCT (Checkinout.Userid) AS UserId, 
Userinfo.Name AS Name, 
Userinfo.Duty AS Fonction, 
Userinfo.Deptid AS DeptId, 
t_dept_save.Code AS DeptCode, 
t_dept_save.Effectif AS DeptEff, 
DateValue(Checkinout.CheckTime) AS Dates
FROM Checkinout, Userinfo, t_dept_save
WHERE (
	((Userinfo.Deptid)=t_dept_save.DeptId) And 
	((t_dept_save.Code)<>'BDRJ' And (t_dept_save.Code)<>'CPEJ' And (t_dept_save.Code)<>'CPLJ' And (t_dept_save.Code)<>'LVGJ' And 
	(t_dept_save.Code)<>'MNTJ' And (t_dept_save.Code)<>'MECJ' And (t_dept_save.Code)<>'MROJ' And (t_dept_save.Code)<>'SMPJ' And (t_dept_save.Code)<>'STRJ' And (t_dept_save.Code)<>'DPRJ' 
	And (t_dept_save.Code)<>'FNTJ' And (t_dept_save.Code)<>'GNRJ' And (t_dept_save.Code)<>'ADMJ' And (t_dept_save.Code)<>'STC') And 
	((TimeValue(Checkinout.CheckTime)) Between "05:30:00" And "12:30:00") 
And ((Checkinout.Userid)=Userinfo.Userid) And 
	((DateValue(Checkinout.CheckTime))=Date()));

SELECT DISTINCT (Checkinout.Userid) AS UserId, Userinfo.Name AS Name, DateValue(Checkinout.CheckTime) AS Dates
FROM Checkinout, Userinfo
WHERE (((Userinfo.Userid)=Checkinout.Userid) And ((Userinfo.Deptid)<>65) And ((TimeValue(Checkinout.CheckTime)) Between "05:30:00" And "12:30:00") And ((DateValue(Checkinout.CheckTime))=Date()));

SELECT * FROM Userinfo WHERE ((Userinfo.Deptid)<>65); /*3553*/

SELECT * FROM Checkinout WHERE ((DateValue([Checkinout].[CheckTime]))=Date());

SELECT Userinfo.Userid AS Mat, Userinfo.Name AS Name, Checkinout.Userid AS MatClock, DateValue([Checkinout].[CheckTime]) AS Dates FROM Userinfo, Checkinout WHERE ((([Userinfo].[Userid])=([Checkinout].[Userid])) AND ((Userinfo.Deptid)<>65) AND (DateValue([Checkinout].[CheckTime])=Date()));


SELECT Checkinout.Logid AS Logid, Checkinout.Userid AS Userid, Checkinout.CheckTime AS CheckTime, Format(TimeValue(Checkinout.CheckTime), 'hh:mm:ss') AS H_E FROM Checkinout
WHERE ((DateValue([Checkinout].[CheckTime])=Date()) AND (COUNT(Checkinout.Userid)<>2))


SELECT Checkinout.Logid AS Logid, Checkinout.Userid AS Userid, ANOMALIES_POINTAGE.Name AS Name, ANOMALIES_POINTAGE.Duty AS Fonction, ANOMALIES_POINTAGE.Dept AS Dept, 
DateValue(Checkinout.CheckTime) AS Dates, TimeValue(Checkinout.CheckTime) AS Heures, ANOMALIES_POINTAGE.Nb_Pointage AS Nb_Pointage 
FROM Checkinout,ANOMALIES_POINTAGE 
WHERE (([Checkinout.Userid]=[ANOMALIES_POINTAGE].[Userid]) AND (DateValue([Checkinout].[CheckTime])=[ANOMALIES_POINTAGE].[Dates]) AND ([ANOMALIES_POINTAGE].[Dates]=(Date()-1)))


SELECT Checkinout.Userid, DateValue(Checkinout.CheckTime) AS Dates, TimeValue(Checkinout.CheckTime) AS Heures, ANOMALIES_POINTAGE.Nb_Pointage AS Nb_Pointage 
FROM Checkinout,ANOMALIES_POINTAGE 
WHERE (([Checkinout.Userid]=[ANOMALIES_POINTAGE].[Userid]) AND (DateValue([Checkinout].[CheckTime])=[ANOMALIES_POINTAGE].[Dates]) AND (DateValue([Checkinout].[CheckTime])=(Date()-1)))


UPDATE items t_sous_dept
     SET SousDept = '08:00:00' retail = retail * 0.9
     WHERE id UserId IN (SELECT UserId FROM t_present_jours WHERE Motif='night shift' )
     (SELECT id FROM items
     WHERE retail / wholesale >= 1.3 AND quantity > 100);

     UPDATE t_sous_dept SET SousDept='08:00:00' WHERE UserId=(SELECT UserId FROM t_present_jours WHERE Motif='night shift' AND Dates='2021-02-15');

     UPDATE [table_name] t_sous_dept SET  SousDept [column_name] = '' (SELECT [column_name] FROM [table_name] WHERE [column_name] = [value]) WHERE [column_name] = [value];

     UPDATE t_sous_dept, (SELECT UserId FROM t_present_jours WHERE Motif='night shift' AND Dates='2021-02-15')
        AS discounted
    SET t_sous_dept.SousDept='08:00:00'
    WHERE t_sous_dept.UserId=discounted.UserId;

    UPDATE t_sous_dept SET SousDept='08:00:00' WHERE UserId=(SELECT UserId FROM t_present_jours WHERE Motif='night shift' AND Dates='2021-02-15' AND UserId='20290');

    UPDATE t_sous_dept SET SousDept='07:00:00' WHERE UserId IN (SELECT UserId FROM t_present_jours WHERE Motif='night shift' AND Dates='2021-02-15');


SELECT Checkinout.Logid AS Logid, Checkinout.Userid AS Userid, Checkinout.CheckTime AS CheckTime, Format(TimeValue(Checkinout.CheckTime), 'hh:mm:ss') AS H_E FROM Checkinout
WHERE ((DateValue([Checkinout].[CheckTime])=Date())) HAVING (COUNT(Checkinout.Userid)<>2)

SELECT Userinfo.Userid AS Userid, MIN(Userinfo.Name) AS Name, MIN(Userinfo.Duty) AS Duty, MIN(t_dept_save.Code) AS Dept, Format(MIN(DateValue(Checkinout.CheckTime)),'dd/mm/yyyy') AS Dates, COUNT(Userinfo.Userid) AS Nb_Pointage
FROM Userinfo, t_dept_save, Checkinout
WHERE (((Userinfo.Deptid)=t_dept_save.DeptId) And ((t_dept_save.Code)<>'STC') And ((Checkinout.Userid)=Userinfo.Userid) And ((DateValue(Checkinout.CheckTime))=(Date()-1)))
GROUP BY Userinfo.Userid, Userinfo.Name
HAVING  COUNT(Userinfo.Userid) =3

SELECT * FROM t_dept_user LEFT JOIN t_present_jours ON t_dept_user.UserId=t_present_jours.UserId AND t_present_jours.Dates='2021-03-04' LIMIT 10

SELECT * FROM t_dept_user LEFT JOIN t_present_jours ON t_dept_user.UserId = t_present_jours.UserId AND t_present_jours.Dates =  '2021-03-04' HAVING t_present_jours.Dates IS NULL 
