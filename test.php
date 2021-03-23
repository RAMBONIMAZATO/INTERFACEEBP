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