@extends('layouts.parent')

@section('title', 'Projects')
@section('project-nav', 'active')

@section('main-content')
    <!-- Modal -->
    <div class="modal fade" id="new-project-modal" data-bs-backdrop="static" data-bs-keyboard="false"
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

    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Projects</u></div>
        <div class="d-flex justify-contents-between my-3">
            <button class="btn btn-primary" data-bs-toggle="modal" id="new"
                data-bs-target="#new-project-modal">New</button>
        </div>
        <div>
            <table id="data-table" class="table table-success table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th style="width:50%;">Description</th>
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
                                <td> {{ $project->avg_task }} </td>
                                <td> {{ $project->description }} </td>
                                <td> </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan='7'>No data available !!!</td>
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
                        data: 'name'
                    },
                    {
                        data: 'start_date'
                    },
                    {
                        data: 'end_date'
                    },
                    {
                        data: 'completed',
                        "render": function(data, type, row, meta) {
                            return '<div class="progress"><div class="progress-bar text-end" role="progressbar" style="font-size:12px;width:' +
                                data + '%;" aria-valuenow="' + data +
                                '" aria-valuemin="0" aria-valuemax="100">' +
                                data + '%</div></div>';

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
                        "defaultContent": "<button class='btn btn-primary'>Show Tasks</button>"
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });



            $("#new").on("click", function() {
                $('#deleteBtn').show();
                $('#id').val(0);
                $('#name').val("");
                $('#start_date').val("");
                $('#end_date').val("");
                $("#status").val("");
                $('#description').val("");
                $("#deleteBtn").hide();
                $('#new-project-modal').modal('show');
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

                $("#deleteBtn").show();
                $('#new-project-modal').modal('show');
            });
        });
    </script>
@endsection
