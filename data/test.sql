SELECT t.UserId AS UserId, t.Name AS Name, t.Fonction AS Fonction, t.DeptId AS DeptId, t.Code AS Code, 
(CASE 
    WHEN c.Dates IS NOT NULL THEN c.Dates
    WHEN r.Dates IS NOT NULL THEN r.Dates
    WHEN p.Dates IS NOT NULL THEN p.Dates
    WHEN abs.Dates IS NOT NULL THEN abs.Dates
    WHEN com.Dates IS NOT NULL THEN com.Dates
    WHEN m.Dates IS NOT NULL THEN m.Dates
END) AS Dates
,c.H_conge AS H_conge, r.H_repos AS H_repos, p.H_permission AS H_permission,
abs.H_autoabs AS H_autoabs, com.H_commission AS H_commission, m.H_miseapied AS H_miseapied FROM t_dept_user t 
LEFT JOIN t_h_conge c ON t.UserId=c.UserId AND c.Dates='$StartDateFerie '
LEFT JOIN t_h_repos r ON t.UserId=r.UserId AND r.Dates='$StartDateFerie '
LEFT JOIN t_h_permission p ON t.UserId=p.UserId AND p.Dates='$StartDateFerie '
LEFT JOIN t_h_autoabs abs ON t.UserId=abs.UserId AND abs.Dates='$StartDateFerie '
LEFT JOIN t_h_commission com ON t.UserId=com.UserId AND com.Dates='$StartDateFerie '
LEFT JOIN t_h_miseapied m ON t.UserId=m.UserId AND m.Dates='$StartDateFerie '
WHERE (H_conge IS NOT NULL OR H_repos IS NOT NULL OR H_permission IS NOT NULL OR H_autoabs IS NOT NULL OR H_commission IS NOT NULL OR H_miseapied IS NOT NULL)
GROUP BY t.UserId


SELECT u.UserId, u.Name, u.Foncton, u.DeptId, u.Code, u.Dates,c.H_conge AS H_conge, r.H_repos AS H_repos, p.H_permission AS H_permission,
abs.H_autoabs AS H_autoabs, com.H_commission AS H_commission, m.H_miseapied AS H_miseapied FROM t_dept_user t 
LEFT JOIN t_h_conge c ON t.UserId=c.UserId AND c.Dates='$StartDateFerie '
LEFT JOIN t_h_repos r ON t.UserId=r.UserId AND r.Dates='$StartDateFerie '
LEFT JOIN t_h_permission p ON t.UserId=p.UserId AND p.Dates='$StartDateFerie '
LEFT JOIN t_h_autoabs abs ON t.UserId=abs.UserId AND abs.Dates='$StartDateFerie '
LEFT JOIN t_h_commission com ON t.UserId=com.UserId AND com.Dates='$StartDateFerie '
LEFT JOIN t_h_miseapied m ON t.UserId=m.UserId AND m.Dates='$StartDateFerie '
WHERE (H_conge IS NOT NULL OR H_repos IS NOT NULL OR H_permission IS NOT NULL OR H_autoabs IS NOT NULL OR H_commission IS NOT NULL OR H_miseapied IS NOT NULL)
GROUP BY t.UserId
