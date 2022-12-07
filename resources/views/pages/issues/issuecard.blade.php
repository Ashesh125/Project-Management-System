@extends('layouts.parent')

@section('title', 'Issues')
@section('allissues-nav', 'active')

@section('main-content')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('issuesCard', ['type' => 'card']) }}">Card</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('issuesCard', ['type' => 'table']) }}">Table</a>
    </li>
</ul>
    <div class="d-flex m-3 p-3 flex-column">
        <div class="fw-bold fs-2"><u>Issues</u></div>
        <div>
            <div class="project-cards info-card d-flex flex-wrap">
                @if ($projects)
                    @foreach ($projects as $index => $project)
                        <div class="m-3 project-card col-12">
                            <div class="bg-gray card shadow h-100 me-5">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="mx-2 d-flex flex-column justify-content-between">
                                            <div class="text-xs font-weight-bold text-uppercase d-flex justify-content-between">
                                                <span>{{ $index }}</span>
                                                <a class="btn btn-primary" href="{{ route('projectDetail',['id' => $project[0]->project->id]) }}">Detail</a>
                                            </div>
                                            <div class="project-cards info-card d-flex flex-wrap justify-content-start px-2">
                                                @if ($project)
                                                    @foreach ($project as $activity)
                                                        <div class="mx-4 my-3 issue-card col-3" id="{{ $activity->id }}">
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
                                                                                <div>Total</div>
                                                                                <span>{{ $activity->issues->count() }}</span>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div class="text-success">Resolved</div>
                                                                                <span class="text-success">{{ $activity->issues->where('status',1)->count() }}</span>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between">
                                                                                <div class="text-danger">Remaining</div>
                                                                                <span
                                                                                    class="text-danger">{{ $activity->issues->where('status',0)->count() }}</span>
                                                                            </div>
                                                                            {{-- <div class="d-flex justify-content-between">
                                                                        Tasks
                                                                        <span class="mb-0 font-weight-bold text-gray-800" id="remaining-issues">
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
                                                <span class="mb-0 font-weight-bold text-gray-800" id="remaining-issues">
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
@endsection
