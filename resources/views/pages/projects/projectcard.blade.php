@extends('layouts.parent')

@section('title', 'Projects')
@section('project-nav', 'active')

@section('main-content')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('projectCard') }}">Card</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('projects')}}">Table</a>
    </li>
</ul>
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Projects</u></div>
        <div>
            <div class="project-cards info-card d-flex flex-wrap">
                @if ($projects)
                    @php
                        $project_names = $projects->keys();
                    @endphp
                    @foreach ($projects as $index => $project)
                        <div class="m-3 project-card col-12">
                            <div class="bg-gray card shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mx-2 d-flex flex-column justify-content-between">
                                            <div class="text-xs font-weight-bold text-uppercase">
                                                {{ $index }}
                                            </div>
                                            <div class="project-cards info-card d-flex flex-wrap">
                                                @if ($project)
                                                    @foreach ($project as $activity)
                                                        <div class="mx-4 my-3 activity-card col-3" id="{{ $activity->id }}">
                                                            <div
                                                                class="border-start border-bottom-0 border-top-0 border-end-0 border-5 border-primary card shadow h-100">
                                                                <div class="card-body">
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div
                                                                            class="mr-2 d-flex flex-column justify-content-between">
                                                                            <div
                                                                                class="text-xs font-weight-bold text-primary">
                                                                                {{ $activity->name }}</div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>Assigned</div>
                                                                                <span>{{ $activity->tasks->count() }}</span>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div class="text-success">Completed</div>
                                                                                <span class="text-success">{{ $activity->tasks->where('status',1)->count() }}</span>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div class="text-danger">Remaining</div>
                                                                                <span
                                                                                    class="text-danger">{{ $activity->tasks->where('status',0)->count() }}</span>
                                                                            </div>
                                                                            {{-- <div class="d-flex justify-content-between">
                                                                        Tasks
                                                                        <span class="mb-0 font-weight-bold text-gray-800" id="remaining-tasks">
                                                                            5
                                                                        </span>
                                                                    </div> --}}

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                @endif
                                            </div>
                                            {{-- <div class="d-flex justify-content-between">
                                                Tasks
                                                <span class="mb-0 font-weight-bold text-gray-800" id="remaining-tasks">
                                                    5
                                                </span>
                                            </div> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.activity-card').on('click', function() {
                let id = $(this).attr('id');
                window.location.href = "{{ route('activityDetail') }}/" + id;
            })

            anime({
                targets: '.project-cards .project-card',
                opacity: 1,
                translateY: 20,
                duration: 1500,
                delay: anime.stagger(100)
            });
        });
    </script>
@endsection
