@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
    <div class="ms-4 fw-bold fs-2 my-3 d-flex justify-content-between">
        <u class="fs-3 fw-bold">{{ $activity->name }}</u>
    </div>

    <div class="d-flex m-3 p-3 flex-column">
        <div id='calendar' class="bg-light rounded p-4"></div>
    </div>
    @include('components.task-offcanvas')
    <script>
        $(document).ready(function() {
            var draggableEl = document.getElementById('mydraggable');

            calanderAllTasks({{ $activity->id }});
            $('#goto-task').hide();
        });
    </script>
@endsection
