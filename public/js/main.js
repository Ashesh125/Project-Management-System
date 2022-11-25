$(document).ready(function() {

    $('#deleteBtn').on('click', function() {
        let check = confirm("Confirm Delete");
        if (check) {
            $('#name').val("");
            $("#form").submit();
        }
    });

    $(".alert").fadeTo(2000, 500).slideUp(500, function() {
        $(".alert").slideUp(500);
    });


    anime({
        targets: '.row .dashboard-card',
        translateY: 20,
        opacity: 1,
        delay: anime.stagger(100)
    });

    anime({
        targets: '.stats .info-card',
        translateY: 10,
        delay: anime.stagger(100)
    });

});


