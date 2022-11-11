@extends('layouts.parent')

@section('title', 'Project Detail')
@section('project-nav', 'active')

@section('main-content')

    @if (auth()->user()->role != 0)
        <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Activity Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" class="row g-3 needs-validation" action="{{ route('checkActivity') }}"
                            method="POST" novalidate>

                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Activity Name</label>
                                <input type="hidden" class="form-control" id="id" name="id" value="0"
                                    required>
                                <input type="hidden" class="form-control" id="project_id" name="project_id"
                                    value="{{ $project->id }}" required>

                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    min='{{ $project->start_date }}' max='{{ $project->end_date }}' required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    min='{{ $project->start_date }}' max='{{ $project->end_date }}' required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6" id="userlist-holder">
                                <label for="user_id" class="form-label">Supervisor</label>
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
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a description" id="description" name="description"
                                        style="height: 100px" required></textarea>
                                    <label for="fdescription">Description</label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center col-12 ">
                                <button class="btn btn-primary mx-3" id="submitBtn" type="submit">Submit</button>

                                <button class="btn btn-danger mx-3" id="deleteBtn">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex m-3 p-3 flex-column">
        <div class="d-flex justify-content-between">
            <div class="fw-bold fs-2"><u>{{ $project->name }}</u></div>
        </div>
            <div class="d-flex flex-column">
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
                </div>
                <div class="mt-3">Progress :</div>
                <div class="progress col-8 w-100  d-flex my-3">
                    <div class="progress-bar text-end" role="progressbar" style="font-size:12px;width:{{ $project->avg_activities }}%;"
                       aria-valuenow="{{ $project->avg_activities }}" aria-valuemin="0" aria-valuemax="100">{{ $project->avg_activities }}%</div>
                </div>
                <div class="my-2">
                    <div class="fw-bold fs-5">Description</div>
                    <div class="col-12">
                        <textarea class="form-control" placeholder="Leave a description" id="description" name="description"
                            style="height: 100px" required disabled>{{ $project->description }}</textarea>

                    </div>
                </div>
            </div>



        <div class="fw-bold fs-2 mt-3"><u>Activities</u></div>

        @if (auth()->user()->role != 0)
            <div class="d-flex justify-contents-between my-3">
                <button class="btn btn-primary" data-bs-toggle="modal" id="new" data-bs-target="#modal">Add
                    Activity</button>
            </div>
        @endif

        <div>
            <table id="data-table" class="table table-hover table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Supervisor</th>
                        <th style="width:30%;">Description</th>
                        <th>User id</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($project->activities))
                        @foreach ($project->activities as $activity)
                            <tr>
                                <td> {{ $activity->id }} </td>
                                <td> {{ $activity->name }} </td>
                                <td> {{ date('F j Y', strtotime($activity->start_date)) }} </td>
                                <td> {{ date('F j Y', strtotime($activity->end_date)) }} </td>
                                <td> {{ $activity->status }} </td>
                                <td> {!! empty($activity->supervisor->name) ? "<span class='text-danger'>Deleted User</span>" : $activity->supervisor->name !!} </td>
                                <td> {{ $activity->description }} </td>
                                <td> {{ empty($activity->user_id) ? 0 : $activity->user_id }}</td>
                                <td> </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan='8'>No data available !!!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="m-2 mx-4 p-2 rounded activity_detail-holder bg-gray d-flex flex-column">

    </div>
    <script>
        $(document).ready(function() {


            $("#user_id").select2({
                dropdownParent: '#userlist-holder'
            });
            $('.select2-container').addClass('col-12 w-100');

            callAjax({{ $project->id }});
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
                        data: 'start_date'
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
                                return '<div class="progress"><div class="progress-bar text-end" role="progressbar" style="font-size:12px;width:' +
                                    data + '%;" aria-valuenow="' + data +
                                    '" aria-valuemin="0" aria-valuemax="100">' +
                                    data + '%</div></div>';
                            }
                        }
                    },
                    {
                        data: 'supervisor'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'user_id'
                    },
                    {
                        "targets": 8,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' class='showTaskBtn' href=' {{ route('activityDetail') }}/" +
                                data['id'] + "'>Show Tasks</a>";
                        }
                    }

                ],
                "columnDefs": [{
                    "targets": [0,7],
                    "visible": false,
                    "searchable": false
                }],
                order: [
                    [0, 'desc']
                ],
            });


            @if (auth()->user()->role != 0)
                $("#new").on("click", function() {
                    $('#id').val(0);
                    $('#name').val("");
                    $('#user_id').val("0");
                    $('#end_date').val("");
                    $("#status").val(0);
                    $('#type').val('assigned');
                    $('#description').val("");
                    $("#deleteBtn").hide();
                    $('#user_id').val(0);
                    $('#user_id').trigger('change');
                    $("#completeBtn1").hide();
                    $("#undoBtn").hide();
                    $('#modal').modal('show');
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
                     if (data['status'] == 1) {
                        $("#undoBtn").show();
                        $("#completeBtn1").hide();
                    } else {
                        $("#completeBtn1").show();
                        $("#undoBtn").hide();
                    }

                    $("#deleteBtn").show();
                    $('#modal').modal('show');
                });

                $(".complete").on('click', function() {
                    if (confirm("Confirm Completion")) {
                        let status = $("#status").val();
                        $("#status").val(status == 0 ? 1 : 0);
                        $("#form").submit();
                    }
                });


                $(".undo").on('click', function() {
                    if (confirm("Confirm Undo")) {
                        let status = $("#status").val();
                        $("#status").val(status == 0 ? 1 : 0);
                        $("#form").submit();
                    }
                });
            @endif

            anime({
                targets: '.stats .info-card',
                translateY: 20,
                delay: anime.stagger(100)
            });

            $(".progress-bar").on('load', animateProgress({{ $project->avg_task }}));

        });
    </script>
@endsection
