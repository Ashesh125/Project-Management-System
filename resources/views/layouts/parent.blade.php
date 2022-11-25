<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/d991a5e65c.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
        integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('js/bootstrapValidation.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"
        integrity="sha512-z4OUqw38qNLpn1libAN9BsoDx6nbNFio5lA6CuTp9NlK83b89hgyCVq+N5FdBJptINztxn1Z3SaKSKUS5UP60Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css">
    <script>
        const host = "{{ URL::to('/') }}";
    </script>
</head>

<body>
    <div class="main-container d-flex flex-row justify-content-between">
        <div class="d-flex flex-column fixed-left fixed-bottom h-100 fixed-top main-nav p-3 col-lg-2 col-md-2 col-sm-1">
            <a href="{{ route('dashboard') }}"
                class="d-flex align-items-center link-dark text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" class="logo mx-4" />
                <div class="fs-4 text-truncate overflow-hidden">{{ auth()->user()->name }}</div>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link link-dark @yield('home-nav')" aria-current="page">
                        <i class="fa-solid fa-house mx-2 px-2"></i>
                        <span class="d-sm-none d-md-inline">Home</span>
                    </a>
                </li>
                <hr>
                @if (auth()->user()->role != 2)
                <div>
                    <li>
                        <a href="{{ route('myActivities') }}/card" class="nav-link link-dark @yield('myprojects-nav')">
                            <i class="fa-solid fa-boxes-stacked mx-2 px-2"></i>
                            <span class="d-sm-none d-md-inline">My Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('myActivities') }}/table" class="nav-link link-dark  @yield('activities-nav')">
                            <i class="fa-solid fa-list mx-2 px-2"></i>
                            <span class="d-sm-none d-md-inline">My Activities</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('myIssues') }}" class="nav-link link-dark @yield('myissues-nav')">
                            <i class="fa-solid fa-circle-exclamation mx-2 px-2"></i>
                            <span class="d-sm-none d-md-inline">My Issues</span>
                        </a>
                    </li>
                    <hr>
                </div>
                @endif

                @if (auth()->user()->role != 0)
                    <div>
                        <li>
                            <a href="{{ route('projects') }}" class="nav-link link-dark @yield('project-nav')">
                                <i class="fa-solid fa-boxes-stacked mx-2 px-2"></i>
                                <span class="d-sm-none d-md-inline">Projects</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projectCard') }}" class="nav-link link-dark  @yield('allactivities-nav')">
                                <i class="fa-solid fa-list mx-2 px-2"></i>
                                <span class="d-sm-none d-md-inline">Activities</span>
                            </a>
                        </li>
                        <hr>
                    </div>
                @endif
                @if (auth()->user()->role != 0)
                    <li>
                        <a href="{{ route('users') }}" class="nav-link link-dark  @yield('user-nav')">
                            <i class="fa-solid fa-users mx-2 px-2"></i>
                            <span class="d-sm-none d-md-inline">Users</span>
                        </a>
                    </li>
                @endif
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                    id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">

                    <img src="{{ auth()->user()->image ? url('storage/user/' . auth()->user()->image) : asset('images/no-user-image.png') }}"
                        width="38" height="38" class="rounded-circle img-thumbnail mx-4" accept="image/*" />

                    <strong>Settings</strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link class="dropdown-item" :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-2 col-md-2"></div>
        <div class="main-content-holder vertical-scrollable h-100 col-lg-10">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @yield('main-content')
        </div>
        <div>
        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</body>

</html>
