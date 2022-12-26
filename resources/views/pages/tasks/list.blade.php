@extends('layouts.parent')

@section('title', 'Activity Detail')
@section('project-nav', 'active')

@section('main-content')

    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2 my-3 d-flex justify-content-between">
            <u class="fs-3 fw-bold activity-name" id="activity-{{ $activity->id }}">{{ $activity->name }}</u>
            <div>
                <a class="btn btn-danger" href="{{ route('issues', $activity->id) }}">Issues</a>
                <a class="btn btn-primary" href="{{ route('projectDetail', $activity->project->id) }}">Back</a>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="bg-gray d-flex flex-column rounded">
                <div class="bg-gray d-flex rounded w-100 mt-2 justify-content-between p-2 px-4 flex-wrap">
                    <div class="total-tasks info-card w-25 mx-2">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Start Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="start-date">
                                                {{ date('F j, Y', strtotime($activity->start_date)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25 mx-2">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                End Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="end-date">
                                                {{ date('F j, Y', strtotime($activity->end_date)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25 mx-2">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Days Remaining</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="time-remaining">
                                                {{ Carbon\Carbon::parse($activity->start_date)->diffInDays($activity->end_date) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-tasks info-card w-25 mx-2">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Total</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-tasks"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="completed-tasks info-card w-25 mx-2">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Completed</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="completed-tasks">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="remaining-tasks info-card w-25 mx-2">
                        <div class="my-2 dashboard-card">
                            <div
                                class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger  shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mr-2 d-flex justify-content-between">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                Remaining</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="remaining-tasks">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">Progress :</div>
            <div class="progress col-8 w-100  d-flex my-3">
                <div class="progress-bar text-end" role="progressbar" style="font-size:12px;width:0%;"
                    aria-valuenow="{{ $activity->status }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $activity->status }}%</div>
            </div>
            <div>
                Supervisor :
                <span class="mx-2">
                    <img src='{{ $activity->supervisor->image ? url('storage/user/' . $activity->supervisor->image) : asset('images/no-user-image.png') }}'
                        width='50px' height='50px' id='profile-circle-{{ $activity->supervisor->id }}'
                        class="rounded-circle img-thumbnail profile-circle border {{ $activity->supervisor->deleted_at ? 'border-danger' : 'border-dark' }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $activity->supervisor->name }}">
                </span>
            </div>
            <div class="my-3">
                Assigned :
                <span class="ms-3">
                    @php
                        $user = [];
                    @endphp
                    @foreach ($activity->tasks as $task)
                        @if (!in_array($task->user->id, $user))
                            @php
                                $user[] = $task->user->id;
                            @endphp
                            <img src='{{ $task->user->image ? url('storage/user/' . $task->user->image) : asset('images/no-user-image.png') }}'
                                width='50px' height='50px' id='profile-circle-{{ $task->user->id }}'
                                class="mx-1 rounded-circle img-thumbnail profile-circle border {{ $task->user->deleted_at ? 'border-danger' : 'border-dark' }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $task->user->name }}"
                                data-bs-toggle="offcanvas">
                        @endif
                    @endforeach
                </span>
            </div>
            <div class="my-2">
                <div class="fw-bold fs-5">Description</div>
                <div class="col-12">
                    <textarea class="form-control" placeholder="Leave a description" id="activity-description" name="activity-description"
                        style="height: 100px" required disabled>{{ $activity->description }}</textarea>

                </div>
            </div>
        </div>

        <div class="fw-bold fs-2 mt-3"><u>Tasks</u></div>

        @if (auth()->user()->role != 0)
            @include('components.task-modal')
            <div class="d-flex justify-contents-between my-3">
                <button class="btn btn-primary" data-bs-toggle="modal" id="new"
                    data-bs-target="#new-task-modal">Add
                    Task</button>
                <a class="btn btn-primary mx-2" href="{{ route('activityCalander', ['id' => $activity->id]) }}"
                    id="calander-btn">
                    Goto Calander</a>
            </div>
        @endif

        <div>
            <table id="data-table" class="table table-hover table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th style="width:50%;">Description</th>
                        <th>Assigned</th>
                        <th>User Id</th>
                        <th>Is Deleted</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($activity->tasks)
                        @foreach ($activity->tasks as $task)
                            <tr>
                                <td> {{ $task->id }} </td>
                                <td> {{ $task->name }} </td>
                                <td> {{ date('F j, Y', strtotime($task->due_date)) }} </td>
                                <td> {{ $task->status }} </td>
                                <td> {{ $task->type }} </td>
                                <td> {{ $task->priority }} </td>
                                <td> {{ $task->description }} </td>
                                <td> {!! empty($task->user->name) ? "<span class='text-danger'>Deleted User</span>" : $task->user->name !!} </td>
                                <td> {{ empty($task->user->id) ? 0 : $task->user->id }} </td>
                                <td> {{ $task->user->deleted_at }} </td>
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

    @include('components.profile-offcanvas')

    <script>
        $(document).ready(function() {



            $("#user_id").select2({
                dropdownParent: '#userlist-holder'
            });
            $('.select2-container').addClass('col-12 w-100');

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
                        data: 'end_date'
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row, meta) {

                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                if (data == 1) {
                                    return '<div><i class="fa-regular fa-circle-check text-success"></i></div>';
                                } else {
                                    return '<div><i class="fa-regular fa-circle-xmark text-danger"></i></div>';
                                }
                            }
                        }
                    }, {
                        data: 'type',
                        "render": function(data, type, row, meta) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                return projectStatus(data);
                            }
                        }
                    }, {
                        data: 'priority',
                        "render": function(data, type, row, meta) {

                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                return data == 2 ?
                                    '<span class="badge rounded-pill bg-danger">Urgent</span>' :
                                    data == 1 ?
                                    '<span class="badge rounded-pill bg-primary">Normal</span>' :
                                    '<span class="badge rounded-pill bg-gray">Low</span>';
                            }
                        }
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'user',
                        "render": function(data, type, row, meta) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                return row.deleted_at == "" ? data : data +
                                    ' ( <i class="fa-solid fa-user-slash text-danger"></i> )';
                            }
                        }
                    },
                    {
                        data: 'user_id'
                    }, {
                        data: 'deleted_at'
                    }

                ],
                "columnDefs": [{
                    "targets": [0, 8, 9],
                    "visible": false,
                    "searchable": false
                }],
                order: [
                    [0, 'desc']
                ],
                "initComplete": function(settings, json) {

                }
            });
            insertTaskCard(table);


            @if (auth()->user()->role != 0)

                $('#data-table tbody').on('dblclick', 'tr', function() {
                    var data = table.row(this).data();
                    $('#deleteBtn').show();
                    $('#id').val(data['id']);
                    $('#name').val(data['name']);
                    $('#due_date').val(formatDate(data['end_date']));
                    $("#status" + data['status']).attr('checked', true);
                    $("#priority" + data['priority']).attr('checked', true);
                    $('#description').val(data['description']);
                    $('#type').val(data['type']);

                    $('#user_id').val(data['user_id']);
                    $('#user_id').trigger('change');
                    $("#method-type").val("PUT");
                    $('#form').attr('action', '/tasks/'+$('#id').val());

                    $("#status" + data['status']).prop('checked', true);
                    $("#deleteBtn").show();
                    $('#new-task-modal').modal('show');
                });
            @else
                $('#data-table tbody').on('dblclick', 'tr', function() {
                    window.location.href = host+"/mytasks/kanban/"+$('.activity-name').attr('id').split("-")[1];
                });

            @endif

        });
    </script>
@endsection
