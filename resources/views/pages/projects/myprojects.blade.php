@extends('layouts.parent')

@section('title', 'myprojects')
@section('myprojects-nav', 'active')

@section('main-content')

    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>My Projects</u></div>
        <div>
            <table id="data-table" class="table table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
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
                        data: 'description'
                    },
                    {
                        "targets": 5,
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
                        "targets": 5,
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
