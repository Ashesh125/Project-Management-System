@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"
                href="{{ route('myTasks', ['type' => 'kanban', 'id' => $activity->id]) }}">Board</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('myTasks', ['type' => 'table', 'id' => $activity->id]) }}">Table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('myTasks', ['type' => 'calander', 'id' => $activity->id]) }}">Calander</a>
        </li>
    </ul>
    <div class="d-flex m-3 p-3 flex-column">
        <h2>{{ $activity->name }}</h2>
        <div class="fs-2 my-3 d-flex justify-content-between">
            <div>
                <u class="fw-bold ">My Tasks</u>
                <span class="float-end fs-6 align-text-bottom h-100 pt-3 ms-3 timer-info"> Changes will be Saved in <span
                        class="count-down">5</span>
                    <span><a href="#" onclick="window.location.reload();">Cancel</a></span>
                </span>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('issues', $activity->id) }}">Issues</a>
            </div>
        </div>
        <div>
            <div class="kanban-main d-flex col-12 px-5 justify-content-between">
                <div class="col-4 me-2 task-holder d-flex flex-column bg-gray rounded" id="assigned-task-holder">
                    <div class="kanban-title bg-dimgary p-3 rounded-top text-light w-100">To Do</div>
                    @foreach ($tasks as $task)
                        @if ($task->type == 'assigned')
                            <div class="m-2 mx-4 dashboard-card task-card" id="task-{{ $task->id }}">
                                <div
                                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-gray shadow h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="mr-2 d-flex justify-content-between">
                                                <div class="text-xs fw-bold text-uppercase">
                                                    {{ $task->name }}</div>
                                                <div class="h5 mb-0 fw-bold text-gray-800 task-detail" id="taskdetail-1">
                                                    <i class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ $task->description }}"></i>
                                                </div>
                                            </div>
                                            <div>Due Date : {{ date('F j, Y', strtotime($task->due_date)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="col-4 mx-2 task-holder d-flex flex-column bg-gray rounded" id="ongoing-task-holder">
                    <div class="kanban-title bg-primary p-3 rounded-top text-light w-100">Ongoing</div>
                    @foreach ($tasks as $task)
                        @if ($task->type == 'ongoing')
                            <div class="m-2 mx-4 dashboard-card task-card" id="task-{{ $task->id }}">
                                <div
                                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="mr-2 d-flex justify-content-between">
                                                <div class="text-xs fw-bold text-uppercase">
                                                    {{ $task->name }}</div>
                                                <div class="h5 mb-0 text-gray-800 task-detail" id="taskdetail-4"><i
                                                        class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ $task->description }}"></i></div>
                                            </div>
                                            <div>Due Date : {{ date('F j, Y', strtotime($task->due_date)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
                <div class="col-4 ms-2 task-holder d-flex flex-column bg-gray rounded" id="completed-task-holder">
                    <div class="kanban-title bg-success p-3 rounded-top text-light w-100">Completed</div>
                    @foreach ($tasks as $task)
                        @if ($task->type == 'completed')
                            <div class="m-2 mx-4 dashboard-card task-card" id="task-{{ $task->id }}">
                                <div
                                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="mr-2 d-flex justify-content-between">
                                                <div class="text-xs fw-bold text-uppercase">
                                                    {{ $task->name }}</div>
                                                <div class="h5 mb-0 text-gray-800 task-detail" id="taskdetail-4"><i
                                                        class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ $task->description }}"></i></div>
                                            </div>
                                            <div>Due Date : {{ date('F j, Y', strtotime($task->due_date)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('components.task-offcanvas')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            var i = 4;
            var myInterval,updatePostTimeout;

            $(".task-card").draggable({
                helper: 'clone'
            });

            $('.timer-info').hide();
            $('.task-card').on('click', function(event) {
                var bsOffcanvas = new bootstrap.Offcanvas(
                    document.getElementById("offcanvas")
                );
                bsOffcanvas.show();

                callTaskAjax($(this).attr('id').split("-")[1]);
            });

            $(".task-card").on("drag", function(event, ui) {
                let id = $(event.target).attr("id");
            });


            $('#goto-task-2').hide();

            $(".task-holder").droppable({
                hoverClass: "drop-hover",
                drop: function(event, ui) {
                    clearInterval(myInterval);
                    clearTimeout(updatePostTimeout);



                    i = 4;
                    $('.timer-info').show();
                    let dragged = ui.draggable.attr('id');
                    let dropable = $(this).attr('id');
                    $("#" + dragged).appendTo("#" + dropable);
                    $("#" + dragged).css('position', '');
                    $("#" + dragged).find('ul').append(ui.draggable);



                    myInterval = setInterval(function() {
                        i != -1 ? $('.count-down').text(i--) : $('.timer-info').hide();
                    }, 1000);

                    updatePostTimeout = setTimeout(() => { clearInterval(myInterval); updateTaskType(dragged.match(/\d+/)[0], dropable.split("-")[0]);  $('.timer-info').hide();}, 5000);


                    // stopFunction();
                }
            });


            anime({
                targets: '.task-holder .task-card',
                translateY: 20,
                delay: anime.stagger(100)
            });

            anime({
                targets: '.kanban-main .task-holder',
                opacity: 1,
                duration: 1500,
                delay: anime.stagger(100)
            });

        });
    </script>
@endsection
