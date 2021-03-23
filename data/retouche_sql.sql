SELECT DISTINCT Dates FROM `t_h_travail` WHERE Dates BETWEEN '2020-12-28' AND '2021-01-03' 28 29 03 - 30[29, 30] 31[30, 31] 01[31, 01] 02[01,02]

/*UPDATE Userinfo SET Userinfo.Plage_E=(CASE 
WHEN ((Userinfo.[Deptid])='32') THEN '08:00:00' 
ELSE ('07:00:00') 
END), Userinfo.Plage_S =(CASE 
WHEN ((Userinfo.[Deptid])='32') THEN '16:45:00' 
ELSE  ('15:45:00') 
END), Userinfo.Pause='00:45:00'
WHERE (((Userinfo.[Deptid])<>'65'));*/
UPDATE Userinfo SET Userinfo.Plage_E = IIf((((Userinfo.Deptid)=32)),#12/30/1899 8:0:0#,#12/30/1899 7:0:0#), Userinfo.Plage_S = IIf((((Userinfo.Deptid)=32)),#12/30/1899 16:45:0#,#12/30/1899 15:45:0#), Userinfo.Pause = #12/30/1899 0:45:0#
WHERE (((Userinfo.[Deptid])<>65));


SELECT * FROM `t_h_e_s` WHERE Dates='2021-01-01' ORDER BY UserId

SELECT DISTINCT Dates FROM `t_h_nuit` WHERE Dates BETWEEN '2020-12-28' AND '2021-01-03'