@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('myTasks',['type' => 'kanban', 'id' => $activity->id]) }}">Board</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('myTasks',['type' => 'table', 'id' => $activity->id]) }}">Table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('myTasks',['type' => 'calander', 'id' => $activity->id]) }}">Calander</a>
        </li>
    </ul>
    <div class="ms-4 fw-bold fs-2 my-3 d-flex justify-content-between">
        <u class="fs-3 fw-bold">{{ $activity->name }}</u>
        <a class="btn btn-primary float-end me-4"
        href="{{ route('projectDetail', ['id' => $activity->project->id]) }}">Detail</a>

    </div>
    <div class="d-flex m-3 p-3 flex-column">
        <div id='calendar' class="bg-light rounded p-4"></div>
    </div>
    @include('components.task-offcanvas')
    <script>
        $(document).ready(function() {
            var draggableEl = document.getElementById('mydraggable');

            callAjaxCalander({{ $activity->id }});
            $('#goto-task-2').hide();
        });
    </script>
@endsection
