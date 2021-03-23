<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<h2>Embedding YouTube Videos</h2>
<p>Embedding YouTube videos in modals requires additional JavaScript/jQuery:</p>

<!-- Buttons -->
<div class="btn-group">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videoModal" data-video="https://www.youtube.com/embed/lQAUq_zs-XU">Launch Video 1</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videoModal" data-video="https://www.youtube.com/embed/pvODsb_-mls">Launch Video 2</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videoModal" data-video="https://www.youtube.com/embed/4m3dymGEN5E">Launch Video 3</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videoModal" data-video="https://www.youtube.com/embed/uyw0VZsO3I0">Launch Video 4</button>
</div>

<!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark border-dark">
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body bg-dark p-0">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
$(document).ready(function() {
    // Set iframe attributes when the show instance method is called
    $("#videoModal").on("show.bs.modal", function(event) {
        let button = $(event.relatedTarget); // Button that triggered the modal
        let url = button.data("video");      // Extract url from data-video attribute
        $(this).find("iframe").attr({
            src : url,
            allow : "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        });
    });

    // Remove iframe attributes when the modal has finished being hidden from the user
    $("#videoModal").on("hidden.bs.modal", function() {
        $("#videoModal iframe").removeAttr("src allow");
    });
});
</script>

</body>
</html>

<!-- 
                            /*SELECT DISTINCT A.DeptId, A.Code, A.Effectif,A.Nb_pres,A.Nb_abs, (A.p_abs) AS P_abs, c.C, cm.CM, aa.AA,p.P, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, A.Dates
                            FROM t_abs A
                            LEFT JOIN conge c ON A.DeptId = c.DeptId AND A.Dates=c.Dates
                            LEFT JOIN conge_mat cm ON A.DeptId = cm.DeptId AND A.Dates=cm.Dates
                            LEFT JOIN abs_auto aa ON A.DeptId = aa.DeptId AND A.Dates=aa.Dates
                            LEFT JOIN permission p ON A.DeptId = p.DeptId AND A.Dates=p.Dates
                            LEFT JOIN comission com ON A.DeptId = com.DeptId AND A.Dates=com.Dates
                            LEFT JOIN suspendu sus ON A.DeptId = sus.DeptId AND A.Dates=sus.Dates
                            LEFT JOIN rep_med rm ON A.DeptId = rm.DeptId AND A.Dates=rm.Dates
                            LEFT JOIN hospitalise h ON A.DeptId = h.DeptId AND A.Dates=h.Dates
                            LEFT JOIN recup rp ON A.DeptId = rp.DeptId AND A.Dates=rp.Dates
                            LEFT JOIN miseapied m ON A.DeptId = m.DeptId AND A.Dates=m.Dates
                            WHERE A.Dates = DATE( NOW( ) ) 
                            GROUP BY A.DeptId*/
                            /*SELECT DISTINCT A.DeptId, A.Code, A.Effectif,A.Nb_pres,A.Nb_abs, (A.p_abs) AS P_abs, c.C, cm.CM, aa.AA, com.Com, sus.Susp, rm.RM, rp.Recup, h.HP, m.MAP, A.Dates
                            FROM t_abs A
                            LEFT JOIN conge c ON A.DeptId = c.DeptId
                            LEFT JOIN conge_mat cm ON A.DeptId = cm.DeptId
                            LEFT JOIN abs_auto aa ON A.DeptId = aa.DeptId
                            LEFT JOIN comission com ON A.DeptId = com.DeptId
                            LEFT JOIN suspendu sus ON A.DeptId = sus.DeptId
                            LEFT JOIN rep_med rm ON A.DeptId = rm.DeptId
                            LEFT JOIN hospitalise h ON A.DeptId = h.DeptId
                            LEFT JOIN recup rp ON A.DeptId = rp.DeptId
                            LEFT JOIN miseapied m ON A.DeptId = m.DeptId
                            WHERE A.Dates = DATE( NOW( ) ) 
                            GROUP BY A.DeptId*/ 




                           /* $insert_h_e="
                            INSERT INTO t_h_travail(UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie, P_entree, P_sortie, H_travail)
                            SELECT UserId, Name, Fonction, DeptId, Code, Effectif, Dates, H_entree, H_sortie,
                            (CASE
                               WHEN Code='ADM' THEN '08:00:00'
                               ELSE '06:30:00'
                            END) AS P_entree,
                            (CASE
                               WHEN Code='ADM' THEN '16:00:00'
                               ELSE '17:00:00'
                            END) AS P_sortie,
                            H_travail
                            FROM t_h_e_s WHERE Dates BETWEEN '2020-08-01' AND '2020-09-08'
                                ";*/



                                
                                            /*
                                            SELECT t_dept_user.UserId, t_dept_user.Name, t_dept_user.Fonction, t_dept_user.DeptId, t_dept_user.Code, t_dept_user.Effectif, t_present_jours.Dates
                                            FROM t_present_jours
                                            RIGHT JOIN t_dept_user ON t_present_jours.UserId = t_dept_user.UserId
                                            WHERE t_present_jours.Dates IS NULL 
                                            */
                            -->