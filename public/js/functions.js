function projectStatus(data) {
    let icon = "";

    switch (data) {
        case "halted":
            icon +=
                '<div class="d-flex justify-content-center"><i class="fa-regular fa-hand text-danger" data-bs-toggle="tooltip" title="Project Halted"></i></div>';
            break;

        case "ongoing":
            icon +=
                '<div class="d-flex justify-content-center"><i class="fa-solid fa-bars-progress text-primary" data-bs-toggle="tooltip" title="Ongoing"></i></div>';
            break;

        case "completed":
            icon +=
                '<div class="d-flex justify-content-center"><i class="fa-solid fa-check-double text-success" data-bs-toggle="tooltip" title="Finished"></i></div>';
            break;

        case "cancelled":
            icon +=
                '<div class="d-flex justify-content-center"><i class="fa-solid fa-ban text-danger" data-bs-toggle="tooltip" title="Cancelled"></i></div>';
            break;

        default:
            icon +=
                '<div class="d-flex justify-content-center"><i class="fa-solid fa-exclamation text-danger" data-bs-toggle="tooltip" title="Error"></i></div>';
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
