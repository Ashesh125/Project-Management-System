@extends('layouts.parent')

@section('title', 'Users')
@section('user-nav', 'active')

@section('main-content')
    @if (auth()->user()->role == 2)
        <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Project Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" class="row g-3 needs-validation" action="{{ route('checkUser') }}"
                            method="POST" novalidate>

                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="hidden" class="form-control" id="id" name="id" value="0"
                                    required />
                                <input type="hidden" class="form-control" name="restore" id="restore" value="0"
                                    required />
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="0">User</option>
                                    <option value="1">Manager</option>
                                    <option value="2">Super Admin</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid User.
                                </div>
                            </div>
                            <div class="col-md-6 noupdate">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6 noupdate">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="d-flex justify-content-center col-12 ">
                                <button class="btn btn-primary mx-3" id="submitBtn" type="submit">Submit</button>
                                <button class="btn btn-primary mx-3" id="restoreBtn">Restore</button>
                                <button class="btn btn-danger mx-3" id="deleteBtn">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Users</u></div>
        @if (auth()->user()->role == 2)
            <div class="d-flex justify-contents-between my-3">
                <button class="btn btn-primary" data-bs-toggle="modal" id="new"
                    data-bs-target="#new-project-modal">New</button>
            </div>
        @endif
        <div>
            <table id="data-table" class="table table-light table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($users))
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $user->id }} </td>
                                <td> <img src='{{ $user->image  ? url('storage/user/' . $user->image) : asset('images/no-user-image.png') }}'
                                    width='50px' height='50px' id='profile-circle-{{ $user->id }}'
                                    class="mx-1 rounded-circle img-thumbnail profile-circle border {{ $user->deleted_at ? 'border-danger' : 'border-dark' }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="{{ $user->name }}" data-bs-toggle="offcanvas"> </td>
                                <td> {{ $user->name }} </td>
                                <td> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a> </td>
                                <td> {{ $user->deleted_at }} </td>
                                <td> {{ $user->role }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan='3'>No data available !!!</td>
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
                    },{
                        data:'image'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'deleted_at',
                        "render": function(data, type, row, meta) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                return data == "" ?
                                    '<i class="fa-solid fa-user text-success"></i>' :
                                    '<i class="fa-solid fa-user-slash text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deleted User"></i>';
                            }
                        }
                    },
                    {
                        data: 'role',
                        "render": function(data, type, row, meta) {
                            if (type === "sort" || type === 'type') {
                                return data;
                            } else {
                                switch (data) {
                                    case "1":
                                        return "Manager";
                                        break;

                                    case "2":
                                        return 'Super Admin';
                                        break;

                                    case "0":
                                        return 'User';
                                        break
                                }
                            }
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
            @if (auth()->user()->role == 2)


                $("#new").on("click", function() {
                    $('#deleteBtn').hide();
                    $('#id').val(0);
                    $('#name').val("");
                    $("#role option:eq(0)").attr('selected', 'selected');
                    $("#deleteBtn").hide();
                    $('#restoreBtn').hide();
                    $('#modal').modal('show');
                });


                $('#data-table tbody').on('dblclick', 'tr', function() {
                    var data = table.row(this).data();
                    $('#deleteBtn').show();
                    $('#password').removeAttr("required");
                    $('#cpassword').removeAttr("required");
                    $('.noupdate').hide();
                    $('#id').val(data['id']);
                    $('#name').val(data['name']);
                    $('#email').val(data['email']);
                    $("#role option:eq(" + data['role'] + ")").attr('selected', 'selected');
                    if (data['deleted_at'] == "") {
                        $("#deleteBtn").show();
                        $('#restoreBtn').hide();
                    } else {
                        $('#deleteBtn').hide();
                        $('#restoreBtn').show();
                    }
                    $('#modal').modal('show');
                });
            @endif
        });
    </script>
@endsection
