@extends('layouts.parent')

@section('title', 'Projects')
@section('project-nav', 'active')

@section('main-content')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('projectCard') }}">Card</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('projects')}}">Table</a>
    </li>
</ul>
    @if(auth()->user()->role != 0)
    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Project Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" class="row g-3 needs-validation" action="{{ route('checkProject') }}"
                        method="POST" novalidate>

                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Project Name</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="0"
                                required>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6" id="userlist-holder">
                            <label for="user_id" class="form-label">Project Lead</label>
                            <select class="form-select w-0" data-live-search="true" id="user_id" name="user_id" required>
                                <option value="0" disabled required selected>Choose...</option>
                                @if($users)
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
        <div class="fw-bold fs-2"><u>Projects</u></div>

        @if(auth()->user()->role != 0)
        <div class="d-flex justify-contents-between my-3">
            <button class="btn btn-primary" data-bs-toggle="modal" id="new"
                data-bs-target="#modal">New</button>
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
                        <th>Lead</th>
                        <th style="width:10%;">Status</th>
                        <th>Description</th>
                        <th>User Id</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($projects))
                        @foreach ($projects as $project)
                            <tr>
                                <td> {{ $project->id }} </td>
                                <td> {{ $project->name }} </td>
                                <td> {{ date('F j Y', strtotime($project->start_date)) }} </td>
                                <td> {{ date('F j Y', strtotime($project->end_date)) }} </td>
                                <td> {{ $project->lead->name }} </td>
                                <td> {{ $project->avg_activities }} </td>
                                <td class="text-truncate" style="max-width: 220px;"> {{ $project->description }} </td>
                                <td> {{ $project->lead->id }}</td>
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

    <script>
        $(document).ready(function() {

            $("#user_id").select2({dropdownParent: '#userlist-holder'});
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
                        data: 'start_date'
                    },
                    {
                        data: 'end_date'
                    },
                    {
                        data: 'lead'
                    },
                    {
                        data: 'completed',
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
                        data: 'description'
                    },
                    {
                        data: 'user_id'
                    },
                    {
                        "targets": 8,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' class='showTaskBtn' href=' {{ route('projectDetail')}}/" +
                                data['id'] + "'>Show Activities</a>";
                        }
                    }

                ],
                "columnDefs": [{
                        "targets": [0,7],
                        "visible": false,
                        "searchable": false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });



            @if(auth()->user()->role != 0)
            $("#new").on("click", function() {
                $('#deleteBtn').show();
                $('#id').val(0);
                $('#name').val("");
                $('#start_date').val("");
                $('#end_date').val("");
                $("#status").val("");

                $('#user_id').val(0);
                $('#user_id').trigger('change');

                $('#description').val("");
                $("#deleteBtn").hide();
                $('#modal').modal('show');
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

                $(".search2-search__field").val(data['lead']);
                $("#deleteBtn").show();
                $('#modal').modal('show');
            });
            @endif
        });
    </script>
@endsection
