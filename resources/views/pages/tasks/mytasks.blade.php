@extends('layouts.parent')

@section('title', 'My Tasks')
@section('tasks-nav', 'active')

@section('main-content')
<ul class="nav nav-tabs bg-light">
    <li class="nav-item">
      <a class="nav-link" aria-current="page" href="{{ route('mytasksK') }}">Kanban</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('mytasksT') }}">Table</a>
    </li>
  </ul>
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2 mt-3"><u>My Tasks</u></div>
        <div>
            <table id="data-table" class="table table-success table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th style="width:50%;">Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($user->taskList)
                        @foreach ($user->taskList as $task)
                            {{-- {{ dd($task) }} <tr> --}}
                                <td> {{ $task->id }} </td>
                                <td> {{ $task->project->name }} </td>
                                <td> {{ $task->name }} </td>
                                <td> {{ date('F j, Y', strtotime($task->due_date)) }} </td>
                                <td> {{ $task->status }} </td>
                                <td> {{ $task->type }} </td>
                                <td> {{ $task->description }} </td>
                                <td> </td>
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
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                "pageLength": 10,
                "info": false,
                "bInfo": false,
                "bLengthChange": false,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'project_name'
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
                    },{
                        data: 'type',
                        "render": function(data,type,row,meta){
                            return projectStatus(data);
                        }
                    },
                    {
                        data: 'description'
                    },
                    {
                        "targets": 8,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' class='showTaskBtn' href=' {{ route('projectdetail') }}/" +
                                data['id'] + "'>Show Tasks</a>";
                        }
                    }

                ],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 6,
                        "data": null,
                        "orderable": false,
                        "defaultContent": "<button class='btn btn-primary'>Show Tasks</button>"
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
@endsection
