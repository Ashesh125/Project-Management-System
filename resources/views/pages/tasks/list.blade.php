@extends('layouts.parent')

@section('title', 'Activity Detail')
@section('project-nav', 'active')

@section('main-content')

    @if (auth()->user()->role != 0)
        <div class="modal fade" id="new-task-modal" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Task Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" class="row g-3 needs-validation" action="{{ route('checkTask') }}"
                            method="POST" novalidate>

                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Task Name</label>
                                <input type="hidden" class="form-control" id="id" name="id" value="0"
                                    required>
                                <input type="hidden" class="form-control" id="activity_id" name="activity_id"
                                    value="{{ $activity->id }}" required>
                                <input type="hidden" class="form-control" id="status" name="status" value="0"
                                    required>

                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6" id="userlist-holder">
                                <label for="user_id" class="form-label">Assigned To</label>
                                <select class="form-select w-0" data-live-search="true" id="user_id" name="user_id"
                                    required>
                                    <option value="0" disabled required selected>Choose...</option>
                                    @if ($users)
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid User.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label col-12">Status</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option selected value="assigned"><i class="fa-solid fa-hourglass-start"></i> Assigned
                                    </option>
                                    <option selected value="ongoing"><i class="fa-solid fa-bars-progress"></i>Ongoing
                                    </option>
                                    <option selected value="completed"><i class="fa-solid fa-check-double">Completed
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date"
                                    max="{{ $activity->end_date }}" min="{{ $activity->start_date }}" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="status" class="form-label">Status</label>
                                <div class="d-flex">
                                    <div class="form-check mx-2"><input class="form-check-input" type="radio"
                                            value='2' name="status" id="status2">
                                        <label class="form-check-label" for="status2">
                                            Not Completed
                                        </label>
                                    </div>
                                    <div class="form-check mx-2"><input class="form-check-input" type="radio"
                                            value='1' name="status" id="status1">
                                        <label class="form-check-label" for="status1">
                                            Completed
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="status" id="status0"
                                            value='' checked>
                                        <label class="form-check-label" for="status0">
                                            Unverified
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a description" id="description" name="description"
                                        style="height: 100px" required></textarea>
                                    <label for="description">Description</label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center col-12 ">
                                <button class="btn btn-primary mx-3" id="submitBtn" type="submit">Submit</button>
                                <button class="btn btn-danger mx-3" id="deleteBtn" type="button">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2 my-3 d-flex justify-content-between">
            <u class="fs-3 fw-bold">{{ $activity->name }}</u>
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
                                                {{ $activity->start_date }}</div>
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
                                                {{ $activity->end_date }}</div>
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
                <div class="progress-bar text-end" role="progressbar"
                    style="font-size:12px;width:0%;" aria-valuenow="{{ $activity->status }}"
                    aria-valuemin="0" aria-valuemax="100">{{ $activity->status }}%</div>
            </div>
            <div>
                Supervisor :
                <span class="mx-2">
                    <img src='{{ $activity->supervisor ? url('storage/user/' . $activity->supervisor->image) : asset('images/no-user-image.png') }}'
                        width='50px' height='50px' id='profile-circle-{{ $activity->supervisor->id }}'
                        class="rounded-circle img-thumbnail profile-circle" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="{{ $activity->supervisor->name }}">
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
                            <img src='{{ $task->user ? url('storage/user/' . $task->user->image) : asset('images/no-user-image.png') }}'
                                width='50px' height='50px' id='profile-circle-{{ $task->user->id }}'
                                class="mx-1 rounded-circle img-thumbnail profile-circle" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="{{ $task->user->name }}" data-bs-toggle="offcanvas">
                        @endif
                    @endforeach
                </span>
            </div>
            <div class="my-2">
                <div class="fw-bold fs-5">Description</div>
                <div class="col-12">
                    <textarea class="form-control" placeholder="Leave a description" id="description" name="description"
                        style="height: 100px" required disabled>{{ $activity->description }}</textarea>

                </div>
            </div>
        </div>

        <div class="fw-bold fs-2 mt-3"><u>Tasks</u></div>

        @if (auth()->user()->role != 0)
            <div class="d-flex justify-contents-between my-3">
                <button class="btn btn-primary" data-bs-toggle="modal" id="new"
                    data-bs-target="#new-task-modal">Add
                    Task</button>
                <a class="btn btn-primary mx-2" href="{{ route('activityCalander',['id' => $activity->id]) }}" id="calander-btn">
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
                        <th style="width:50%;">Description</th>
                        <th>Assigned</th>
                        <th>User Id</th>
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
                                <td> {{ $task->description }} </td>
                                <td> {!! empty($task->user->name) ? "<span class='text-danger'>Deleted User</span>" : $task->user->name !!} </td>
                                <td> {{ empty($task->user->id) ? 0 : $task->user->id }} </td>
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

            $('.profile-circle').on('click', function() {
                var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvas'));
                bsOffcanvas.show();

                let id = $(this).attr('id').split("-")[2];

                $.ajax({
                    type: "GET",
                    url: "../userDatas/"+id,
                    success: function(response) {
                        var json = $.parseJSON(response);
                        $("#profile-name").val(json.name);
                        $("#profile-email").val(json.email);
                        let image = json.image ? '{{ url('storage/user/') }}/'+json.image : "{{ asset('images/no-user-image.png') }}";
                        $("#profile-mail").attr('href', "mailto:" + json.email);
                        $("#profile-image").attr('src', image);
                        $("#profile-role").val(json.role == 2 ? 'Super Admin' : json.role == 1 ?
                            'Admin' : 'User');
                    },
                    dataType: "html"
                });
            });

            $("#user_id").select2({
                dropdownParent: '#userlist-holder'
            });
            $('.select2-container').addClass('col-12 w-100');

            var table = $('#data-table').DataTable({
                "pageLength": 10,
                "info": false,
                "bInfo": false,
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
                            return projectStatus(data);
                        }
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'user'
                    },
                    {
                        data: 'user_id'
                    }

                ],
                "columnDefs": [{
                    "targets": [0, 7],
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
                $("#new").on("click", function() {
                    $('#id').val(0);
                    $('#name').val("");
                    $('#user_id').val(0);
                    $('#user_id').trigger('change');
                    $('#end_date').val("");
                    $("#status").val(0);
                    $('#type').val('assigned');
                    $('#description').val("");
                    $("#deleteBtn").hide();
                    $("#completeBtn1").hide();
                    $("#undoBtn").hide();
                    $('#new-task-modal').modal('show');
                });


                $('#data-table tbody').on('dblclick', 'tr', function() {
                    var data = table.row(this).data();
                    $('#deleteBtn').show();
                    $('#id').val(data['id']);
                    $('#name').val(data['name']);
                    $('#due_date').val(formatDate(data['end_date']));
                    $("#status").val(data['status']);
                    $('#description').val(data['description']);
                    $('#type').val(data['type']);

                    $('#user_id').val(data['user_id']);
                    $('#user_id').trigger('change');


                    $("#status" + data['status']).prop('checked', true);
                    $("#deleteBtn").show();
                    $('#new-task-modal').modal('show');
                });
            @endif

        });
    </script>
@endsection
