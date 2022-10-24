function projectStatus(data) {
    let icon = "";

    switch (data) {
        case "halted":
            icon +=
                '<div><i class="fa-regular fa-hand text-danger" data-bs-toggle="tooltip" title="Project Halted"></i></div>';
            break;

        case "ongoing":
            icon +=
                '<div><i class="fa-solid fa-bars-progress text-primary" data-bs-toggle="tooltip" title="Ongoing"></i></div>';
            break;

        case "completed":
            icon +=
                '<div><i class="fa-solid fa-check-double text-success" data-bs-toggle="tooltip" title="Finished"></i></div>';
            break;

        case "cancelled":
            icon +=
                '<div><i class="fa-solid fa-ban text-danger" data-bs-toggle="tooltip" title="Cancelled"></i></div>';
            break;

        case "assigned":
            icon +=
                '<div><i class="fa-solid fa-play" data-bs-toggle="tooltip" title="Assigned"></i></div>';
            break;

        default:
            icon +=
                '<div><i class="fa-solid fa-exclamation text-danger" data-bs-toggle="tooltip" title="Error"></i></div>';
            break;
    }
    return icon;
}

function formatDate(date) {
    var currentTime = new Date(date);
    var day = ("0" + currentTime.getDate()).slice(-2);
    var month = ("0" + (currentTime.getMonth() + 1)).slice(-2);

    return currentTime.getFullYear() + "-" + month + "-" + day;
}

function insertTaskCard(table) {
    let count = {
        total: 0,
        overdue: 0,
        completed: 0
    };

    count.total = table.data().count();
    table
        .column(3)
        .data()
        .filter(function (value, index) {
            count.completed += parseInt(value);
        });

    $("#total-tasks").text(count.total);
    $("#completed-tasks").text(count.completed);
    $("#remaining-tasks").text(count.total - count.completed);
}


function animateProgress(value) {
    anime({
        targets: '.progress-bar',
        width: value + "%",
        easing: 'linear',
        duration: 750,
        innerHTML: [0, value],
        round: 100
    });
}