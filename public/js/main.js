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

});


