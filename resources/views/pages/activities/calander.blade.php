@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
    <div class="ms-4 fw-bold fs-2 my-3 d-flex justify-content-between">
        <u class="fs-3 fw-bold">{{ $activity->name }}</u>
    </div>
    <table class="m-4 p-3 border border-dark table w-25">
        <tr>
            <td colspan="2">Index</td>
        </tr>
        <tr>
            <td><span class="d-inline-block border rounded border-dark" style="width:60px;height:20px;background:red;"></span></td>
            <td> Task End Date and Not Completed</td>
        </tr>
        <tr>
            <td><span class="d-inline-block border rounded border-dark" style="width:60px;height:20px;background:green;"></span></td>
            <td> Task End Date and Completed</td>
        </tr>
        <tr>
            <td><span class="d-inline-block border rounded border-dark" style="width:60px;height:20px;background:blue;"></span></td>
            <td> Task Remaining</td>
        </tr>
    </table>
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
