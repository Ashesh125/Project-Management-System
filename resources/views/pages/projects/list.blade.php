@extends('layouts.parent')

@section('title', 'Projects')
@section('project-nav', 'active')

@section('main-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('projectCard') }}">Card</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('projects') }}">Table</a>
        </li>
    </ul>
    <div class="d-flex m-3 p-3 flex-column">
        <div class=" d-flex justify-content-start"><u class="my-auto fw-bold fs-2">Projects</u>

            @if (auth()->user()->role == 2)
                @include('components.project-modal')

                <div class="d-flex justify-contents-between my-3 m-2 mx-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" id="new"
                        data-bs-target="#modal">New</button>
                </div>
            @endif
        </div>


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
                            return "<a class='btn btn-primary' class='showTaskBtn' href=' {{ route('projectDetail') }}/" +
                                data['id'] + "'>Show Activities</a>";
                        }
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
                $('#form').attr('action', '/projects/'+$('#id').val());
                $(".search2-search__field").val(data['lead']);
                $("#deleteBtn").show();
                $('#modal').modal('show');
            });

        });
    </script>
@endsection
