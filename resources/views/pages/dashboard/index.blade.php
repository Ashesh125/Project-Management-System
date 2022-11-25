@extends('layouts.parent')

@section('title', 'Home')
@section('home-nav', 'active')

@section('main-content')
<<<<<<< HEAD

=======
>>>>>>> d3651fe (Dashboard Changes for roles)
    <div class="d-flex m-3 p-3 flex-column">
        <div class="d-flex justify-content-between mb-4">
            <div class="fw-bold fs-2"><u>Dashboard</u></div>
            <div class="align-middle">{{ date('F j, Y') }}</div>
        </div>
        <div class="row mx-3">
            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-projects">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Projects</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_projects">
                                    {{ $arr['all_projects'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-boxes-stacked fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-users">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary shadow h-100 py-2 goto-users">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_users">{{ $arr['all_users'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="far fa-id-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-mytasks">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    My Tasks</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_categories">
                                    {{ $arr['all_myTasks'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-issues">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Issues</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_issues">
                                    {{ $arr['all_issues'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-circle-exclamation fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD

        @if (auth()->user()->role != 0)
            @if (!$projects)
                <style>
                    .bg-gray {
                        display: none;
                    }
                </style>
            @endif
            <div class="col-2 mt-4">
                <select class="form-select no-outline" id="project-select" aria-label="Default select example">
                    @forelse ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @empty
                        <option value="0" disabled>NO PROJECTS</option>
                    @endforelse
                </select>
            </div>
            <div class="bg-gray d-flex flex-column">
                <div class="bg-gray d-flex rounded w-100 mt-2 justify-content-between p-2 px-4">
                    <div class="total-tasks info-card w-25">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Start Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="start-date"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                End Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="end-date"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Days Remaining</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="time-remaining"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-2 mx-4 activity_detail-holder bg-gray d-flex flex-column rounded">

                </div>
            </div>




=======


        @if (auth()->user()->role != 0)
            @if (!$projects)
                <style>
                    .bg-gray {
                        display: none;
                    }
                </style>
            @endif
            <div class="col-2 mt-4">
                <select class="form-select no-outline" id="project-select" aria-label="Default select example">
                    @forelse ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @empty
                        <option value="0" disabled>NO PROJECTS</option>
                    @endforelse
                </select>
            </div>
            <div class="bg-gray d-flex flex-column">
                <div class="bg-gray d-flex rounded w-100 mt-2 justify-content-between p-2 px-4">
                    <div class="total-tasks info-card w-25">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Start Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="start-date"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                End Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="end-date"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Days Remaining</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="time-remaining"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-2 mx-4 activity_detail-holder bg-gray d-flex flex-column rounded">

                </div>
                <div class="bg-gray rounded w-75 me-3">
                    <div class="h-100 m-1 p-2">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
>>>>>>> d3651fe (Dashboard Changes for roles)
    </div>



    </div>

    <script>
        var pieChart = null;
        var doughnutChart = null;

        $(document).ready(function() {
            callAjax(1);

            $('#project-select').on('change', function(e) {
                let id = this.value;

                $('.activity_detail-holder').empty();
                pieChart.destroy();
                doughnutChart.destroy();
                callAjax(id);
            });
        });




    </script>
<<<<<<< HEAD
    @else
        <div class="d-flex m-3 p-3 flex-column">
            <div id='calendar' class="bg-light rounded p-4"></div>
        </div>
        @include('components.task-offcanvas');
        <script>
            $(document).ready(function() {
                var draggableEl = document.getElementById('mydraggable');

                callAjaxCalanderUser({{ auth()->user()->id }});
            });
        </script>
=======
@else
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css">
    <div class="col-2 mt-4">
        <select class="form-select no-outline" id="activity-select" aria-label="Default select example">
            @forelse ($activities as $activity)
                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
            @empty
                <option value="0" disabled>NO ACTIVITIES</option>
            @endforelse
        </select>
    </div>
    <div class="d-flex m-3 p-3 flex-column">
        <div id='calendar' class="bg-light rounded p-4"></div>
    </div>
    <script>
        var calander;
        $(document).ready(function() {
            var draggableEl = document.getElementById('mydraggable');
            var calendarEl = document.getElementById('mycalendar');

            var calendarEl = document.getElementById('calendar');

            callActivityAjax(1);

            $('#activity-select').on('change', function(e) {
                let id = this.value;

                callActivityAjax(id);
            });


            function callActivityAjax(id) {
                $.ajax({
                    type: "GET",
                    url: "../api/activityDatas/" + id,
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
            }

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

        });
    </script>
>>>>>>> d3651fe (Dashboard Changes for roles)
    @endif
@endsection
