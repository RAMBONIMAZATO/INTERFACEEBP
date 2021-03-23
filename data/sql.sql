SELECT * FROM `t_motif` WHERE UserId='21265' AND (Dates BETWEEN '2020-11-18' AND '2020-11-22')

SELECT * FROM t_dept_user

SELECT DISTINCT * FROM t_h_travail WHERE Dates =  '2020-12-29'

SELECT * FROM t_motif WHERE Dates='2020-12-29' AND Obs='conge'

SELECT DISTINCT Obs FROM t_motif

SELECT * FROM t_motif WHERE Obs='miseapied' AND Dates='2020-12-29'

SELECT * FROM t_motif WHERE Obs='repos medical' AND Dates='2020-12-29'

SELECT * FROM t_motif WHERE Obs='permission' AND Dates='2020-12-29'

SELECT * FROM t_motif WHERE Obs='comission' AND Dates='2020-12-29'

SELECT * FROM t_motif WHERE Obs='absence autorise' AND Dates='2020-12-29'

SELECT * FROM t_motif WHERE Obs='recuperation' AND Dates='2020-12-29'

SELECT UserId, Name, DeptId, Code, Dates, Obs, (CASE WHEN Obs='conge' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='conge' AND Dates='2020-12-07'

SELECT t.UserId, t.Name, t.DeptId, t.Code, t.Dates, m.Obs, (CASE WHEN m.Obs='conge' THEN '08:00:00' END) AS H_travail_motif, t.H_travail FROM t_h_travail t INNER JOIN t_motif m 
ON t.UserId =m.UserId WHERE m.Obs='conge' AND t.Dates='2020-12-07'


SELECT * FROM `t_motif` WHERE Dates='2020-12-07' AND Obs='conge'

SELECT * FROM `t_h_travail` WHERE UserId='24963' AND Dates='2020-12-07'

/*heures conge*/
/*INSERT INTO h_conge(UserId, Name, DeptId, Code, Dates, H_conge)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='conge' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='conge' AND Dates='2020-11-23'*/

INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_conge)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='conge' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='conge' AND Dates='2020-11-23'


INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_repos)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='repos medical' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='repos medical' AND Dates='2020-11-23'

INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_permission)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='permission' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='permission' AND Dates='2020-11-23'

INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_autoabs)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='absence autorise' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='absence autorise' AND Dates='2020-11-23'

INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_commission)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='comission' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='comission' AND Dates='2020-11-23'

INSERT INTO t_jours_nuit(UserId, Name, DeptId, Code, Dates, H_miseapied)
SELECT UserId, Name, DeptId, Code, Dates , (CASE WHEN Obs='miseapied' THEN '08:00:00' END) AS H_travail_motif  FROM t_motif  WHERE Obs='miseapied' AND Dates='2020-11-23'
/*fin heures conge*/

INSERT INTO t_semaine_jours_nuit(UserId, Name, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_semaine_jours, H_semaine_nuit, H_conge,H_repos, H_permission, H_autoabs, H_commission, H_miseapied)
            SELECT UserId, Name,DeptId,Code, MIN( Dates ) AS Dates_debut, MAX( Dates ) AS Dates_fin, ABS( DATEDIFF( MIN( Dates ) , MAX( Dates ) ) ) AS Nb_jours, WEEK( Dates ) AS Num_semaine, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_jours ) ) ) AS H_semaine_jours,SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_nuit) ) ) AS H_semaine_nuit,SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_conge) ) ) AS H_conge, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_repos) ) ) AS H_repos, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_permission) ) ) AS H_permission, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_autoabs) ) ) AS H_autoabs, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_commission) ) ) AS H_commission, SEC_TO_TIME( SUM(DISTINCT TIME_TO_SEC( H_miseapied) ) ) AS H_miseapied
            FROM t_jours_nuit WHERE (Dates BETWEEN  '2020-11-23' AND  '2020-11-28') GROUP BY UserId, Name

INSERT INTO t_h_supp(UserId, Name, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_jours, H_nuit, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied, H_ferie, H_dimanche)
SELECT t.UserId, t.Name, t.DeptId, t.Code, t.Dates_debut, t.Dates_fin, t.Nb_jours, t.Num_semaine, t.H_semaine_jours AS H_jours, t.H_semaine_nuit AS H_nuit, t.H_conge AS H_conge, t.H_repos AS H_repos, t.H_permission AS H_permission, t.H_autoabs AS H_autoabs, t.H_commission AS H_commission, t.H_miseapied AS H_miseapied, 
f.H_travail AS H_ferie, d.H_travail AS H_dimanche
FROM t_semaine_jours_nuit t
LEFT JOIN t_h_ferie f ON t.UserId=f.UserId AND f.Dates='2020-11-23'
LEFT JOIN t_h_dimanche d ON t.UserId=d.UserId AND d.Dates='2020-11-29'
WHERE t.Num_semaine BETWEEN WEEK('2020-11-23') AND WEEK('2020-11-28')
GROUP BY t.UserId,t.Name


INSERT INTO t_h_supp(UserId, Name, DeptId, Code, Dates_debut, Dates_fin, Nb_jours, Num_semaine, H_jours, H_nuit, H_conge, H_repos, H_permission, H_autoabs, H_commission, H_miseapied, H_ferie, H_dimanche)
SELECT t.UserId, t.Name, t.DeptId, t.Code, t.Dates_debut, t.Dates_fin, t.Nb_jours, t.Num_semaine, t.H_semaine_jours AS H_jours, t.H_semaine_nuit AS H_nuit, t.H_conge AS H_conge, t.H_repos AS H_repos, t.H_permission AS H_permission, t.H_autoabs AS H_autoabs, t.H_commission AS H_commission, t.H_miseapied AS H_miseapied, 
f.H_travail AS H_ferie, d.H_travail AS H_dimanche
FROM t_semaine_jours_nuit t
LEFT JOIN t_h_ferie f ON t.UserId=f.UserId AND f.Dates='2020-11-23'
LEFT JOIN t_h_dimanche d ON t.UserId=d.UserId AND d.Dates='2020-11-29'
WHERE t.Num_semaine BETWEEN WEEK('2020-11-23') AND WEEK('2020-11-28')
GROUP BY t.UserId,t.Name

SELECT UserId, (CASE WHEN THEN sec_to_time(time_to_sec(H_jours+H_commission-H_autoabs)) WHEN 
THEN END) FROM `t_h_supp` WHERE 1

SELECT (CASE WHEN H_commission IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs))  WHEN H_autoabs IS NULL THEN SEC_TO_TIME( TIME_TO_SEC( H_jours+H_commission)) WHEN H_commission IS NULL AND H_autoabs IS NULL THEN H_jours ELSE SEC_TO_TIME( TIME_TO_SEC( H_jours + H_commission - H_autoabs ) ) 
END) FROM  `t_h_supp`

UPDATE t_h_supp SET H_total=(CASE WHEN H_commission IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs))  WHEN H_autoabs IS NULL THEN SEC_TO_TIME( TIME_TO_SEC( H_jours+H_commission)) WHEN H_commission IS NULL AND H_autoabs IS NULL THEN H_jours ELSE SEC_TO_TIME( TIME_TO_SEC( H_jours + H_commission - H_autoabs ) ) 
END)

UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_conge IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs+H_repos+H_permission+H_commission-H_miseapied))
	WHEN H_conge IS NULL AND H_repos IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs+H_permission+H_commission-H_miseapied))
	WHEN H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs+H_commission-H_miseapied))
	WHEN H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_commission-H_miseapied))
	WHEN H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_miseapied))
	WHEN H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL THEN H_jours 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission+H_commission-H_miseapied))
END)


UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_conge IS NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs+H_repos+H_permission+H_commission-H_miseapied))
	WHEN (H_conge IS NULL AND H_repos IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs+H_permission+H_commission-H_miseapied))
	WHEN (H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_autoabs+H_commission-H_miseapied))
	WHEN (H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_commission-H_miseapied))
	WHEN (H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours-H_miseapied))
	WHEN (H_repos IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_permission+H_commission-H_miseapied))
	WHEN (H_repos IS NULL AND H_permission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_commission-H_miseapied))
	WHEN (H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_commission-H_miseapied))
	WHEN (H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_miseapied))
	WHEN (H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
	WHEN (H_permission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_commission-H_miseapied))
	WHEN (H_permission IS NULL AND H_autoabs IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos+H_commission-H_miseapied))
	WHEN (H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos-H_miseapied))
	WHEN (H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos))
	WHEN (H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL AND H_repos IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
	WHEN (H_autoabs IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos+H_permission+H_commission-H_miseapied))
	WHEN (H_autoabs IS NULL AND H_commission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos+H_permission-H_miseapied))
	WHEN (H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos+H_permission))
	WHEN (H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL AND H_permission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos))
	WHEN (H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL AND H_permission IS NULL AND H_repos IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
	WHEN (H_commission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission-H_miseapied)) 
	WHEN (H_commission IS NULL AND H_miseapied IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission))
	WHEN (H_commission IS NULL AND H_miseapied IS NULL AND H_autoabs IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos+H_permission))
	WHEN (H_commission IS NULL AND H_miseapied IS NULL AND H_autoabs IS NULL AND H_permission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos))
	WHEN (H_commission IS NULL AND H_miseapied IS NULL AND H_autoabs IS NULL AND H_permission IS NULL AND H_repos IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
	WHEN (H_miseapied IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission+H_commission))
	WHEN (H_miseapied IS NULL  AND H_commission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission))
	WHEN (H_miseapied IS NULL  AND H_commission IS NULL AND H_autoabs IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos+H_permission))
	WHEN (H_miseapied IS NULL  AND H_commission IS NULL AND H_autoabs IS NULL AND H_permission IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos))
	WHEN (H_miseapied IS NULL  AND H_commission IS NULL AND H_autoabs IS NULL AND H_permission IS NULL AND H_repos IS NULL) THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
	WHEN H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL THEN H_jours 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission+H_commission-H_miseapied))
END)

H_jours-H_autoabs+H_repos+H_permission+H_commission-H_miseapied
H_jours-H_autoabs+H_permission+H_commission-H_miseapied
H_jours-H_autoabs+H_commission-H_miseapied
H_jours+H_commission-H_miseapied
H_jours-H_miseapied
H_jours 
H_jours+H_conge-H_autoabs+H_permission+H_commission-H_miseapied
H_jours+H_conge-H_autoabs+H_commission-H_miseapied
H_jours+H_conge+H_commission-H_miseapied
H_jours+H_conge-H_miseapied
H_jours+H_conge
H_jours+H_conge-H_autoabs+H_repos+H_commission-H_miseapied
H_jours+H_conge+H_repos+H_commission-H_miseapied
H_jours+H_conge+H_repos-H_miseapied
H_jours+H_conge+H_repos
H_jours+H_conge
H_jours+H_conge+H_repos+H_permission+H_commission-H_miseapied
H_jours+H_conge+H_repos+H_permission-H_miseapied
H_jours+H_conge+H_repos+H_permission
H_jours+H_conge+H_repos
H_jours+H_conge
H_jours+H_conge-H_autoabs+H_repos+H_permission-H_miseapied
H_jours+H_conge-H_autoabs+H_repos+H_permission
H_jours+H_conge+H_repos+H_permission
H_jours+H_conge+H_repos
H_jours+H_conge
H_jours+H_conge-H_autoabs+H_repos+H_permission+H_commission
H_jours+H_conge-H_autoabs+H_repos+H_permission
H_jours+H_conge+H_repos+H_permission
H_jours+H_conge+H_repos
H_jours+H_conge
H_jours+H_conge-H_autoabs+H_repos+H_permission+H_commission-H_miseapied

/*MISE A JOURS HEURES TOTALES*/
UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_conge IS NULL AND H_repos IS NULL AND H_permission IS NULL AND H_autoabs IS NULL AND H_commission IS NULL AND H_miseapied IS NULL THEN H_jours
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge-H_autoabs+H_repos+H_permission+H_commission-H_miseapied))
END) 

/*UPDATE t_h_supp SET H_total=(CASE 
	WHEN THEN 
	END)
WHERE H_total IS NULL */
UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_conge IS NULL THEN H_jours
	WHEN H_jours IS NULL THEN H_conge 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
END) 

UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_repos IS NULL AND H_conge IS NULL THEN H_jours
	WHEN H_repos IS NULL AND H_conge IS NOT NULL THEN H_total
	WHEN H_total IS NULL AND H_conge IS NULL THEN H_repos
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge+H_repos))
END) 


UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_repos IS NULL THEN H_total
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_repos))
END) WHERE H_conge IS NULL



/*test mety */

/*UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_conge IS NULL THEN H_jours
	WHEN H_jours IS NULL THEN H_conge 
        WHEN H_jours IS NOT NULL AND H_conge IS NOT NULL THEN SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
END) */
UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_conge IS NULL THEN H_jours
	WHEN H_jours IS NULL THEN H_conge 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_jours+H_conge))
END) 

UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_repos IS NULL THEN H_total
	WHEN H_total IS NULL THEN H_repos 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_repos))
END) 

UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_permission IS NULL THEN H_total
	WHEN H_total IS NULL THEN H_permission 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_permission))
END) 

UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_autoabs IS NULL THEN H_total
	WHEN H_total IS NULL THEN -H_autoabs 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_total-H_autoabs))
END)


UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_commission IS NULL THEN H_total
	WHEN H_total IS NULL THEN H_commission 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_total+H_commission))
END)

UPDATE t_h_supp SET H_total=(CASE 
	WHEN H_miseapied IS NULL THEN H_total
	WHEN H_total IS NULL THEN -H_miseapied 
	ELSE SEC_TO_TIME(TIME_TO_SEC(H_total-H_miseapied))
END)


UPDATE t_h_supp SET H_normale='40:00:00'

UPDATE t_h_supp SET H_brut=(CASE WHEN H_total>H_normale THEN TIMEDIFF(H_total, H_normale) END)


UPDATE t_h_supp SET H30='08:00:00'

UPDATE t_h_supp SET HS30=(CASE 
WHEN (H_brut>H30) THEN H30
WHEN (H_brut<H30) THEN H_brut
END)
WHERE H_brut IS NOT NULL


UPDATE t_h_supp SET H50='12:00:00'


UPDATE t_h_supp SET HS50=(CASE 
WHEN (H_total>H_normale AND TIMEDIFF(H_total, H_normale)>H30 AND TIMEDIFF(TIMEDIFF(H_total, H30), H_normale)<H50) THEN TIMEDIFF(TIMEDIFF(H_total, H30), H_normale)
WHEN (H_total>H_normale AND TIMEDIFF(H_total, H_normale)>H30 AND TIMEDIFF(TIMEDIFF(H_total, H30), H_normale)>H50) THEN H50  
END)

UPDATE t_h_supp SET H60='60:00:00'

UPDATE t_h_supp SET HS60=(CASE 
WHEN (H_total>H60) THEN TIMEDIFF(H_total, H60)
END)

UPDATE t_h_supp SET H_abs=(CASE WHEN H_total<H_normale THEN ABS(TIMEDIFF(H_total, H_normale))  END)

UPDATE t_h_supp SET Nb_jours=(CASE WHEN H_dimanche IS NULL THEN Nb_jours+1 ELSE Nb_jours+2 END)
/*fin test*/