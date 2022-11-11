@extends('layouts.parent')

@section('title', 'Home')
@section('home-nav', 'active')

@section('main-content')
    @if (!$projects)
        <style>
            .bg-gray {
                display: none;
            }
        </style>
    @endif
    <div class="d-flex m-3 p-3 flex-column">
        <div class="d-flex justify-content-between mb-4">
            <div class="fw-bold fs-2"><u>Dashboard</u></div>
            <div class="align-middle">{{ date('F j, Y') }}</div>
        </div>
        <div class="row mx-3">
            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-projects">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Projects</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_projects">
                                    {{ $arr['all_projects'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-boxes-stacked fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-users">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary shadow h-100 py-2 goto-users">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_users">{{ $arr['all_users'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="far fa-id-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-mytasks">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    My Tasks</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_categories">
                                    {{ $arr['all_myTasks'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-12 mb-4 dashboard-card" id="goto-issues">
                <div
                    class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Issues</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_issues">
                                    {{ $arr['all_issues'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-circle-exclamation fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 mt-4">
            <select class="form-select bg-gray no-outline" id="project-select" aria-label="Default select example">
                @forelse ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @empty
                    <option value="0" disabled>NO PROJECTS</option>
                @endforelse
            </select>
        </div>
        <div class="bg-gray d-flex flex-column">
            <div class="bg-gray d-flex rounded w-100 mt-2 justify-content-between p-2 px-4">
                <div class="total-tasks info-card w-25">
                    <div class="my-2 dashboard-card">
                        <div
                            class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-success  shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="mr-2 d-flex justify-content-between">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase">
                                            Start Date</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="start-date"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="total-tasks info-card w-25">
                    <div class="my-2 dashboard-card">
                        <div
                            class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary  shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="mr-2 d-flex justify-content-between">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase">
                                            End Date</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="end-date"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="total-tasks info-card w-25">
                    <div class="my-2 dashboard-card">
                        <div
                            class="card border-start border-bottom-0 border-top-0 border-end-0 border-5 border-danger shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="mr-2 d-flex justify-content-between">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase">
                                            Days Remaining</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="time-remaining"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-2 mx-4 activity_detail-holder bg-gray d-flex flex-column rounded">

            </div>
            <div class="bg-gray rounded w-75 me-3">
                <div class="h-100 m-1 p-2">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>



    </div>

    <script>
        var lineChart = null;
        var pieChart = null;
        var doughnutChart = null;

        $(document).ready(function() {


            anime({
                targets: '.row .dashboard-card',
                translateY: 20,
                opacity: 1,
                delay: anime.stagger(100)
            });

            anime({
                targets: '.stats .info-card',
                translateY: 10,
                delay: anime.stagger(100)
            });

            callAjax(1);


            $('#project-select').on('change', function(e) {
                let id = this.value;

                $('.activity_detail-holder').empty();
                pieChart.destroy();
                doughnutChart.destroy();
                callAjax(id);
            });
        });


        function lineGraph(target, labels, values) {
            let datas = {
                labels: labels,
                datasets: [{
                        label: 'Issues',
                        data: values[0],
                        borderColor: 'red',
                        backgroundColor: 'red',
                    },
                    {
                        label: 'Tasks',
                        data: values[1],
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                    },
                    {
                        label: 'Completed',
                        data: values[2],
                        borderColor: 'green',
                        backgroundColor: 'green',
                    }
                ]
            };

            let config = {
                type: 'line',
                data: datas,
                options: {
                    responsive: true,
                },
            };

            if (lineChart == null) {
                lineChart = new Chart(
                    document.getElementById(target).getContext('2d'),
                    config
                );
            }

        }
    </script>
@endsection
