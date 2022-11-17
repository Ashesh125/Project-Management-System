@extends('layouts.parent')

@section('title', 'Profile')

@section('main-content')
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Profile</u></div>
            <img src="{{ $user->image ? url('storage/user/'.$user->image) : asset('images/no-user-image.png')}}"  class="img-thumbnail w-25 h-25 m-2" id="imageOutput" accept="image/*" />
        <form id="form" class="row col-6 g-3 needs-validation" action="{{ route('updateProfile') }}" method="POST"
            enctype="multipart/form-data" novalidate>

            @csrf


            <div class="col-md-7">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-7">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="mb-3 col-7">
                <label for="image" class="form-label">Default file input example</label>
                <input class="form-control" type="file" name="image" id="image" >
            </div>
            <div class="ms-2 form-check col-7">
                <input class="form-check-input" type="checkbox" value="" id="changePswd">
                <label class="form-check-label" for="flexCheckDefault">
                    Change Password
                </label>
            </div>
            <div class="col-md-7 pswd">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-7 pswd">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" value="">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="d-flex col-6 justify-content-center">
                <button class="btn btn-primary mx-3" id="submitBtn" type="submit">Submit</button>
            </div>

        </form>
    </div>
    <script>
        $(document).ready(function() {
            $(".pswd").hide();
            $('#changePswd').change(function() {
                if (this.checked) {
                    $(".pswd").show();
                    $("#password").prop('required', true);
                    $("#cpassword").prop('required', true);
                } else {
                    $(".pswd").hide();
                    $("#password").prop('required', false);
                    $("#cpassword").prop('required', false);
                }
            });

            $('#form').submit(function(e) {
                if ($('#changePswd').prop('checked')) {
                    let pswd = $('#password').val();
                    let cpswd = $('#cpassword').val();
                    if (pswd.length < 8 || pswd.length > 16) {
                        alert('Password length invalid');
                        e.preventDefault();
                    } else if (pswd !== cpswd) {
                        alert('Password and Confim Password do not match');
                        e.preventDefault();
                    }
                }
            });


            $('#image').on('change',function(event) {
                var image = document.getElementById('imageOutput');
                image.src = URL.createObjectURL(event.target.files[0]);
            });
        });
    </script>
@endsection
