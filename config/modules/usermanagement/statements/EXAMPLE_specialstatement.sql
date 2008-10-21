SELECT ent_umgtuser.* FROM ent_umgtuser
INNER JOIN cmp_application2user ON ent_umgtuser.UserID = cmp_application2user.UserID
INNER JOIN ent_umgtapplication ON cmp_application2user.AppsID = ent_umgtapplication.AppsID
WHERE ent_umgtapplication.AppsID = '1'
ORDER BY DisplayName ASC
LIMIT 1;