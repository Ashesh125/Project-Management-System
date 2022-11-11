@extends('layouts.parent')

@section('title', 'Profile')

@section('main-content')
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Profile</u></div>
        <form id="form" class="row g-3 needs-validation" action="{{ route('checkProject') }}" method="POST"
            enctype="multipart/form-data" novalidate>

            @csrf
         

            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="hidden" class="form-control" id="id" name="id" value="{{ $user->id }}"
                    required>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
