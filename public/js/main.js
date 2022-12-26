$(document).ready(function () {


    $("#restoreBtn").on("click", function () {
        let check = confirm("Confirm Restore");
        if (check) {
            $("#restore").val("1");
            $("#form").submit();
        }
    });

    $(".alert")
        .fadeTo(2000, 500)
        .slideUp(500, function () {
            $(".alert").slideUp(500);
        });

    anime({
        targets: ".row .dashboard-card",
        translateY: 20,
        opacity: 1,
        delay: anime.stagger(100),
    });

    anime({
        targets: ".stats .info-card",
        translateY: 10,
        delay: anime.stagger(100),
    });

    anime({
        targets: ".comment-area .comment",
        opacity: 1,
        duration: 1500,
        delay: anime.stagger(100),
    });

    $(".progress-bar").on(
        "load",
        animateProgress($(".progress-bar").attr("aria-valuenow"))
    );

    $(".profile-circle").on("click", function () {
        var bsOffcanvas = new bootstrap.Offcanvas(
            document.getElementById("offcanvas")
        );
        bsOffcanvas.show();

        let id = $(this).attr("id").split("-")[2];

        $.ajax({
            type: "GET",
            url: host + "/userDatas/" + id,
            success: function (response) {
                var json = $.parseJSON(response);
                $("#profile-name").val(json.name);
                $("#profile-email").val(json.email);
                let image = json.image
                    ? host + "/storage/user/" + json.image
                    : host + "/images/no-user-image.png";
                $("#profile-mail").attr("href", "mailto:" + json.email);
                $("#profile-image").attr("src", image);
                $("#profile-role").val(
                    json.role == 2
                        ? "Super Admin"
                        : json.role == 1
                        ? "Admin"
                        : "User"
                );
                console.log(json);
                if (json.deleted_at != null) {
                    $("#profile-msg").val("This User has been Removed");
                    $("#profile-msg").addClass("text-danger");
                } else {
                    $("#profile-msg").attr("type", "hidden");
                }
            },
            dataType: "html",
        });
    });

    $('#task-type').on("change", function() {
        updateTaskType($('#task-id').val(), $('#task-type').val());

        window.location.reload();
    });

    $('.activity-card').on('click', function() {
        let id = $(this).attr('id');
        window.location.href = host+"/activitydetail/" + id;
    })

    $(".issue-card").on("click", function () {
        let id = $(this).attr("id");
        window.location.href = host + "/issues/" + id;
    });

    anime({
        targets: ".project-cards .project-card",
        opacity: 1,
        translateY: 20,
        duration: 1500,
        delay: anime.stagger(100),
    });
});
