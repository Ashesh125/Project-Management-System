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
                '<div><i class="fa-solid fa-check-double text-success" data-bs-toggle="tooltip" title="Completed"></i></div>';
            break;

        case "cancelled":
            icon +=
                '<div><i class="fa-solid fa-ban text-danger" data-bs-toggle="tooltip" title="Cancelled"></i></div>';
            break;

        case "assigned":
            icon +=
                '<div><i class="fa-solid fa-hourglass-start" data-bs-toggle="tooltip" title="Assigned"></i></div>';
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
        completed: 0,
    };

    count.total = table.data().count();
    table
        .column(3)
        .data()
        .filter(function (value, index) {
            count.completed += parseInt(value) == 1 ? 1 : 0;
        });

    $("#total-tasks").text(count.total);
    $("#completed-tasks").text(count.completed);
    $("#remaining-tasks").text(count.total - count.completed);
}

function animateProgress(value) {
    anime({
        targets: ".progress-bar",
        width: value + "%",
        easing: "linear",
        duration: 750,
        innerHTML: [0, value],
        round: 100,
    });
}

function activityHandler(datas) {
    datas.forEach((element) => {
        let no_of_issues_remaining =
            parseInt(element.no_of_issues) -
            parseInt(element.no_of_issues_resolved);
        let no_of_tasks_remaining =
            parseInt(element.no_of_tasks) -
            parseInt(element.no_of_tasks_completed);

        let container =
            "<div class='d-flex rounded flex-column my-2 p-4 bg-light w-100' id='" +
            element.id +
            "'><div class='d-flex justify-content-between'><span class='fs-4 fw-bold'> Activity : " +
            element.name +
            "</span><a class='btn btn-primary ms-5' href='/activitydetail/" +
            element.id +
            "'>Detail</a></div><div> Supervisor : " +
            element.supervisor +
            "</div><div> Users Assigned : " +
            element.no_of_users +
            "</div>" +
            "<div class='d-flex justify-content-between'>" +
            "<table class='table table-hover table-striped m-2'>" +
            "<tr><td>No of Tasks</td><td>" +
            element.no_of_tasks +
            "</td></tr>" +
            "<tr><td>Completed Tasks</td><td>" +
            element.no_of_tasks_completed +
            "</td></tr>" +
            "<tr><td>Remaining Tasks</td><td>" +
            no_of_tasks_remaining +
            "</td></tr>" +
            "<caption>Tasks<a class='btn btn-primary float-end' href='/activitydetail/" +
            element.id +
            "'>Detail</a></caption>" +
            "<div class='border border-dark vertical-progress-parent rounded'><div class='vertical-progress-white bg-none rounded px-3' style='height:" +
            (100 - parseInt(element.status)) +
            "%;'></div><div class='vertical-progress rounded bg-primary px-3 text-light' style='height:" +
            element.status +
            "%;'>" +
            element.status +
            "%</div></div>" +
            "</table>" +
            "<div class='m-1 p-2' class='taskChart-holder'>" +
            "<canvas class='taskChart' id='taskChart_" +
            element.id +
            "'></canvas>" +
            "</div>" +
            "<table class='table table-hover table-striped p-2 m-2'>" +
            "<tr><td>No of Issues</td><td>" +
            element.no_of_issues +
            "</td></tr>" +
            "<tr><td>Resolved Issues</td><td>" +
            element.no_of_issues_resolved +
            "</td></tr>" +
            "<tr><td>Remaining Issues</td><td>" +
            no_of_issues_remaining +
            "</td></tr>" +
            "<caption>Issues<a class='btn btn-primary float-end' href='/issues/" +
            element.id +
            "'>Detail</a></caption>" +
            "</table>" +
            "<div class='m-1 p-2' class='issueChart-holder'>" +
            "<canvas class='issueChart' id='issueChart_" +
            element.id +
            "'></canvas>" +
            "</div>" +
            "</div>" +
            "<div class='d-flex justify-content-between'>" +
            "</div>" +
            "</div>";
        $(".activity_detail-holder").append(container);
        circleGarph(
            "issueChart_" + element.id,
            ["Solved", "Remaining"],
            [element.no_of_issues_resolved, no_of_issues_remaining],
            "doughnut"
        );
        circleGarph(
            "taskChart_" + element.id,
            ["Completed", "Remaining"],
            [element.no_of_tasks_completed, no_of_tasks_remaining],
            "pie"
        );
    });

    anime({
        targets: ".vertical-progress-parent .vertical-progress",
        height: function (el) {
            return ["0%", el.innerHtml];
        },
        duration: 2000,
    });
    anime({
        targets: ".vertical-progress-parent .vertical-progress-white",
        height: function (el) {
            return ["100%", el.innerHtml];
        },
        duration: 2000,
    });
}

function callAjax(id) {
    $.ajax({
        type: "GET",
        url: host + "/chartDatas/" + id,
        success: function (response) {
            var json = $.parseJSON(response);
            dateHandler(json.main);
            activityHandler(json.activity_details);
            // issueHandler(json.issues);
            // taskHandler(json.tasks);

            // lineGraph('lineChart', ['jan', 'feb', 'march', 'april', 'may', 'june', 'july',
            //     'aug'
            // ], [
            //     [1, 0, 2, 1, 3, 0, 1],
            //     [15, 20, 12, 15, 10, 40],
            //     [0, 5, 8, 0, 5, 1, 5]
            // ])
        },
        dataType: "html",
    });
}

function dateHandler(datas) {
    $("#start-date").text(datas.start);
    $("#end-date").text(datas.end);
    $("#time-remaining").text(datas.remaining);
}

function circleGarph(target, labels, arr, type) {
    let datas = {
        labels: labels,
        datasets: [
            {
                label: "Dataset 1",
                data: arr,
                backgroundColor: [
                    "rgba(13,110,253,0.6)",
                    "rgba(243, 12, 37, 0.6)",
                ],
                borderColor: "#000000",
            },
        ],
    };

    let config = {
        type: type,
        data: datas,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: target.indexOf("issue") ? "Tasks" : "Issues",
                },
            },
        },
    };

    switch (type) {
        case "pie":
            pieChart = new Chart(
                document.getElementById(target).getContext("2d"),
                config
            );
            break;

        case "doughnut":
            doughnutChart = new Chart(
                document.getElementById(target).getContext("2d"),
                config
            );

            break;
    }
}

function callAjaxCalander(id) {
    $.ajax({
        type: "GET",
        url: host + "/userTaskDatas/" + id,
        success: function (response) {
            var json = $.parseJSON(response);
            let tasks = [];

            json.forEach((element) => {
                tasks.push({
                    id: element.id,
                    title: element.name,
                    start: element.due_date,
                    color:
                        element.type == "completed"
                            ? "lightgreen"
                            : "lightgray",
                    extendedProps: {
                        priority: element.priority,
                        assigned_to: element.description,
                    },
                });
            });
            makeCalander(tasks);
        },
        dataType: "html",
    });
}

function calanderAllTasks(id) {
    $.ajax({
        type: "GET",
        url: host + "/activityDatas/" + id,
        success: function (response) {
            var json = $.parseJSON(response);
            let tasks = [];

            json.tasks.forEach((element) => {
                tasks.push({
                    id: element.id,
                    title: element.name,
                    start: element.due_date,
                    color:
                        element.type == "completed"
                            ? "lightgreen"
                            : "lightgray",
                    extendedProps: {
                        priority: element.priority,
                        assigned_to: "Assigned : " + element.user.name,
                    },
                });
            });
            makeCalander(tasks);
        },
        dataType: "html",
    });
}

function makeCalander(tasks) {
    var calendar = new FullCalendar.Calendar(
        document.getElementById("calendar"),
        {
            selectable: true,
            editable: false,
            events: tasks,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,listYear",
            },
            eventContent: function (arg, createElement) {
                let main = document.createElement("div");
                main.innerHTML = arg.event.title;
                // $(main).addClass('text-light');
                let block1 = document.createElement("div");
                block1.innerHTML = arg.event.extendedProps.assigned_to;
                $(block1).addClass("font-sm text-truncate");
                let block2 = document.createElement("span");
                $(block2).addClass("badge rounded-pill");

                if (arg.event.extendedProps.priority == 2) {
                    $(block2).addClass("bg-danger");
                    $(block2).text("Urgent");
                } else if (arg.event.extendedProps.priority == 1) {
                    $(block2).addClass("bg-primary");
                    $(block2).text("Normal");
                } else {
                    $(block2).addClass("bg-gray");
                    $(block2).text("Low");
                }

                return { domNodes: [main, block1, block2] };
            },
            eventClick: function (info) {
                var bsOffcanvas = new bootstrap.Offcanvas(
                    document.getElementById("offcanvas")
                );
                bsOffcanvas.show();

                callTaskAjax(info.event.id);

            },
        }
    );

    calendar.render();
}

function callTaskAjax(id){
    $.ajax({
        type: "GET",
        url: host + "/taskDatas/" + id,
        success: function (response) {
            var json = $.parseJSON(response);
            $("#task-id").val(json.id);
            $("#task-name").val(json.name);
            $("#task-activity").val(json.activity.name);
            $("#task-user").val(json.user.name);
            $("#task-due-date").val(json.due_date);
            $("#task-description").val(json.description);
            $("#task-type").val(json.type);
            $("#task-status").val(
                json.status == 1
                    ? "Verified"
                    : json.status == 2
                    ? "Invalid"
                    : "Unverified"
            );
            $("#goto-task").attr(
                "href",
                host + "/mytasks/kanban/" + json.activity.id
            );

            $("#goto-task-2").attr(
                "href",
                host + "/activitydetail/" + json.activity.id
            );
        },
        dataType: "html",
    });
}


function callAjaxCalanderUser(id) {
    $.ajax({
        type: "GET",
        url: host + "/userTaskDatasAll/" + id,
        success: function (response) {
            var json = $.parseJSON(response);
            let tasks = [];

            json.forEach((element) => {
                tasks.push({
                    id: element.id,
                    title: element.name,
                    start: element.due_date,
                    color:
                        element.type == "completed"
                            ? "lightgreen"
                            : "lightgray",
                    extendedProps: {
                        priority: element.priority,
                        assigned_to: "In : " + element.activity.name,
                    },
                });
            });
            makeCalander(tasks);
        },
        dataType: "html",
    });
}

function updateTaskType(id, type) {
    $.ajax({
        method: "POST",
        url: host + "/tasks/updateType",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: id,
            type: type,
        },
    }).done(function (data) {
        // console.log("done");
    });
}
