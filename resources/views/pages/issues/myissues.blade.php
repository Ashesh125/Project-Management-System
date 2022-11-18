@extends('layouts.parent')

@section('title', ' Issues')
@section('myissues-nav', 'active')

@section('main-content')
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2 my-3 d-flex justify-content-between">
            <u>Issues</u>
        </div>
        <div>
            <table id="data-table" class="table table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Activity</th>
                        <th>Name</th>
                        <th>Creator</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($activities)
                        @foreach ($activities as $activity)
                            @foreach ($activity->issues as $issue)
                                <tr>
                                    <td> {{ $issue->id }} </td>
                                    <td> {{ $activity->name }}</td>
                                    <td> {{ $issue->name }} </td>
                                    <td> {{ $issue->user->name }} </td>
                                    <td> {{ $issue->created_at }} </td>
                                    <td> {{ $issue->status }} </td>
                                    <td class="d-flex justify-content-end"> </td>
                                </tr>
                            @endforeach
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
                    },{
                        data: 'activity_name'
                    },
                    {
                        data: 'name'
                    },{
                        data: 'creator'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row, meta) {

                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                if (data == 0) {
                                    return '<div><i class="fa-regular fa-circle-xmark text-danger"></i></div>';
                                } else {
                                    return '<div><i class="fa-regular fa-circle-check text-success"></i></div>';
                                }
                            }
                        }
                    },
                    {
                        "targets": 6,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' class='showCommentkBtn' href='{{ route('comments') }}/" +
                                row['id'] + "'>Show Comments</a>";
                        }
                    }

                ],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 3,
                        "data": null,
                        "orderable": false,
                        "defaultContent": "<button class='btn btn-primary'>Show Comments</button>"
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
                $("#deleteBtn").hide();
                $('#new-issue-modal').modal('show');
            });


            $('#data-table tbody').on('dblclick', 'tr', function() {
                var data = table.row(this).data();
                $('#deleteBtn').show();
                $('#id').val(data['id']);
                $('#name').val(data['name']);


                $("#status1").prop('checked', data['status'] == 0 ? false : true);
                $("#deleteBtn").show();
                $('#new-issue-modal').modal('show');
            });
        });
    </script>
@endsection
