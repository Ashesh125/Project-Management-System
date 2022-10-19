@extends('layouts.parent')

@section('title', 'Tasks')
@section('project-nav', 'active')

@section('main-content')

    <!-- Modal -->
    <div class="modal fade" id="new-task-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Task Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" class="row g-3 needs-validation" action="{{ route('checkTask') }}" method="POST"
                        novalidate>

                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Task Name</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="0"
                                required>
                            <input type="hidden" class="form-control" id="project_id" name="project_id"
                                value="{{ request('id') }}" required>
                            <input type="hidden" class="form-control" id="status" name="status" value="0"
                                required>

                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <select class="form-select" id="assigned_to" name="assigned_to" required>
                                <option selected disabled value="0">Choose</option>
                                <option value="1">Ashesh</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid User.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                            <div class="valid-feedback">
                                Looks good!
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
                            <button class="btn btn-success mx-3" id="completeBtn" type="button">Complete</button>
                            <button class="btn btn-danger mx-3" id="undoBtn" type="button">Undo</button>
                            <button class="btn btn-danger mx-3" id="deleteBtn" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Project Detail</u></div>
        <div class="d-flex my-1 mt-2 justify-content-between">
            <div class="fw-bold fs-4 col-3">
                {{ $project->name }}
            </div>
            <div class="progress col-8 w-75  d-flex my-3">
                <div class="progress-bar text-end" role="progressbar" style="font-size:12px;width:{{ $project->avg_task }}%;" aria-valuenow="10"
                    aria-valuemin="0" aria-valuemax="100">{{ $project->avg_task }}%</div>
            </div>
        </div>
        <div class="d-flex my-1 justify-content-between">
            <div class="col-md-5">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="text" class="form-control" id="start_date" value="{{ date('F j, Y', strtotime($project->start_date)) }}"
                    name="start_date" disabled required>
            </div>
            <div class="col-md-5">
                <label for="end_date" class="form-label">End Date</label>
                <input type="text" class="form-control" id="end_date" value="{{ date('F j, Y', strtotime($project->end_date)) }}"
                    name="end_date" disabled required>
            </div>
        </div>
        <div class="my-2">
            <div>Description</div>
            <div class="col-12">
                <textarea class="form-control" placeholder="Leave a description" id="description" name="description"
                    style="height: 100px" required disabled>{{ $project->description }}</textarea>

            </div>
        </div>
        <div class="fw-bold fs-2 mt-3"><u>Tasks</u></div>
        <div class="d-flex justify-contents-between my-3">
            <button class="btn btn-primary" data-bs-toggle="modal" id="new" data-bs-target="#new-task-modal">Add
                Task</button>
        </div>
        <div>
            <table id="data-table" class="table table-success table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th style="width:50%;">Description</th>
                        <th>Assigned</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($project->taskList)
                        @foreach ($project->taskList as $task)
                            <tr>
                                <td> {{ $task->id }} </td>
                                <td> {{ $task->name }} </td>
                                <td> {{ date('F j, Y', strtotime($task->due_date)) }} </td>
                                <td> {{ $task->status }} </td>
                                <td> {{ $task->description }} </td>
                                <td> {{ $task->assigned_to }} </td>
                                <td> </td>
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
                        data: 'end_date'
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row, meta) {
                            if (data == 0) {
                                return '<div class="text-center"><i class="fa-regular fa-circle-xmark text-danger"></i></div>';
                            } else {
                                return '<div class="text-center"><i class="fa-regular fa-circle-check text-success"></i></div>';
                            }

                        }
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'assigned_to'
                    },
                    {
                        "targets": 8,
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return "<a class='btn btn-primary' href=' {{ route('projectdetail', 1) }}'>Show Tasks</a>";
                        }
                    }

                ],
                "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
                order: [
                    [0, 'desc']
                ],
            });



            $("#new").on("click", function() {
                $('#deleteBtn').show();
                $('#id').val(0);
                $('#name').val("");
                $('#assigned_to').val("0");
                $('#end_date').val("");
                $("#status").val(0);
                $('#description').val("");
                $("#deleteBtn").hide();
                $("#completeBtn").hide();
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
                $("#assigned_to").val(data['assigned_to']);
                $('#description').val(data['description']);


                if ($("#status").val() == 1) {
                    $("#undoBtn").show();
                    $("#completeBtn").hide();
                } else {
                    $("#completeBtn").show();
                    $("#undoBtn").hide();
                }

                $("#deleteBtn").show();
                $('#new-task-modal').modal('show');
            });


            $("#completeBtn").on('click', function() {
                if (confirm("Confirm Completion")) {
                    let status = $("#status").val();
                    if (status == 0) {
                        $("#status").val(1);
                    } else {
                        $("#status").val(0);
                    }
                    $("#form").submit();
                }
            });

            $("#undoBtn").on('click', function() {
                if (confirm("Confirm Undo")) {
                    let status = $("#status").val();
                    if (status == 0) {
                        $("#status").val(1);
                    } else {
                        $("#status").val(0);
                    }
                    $("#form").submit();
                }
            });

        });
    </script>
@endsection
