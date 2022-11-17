@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css">

    <div class="d-flex m-3 p-3 flex-column">
        <div id='calendar' class="bg-light rounded p-4"></div>
    </div>
    <script>
        $(document).ready(function() {
            var draggableEl = document.getElementById('mydraggable');
            var calendarEl = document.getElementById('mycalendar');

            var calendarEl = document.getElementById('calendar');

            $.ajax({
                type: "GET",
                url: "../activityDatas/2",
                success: function(response) {
                    var json = $.parseJSON(response);

                    let tasks = [];

                    json.tasks.forEach(element => {
                        tasks.push({
                            title: element.name,
                            start: element.due_date,
                            color: element.status == 1 ? 'green' : 'red'
                        });
                    });
                    makeCalander(tasks);
                },
                dataType: "html"
            });

            function makeCalander(tasks) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    editable: true,
                    selectable: true,
                    dayMaxEvents: true, // allow "more" link when too many events
                    events: tasks,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listYear'
                    },
                });

                calendar.render();
            }

            const uri = 'http://jsonplaceholder.typicode.com/users';

            //new Request(uri)
            //new Request(uri, options)
            //options - method, headers, body, mode
            //methods:  GET, POST, PUT, DELETE, OPTIONS

            //new Headers()
            // headers.append(name, value)
            // Content-Type, Content-Length, Accept, Accept-Language,
            // X-Requested-With, User-Agent
            let h = new Headers();
            h.append('Accept', 'application/json');

            let req = new Request(uri, {
                method: 'POST',
                headers: h,
                mode: 'cors'
            });

            fetch(req)
                .then((response) => {
                    console.log(response);
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('BAD HTTP stuff');
                    }
                })
                .then((jsonData) => {
                    console.log(jsonData);
                })
                .catch((err) => {
                    console.log('ERROR:', err.message);
                });
        });
    </script>
@endsection
