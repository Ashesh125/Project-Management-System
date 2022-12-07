@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" aria-current="page"
                href="{{ route('myTasks', ['type' => 'kanban', 'id' => $activity->id]) }}">Board</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('myTasks', ['type' => 'table', 'id' => $activity->id]) }}">Table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('myTasks', ['type' => 'calander', 'id' => $activity->id]) }}">Calander</a>
        </li>
    </ul>
    <div class="d-flex m-3 p-3 flex-column">
        <h2>{{ $activity->name }}      <a class="btn btn-primary float-end"
            href="{{ route('projectDetail', ['id' => $activity->project->id]) }}">Detail</a>
    </h2>
        <div class="fw-bold fs-2 my-3 d-flex justify-content-between">
            <u>My Tasks</u>
            <div>
                <a class="btn btn-danger" href="{{ route('issues', $activity->id) }}">Issues</a>
            </div>
        </div>
        <div>
            <table id="data-table" class="table table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th style="width:50%;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($tasks)
                        @foreach ($tasks as $task)
                            <tr>
                                <td> {{ $task->id }} </td>
                                <td> {{ $task->name }} </td>
                                <td> {{ date('F j, Y', strtotime($task->due_date)) }} </td>
                                <td> {{ $task->status }} </td>
                                <td> {{ $task->type }} </td>
                                <td> {{ $task->description }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan='7'>No Tasks Available !!!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('components.task-offcanvas')
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                "pageLength": 10,

                "bLengthChange": false,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'due_date'
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row, meta) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                if (data == 0) {
                                    return '<div class="text-center"><i class="fa-regular fa-circle-xmark text-danger"></i></div>';
                                } else {
                                    return '<div class="text-center"><i class="fa-regular fa-circle-check text-success"></i></div>';
                                }
                            }
                        }
                    }, {
                        data: 'type',
                        "render": function(data, type, row, meta) {
                            return projectStatus(data);
                        }
                    },
                    {
                        data: 'description'
                    }

                ],
                "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
                order: [
                    [0, 'desc']
                ],
            });



            $('#data-table tbody').on('dblclick', 'tr', function() {
                var bsOffcanvas = new bootstrap.Offcanvas(
                    document.getElementById("offcanvas")
                );
                bsOffcanvas.show();
                var data = table.row(this).data();
                callTaskAjax(data['id']);
            });

        });
    </script>
@endsection
