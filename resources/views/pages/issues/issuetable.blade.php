@extends('layouts.parent')

@section('title', 'Issues')
@section('allissues-nav', 'active')

@section('main-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link"href="{{ route('issuesCard', ['type' => 'card']) }}">Card</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('issuesCard', ['type' => 'table']) }}">Table</a>
        </li>
    </ul>
    <!-- Modal -->
    <div class="modal fade" id="new-issue-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Issue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" class="row g-3 needs-validation" action="{{ route('checkIssue') }}" method="POST"
                        novalidate>

                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="0"
                                required>
                            <input type="hidden" class="form-control" id="activity_id" name="activity_id"
                                value="" required>
                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                                value="{{ auth()->user()->id }}" required>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="hidden" name="status" value="0" id="status0">
                                <input class="form-check-input" type="checkbox" name="status" value="1"
                                    id="status1">
                                <label class="form-check-label" for="status">
                                    Resolved
                                </label>
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
        <h2>Issues</h2>
        <div class="d-flex justify-contents-between my-3">
        </div>
        <div>
            <table id="data-table" class="table table-hover table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Activity ID</th>
                        <th>Name</th>
                        <th>Activity</th>
                        <th>Creator</th>
                        <th>Status</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $activities)

                        @foreach ($activities as $activity)
                            @foreach ($activity->issues as $issue)
                                <tr>
                                    <td> {{ $issue->id }} </td>
                                    <td> {{ $activity->id }} </td>
                                    <td> {{ $issue->name }} </td>
                                    <td> {{ $activity->name }} </td>
                                    <td> {{ $issue->user->name }} </td>
                                    <td> {{ $issue->status }} </td>
                                    <td class="d-flex justify-content-end"> </td>
                                </tr>
                            @endforeach
                        @endforeach

                    @empty

                        <tr class="text-center">
                            <td colspan='7'>No data available !!!</td>
                        </tr>
                    @endforelse
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
                    },{
                        data: 'activity_id'
                    },
                    {
                        data: 'name'
                    }, {
                        data: 'activity_name'
                    }, {
                        data: 'user'
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
                        "targets": [0,1],
                        "visible": false,
                        "searchable": false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });



            $("#new").on("click", function() {
                $('#deleteBtn').show();
                $('#id').val(0);
                $('#activity_id').val(0);
                $('#name').val("");
                $("#deleteBtn").hide();
                $('#new-issue-modal').modal('show');
            });


            $('#data-table tbody').on('dblclick', 'tr', function() {
                var data = table.row(this).data();
                $('#deleteBtn').show();
                $('#id').val(data['id']);
                $('#name').val(data['name']);
                $('#activity_id').val(data['activity_id']);
                $("#status1").prop('checked', data['status'] == 0 ? false : true);
                $("#deleteBtn").show();
                $('#new-issue-modal').modal('show');
            });
        });
    </script>
@endsection
