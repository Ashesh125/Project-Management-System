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
    <script>
        $(document).ready(function() {
            var draggableEl = document.getElementById('mydraggable');

            callAjaxCalander({{ $activity->id }});
        });
    </script>
@endsection
