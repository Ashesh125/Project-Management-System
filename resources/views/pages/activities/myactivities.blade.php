@extends('layouts.parent')

@section('title', 'My Activities')
@section('activities-nav', 'active')

@section('main-content')

    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>My Activities</u></div>
        <div>
            <table id="data-table" class="table table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project</th>
                        <th>Activity</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($activities))
                        @foreach ($activities as $activity)
                            <tr>
                                <td> {{ $activity->id }} </td>
                                <td> {{ $activity->project->name }} </td>
                                <td> {{ $activity->name }} </td>
                                <td> {{ date('F j Y', strtotime($activity->start_date)) }} </td>
                                <td> {{ date('F j Y', strtotime($activity->end_date)) }} </td>
                                <td class="text-truncate" style="max-width: 220px;"> {{ $activity->description }} </td>
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
                        data: 'project_name'
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
                        "targets": 6,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' class='showTaskBtn' href=' {{ route('myTasks',['type' => 'kanban']) }}/" +
                                data['id'] + "'>Show Tasks</a>";
                        }
                    }

                ],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });

        });
    </script>
@endsection
