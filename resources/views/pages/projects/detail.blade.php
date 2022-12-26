@extends('layouts.parent')

@section('title', 'Project Detail')
@section('project-nav', 'active')

@section('main-content')

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
                <div class="progress-bar text-end" role="progressbar" style="font-size:12px;width:0%;"
                    aria-valuenow="{{ $project->avg_activities }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $project->avg_activities }}%</div>
            </div>
            <div>
                Project Lead :
                <span class="mx-2">
                    <img src='{{ $project->lead->image ? url('storage/user/' . $project->lead->image) : asset('images/no-user-image.png') }}'
                        width='50px' height='50px' id='profile-circle-{{ $project->lead->id }}'
                        class="rounded-circle img-thumbnail profile-circle border {{ $project->lead->deleted_at ? 'border-danger' : 'border-dark' }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $project->lead->name }}">
                </span>
            </div>
            <div class="my-2">
                <div class="fw-bold fs-5">Description</div>
                <div class="col-12">
                    <textarea class="form-control" placeholder="Leave a description" id="project-description" name="project-description"
                        style="height: 100px" required disabled>{{ $project->description }}</textarea>

                </div>
            </div>
        </div>



        <div class="fw-bold fs-2 mt-3"><u>Activities</u></div>

        @if (auth()->user()->role == 2)
            @include('components.activity-modal')
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
                        <th>Is deleted</th>
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
                                <td> {!! empty($activity->supervisor->name)
                                    ? "<span class='text-danger'>Deleted User</span>"
                                    : $activity->supervisor->name !!} </td>
                                <td> {{ $activity->description }} </td>
                                <td> {{ empty($activity->user_id) ? 0 : $activity->user_id }}</td>
                                <td> {{ $activity->supervisor->deleted_at }}</td>
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

    @include('components.profile-offcanvas')
    <script>
        $(document).ready(function() {


            $("#user_id").select2({
                dropdownParent: '#userlist-holder'
            });
            $('.select2-container').addClass('col-12 w-100');

            callAjax({{ $project->id }});
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
                        data: 'supervisor',
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
                        data: 'description'
                    },
                    {
                        data: 'user_id'
                    },
                    {
                        data: 'deleted_at'
                    },
                    {
                        "targets": 9,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' class='showTaskBtn' href=' {{ route('activityDetail') }}/" +
                                data['id'] + "'>Show Tasks</a>";
                        }
                    }

                ],
                "columnDefs": [{
                    "targets": [0, 7, 8],
                    "visible": false,
                    "searchable": false
                }],
                order: [
                    [0, 'desc']
                ],
            });

            $('#data-table tbody').on('dblclick', 'tr', function() {
                var data = table.row(this).data();
                $('#deleteBtn').show();
                $('#id').val(data['id']);
                $('#name').val(data['name']);
                $('#start_date').val(formatDate(data['start_date']));
                $('#end_date').val(formatDate(data['end_date']));
                $("#status").val(data['status']);

                $('#description').val(data['description']);
                $('#user_id').val(data['user_id']);
                $('#user_id').trigger('change');
                $("#method-type").val("PUT");
                $('#form').attr('action', '/activities/'+$('#id').val());
                $(".search2-search__field").val(data['lead']);
                $("#deleteBtn").show();
                $('#modal').modal('show');
            });

        });
    </script>
@endsection
