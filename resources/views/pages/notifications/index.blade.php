@extends('layouts.parent')

@section('title', 'Notifications')
@section('notification-nav', 'active')

@section('main-content')
    <div class="d-flex m-3 p-3 flex-column">
        <h2>Notifications</h2>
        @php
            $user = App\Models\User::findOrFail(auth()->user()->id);
        @endphp

        <div><a class="btn btn-primary float-end mb-2" href="{{ route('markAllAsRead') }}">Mark All as Read</a></div>
        <div class="accordion" id="new-notifications">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        New
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#old-notifications">

                    @forelse ($newNotifications as $index => $notification)
                        <div class="accordion-body">
                            @switch($notification->type)
                                @case('App\Notifications\TaskGivenNotification')
                                    <div class="d-inline-block">
                                        You were Assigned a New Task : <strong>{{ $notification->data['task']['name'] }}</strong>
                                    </div>

                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>
                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('taskToActivity', ['id' => $notification->data['task']['id']]) }}"> Check
                                            it out </a></div>
                                @break

                                @case('App\Notifications\TaskReviewedNotification')
                                    <div class="d-inline-block">
                                        A task has been Reviewed ( {!! $notification->data['task']['status'] == 1
                                            ? '<i class="fa-solid fa-thumbs-up text-success"></i>'
                                            : '<i class="fa-solid fa-exclamation text-danger"></i>' !!} ) :
                                        <strong>{{ $notification->data['task']['name'] }}</strong>
                                    </div>

                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>
                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('taskToActivity', ['id' => $notification->data['task']['id']]) }}"> Check
                                            it out </a></div>
                                @break

                                @case('App\Notifications\IssueCreatedNotification')
                                    <div class="d-inline-block">
                                        A Issue has been generated in <strong>{{ $notification->data['activity']['name'] }}</strong>
                                    </div>

                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>

                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('issues', ['id' => $notification->data['activity']['id']]) }}"> Check
                                            it out </a></div>
                                @break

                                @case('App\Notifications\IssueResolvedNotification')
                                    <div class="d-inline-block">
                                        A Issue has been Resolved : <strong>{{ $notification->data['issue']['name'] }}</strong>
                                    </div>
                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>
                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('comments', ['id' => $notification->data['issue']['id']]) }}"> Check
                                            it out </a></div>
                                @break

                                @case('App\Notifications\TaskCompletedNotification')
                                    <div class="d-inline-block">
                                        A Task has been Completed : <strong>{{ $notification->data['task']['name'] }}</strong>
                                    </div>
                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>
                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('activityDetail', ['id' => $notification->data['task']['activity_id']]) }}">
                                            Check
                                            it out </a></div>
                                @break

                                @case('App\Notifications\ActivityCompletedNotification')
                                    <div class="d-inline-block">
                                        A Activity has been Completed :
                                        <strong>{{ $notification->data['activity']['name'] }}</strong>
                                    </div>
                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>
                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('activityDetail', ['id' => $notification->data['activity']['id']]) }}">
                                            Check
                                            it out </a></div>
                                @break

                                @case('App\Notifications\ActivityCreatedNotification')
                                    <div class="d-inline-block">
                                        A Activity has been Assigned to You :
                                        <strong>{{ $notification->data['activity']['name'] }}</strong>
                                    </div>
                                    <span class="float-end">
                                        <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                            Mark As Read </a>
                                    </span>
                                    <div><a type="btn btn-primary" class="notification-read"
                                            id="notification_{{ $notification->id }}"
                                            href="{{ route('activityDetail', ['id' => $notification->data['activity']['id']]) }}">
                                            Check
                                            it out </a></div>
                                @break

                                @default
                            @endswitch

                        </div>
                        @if ($loop->last)
                            <div class="accordion-body">
                                <div>
                                    {{ $user->notifications()->whereNull('read_at')->simplePaginate(10)->links() }}
                                </div>
                            </div>
                        @else
                            <hr class="m-0 p-0">
                        @endif
                        @empty

                            <div class="accordion-body">
                                <div>
                                    No Notifications
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
            <div class="accordion my-3" id="old-notifications">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                            aria-expanded="true" aria-controls="collapseTwo">
                            Old
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#old-notifications">

                        @forelse ($oldNotifications as $index => $notification)
                            <div class="accordion-body">
                                @switch($notification->type)
                                    @case('App\Notifications\TaskGivenNotification')
                                        <div class="d-inline-block">
                                            You were Assigned a New Task :
                                            <strong>{{ $notification->data['task']['name'] }}</strong>
                                        </div>

                                        <div><a type="btn btn-primary"
                                                href="{{ route('taskToActivity', ['id' => $notification->data['task']['id']]) }}">
                                                Check
                                                it out </a>
                                        </div>
                                    @break

                                    @case('App\Notifications\TaskReviewedNotification')
                                        <div class="d-inline-block">
                                            A task has been Reviewed ( {!! $notification->data['task']['status'] == 0
                                                ? '<i class="fa-solid fa-thumbs-up text-success"></i>'
                                                : '<i class="fa-solid fa-exclamation text-danger"></i>' !!} ) :
                                            <strong>{{ $notification->data['task']['name'] }}</strong>
                                        </div>

                                        <span class="float-end">
                                            <a type="btn btn-primary" href="{{ route('markAsRead', ['id' => $notification->id]) }}">
                                                Mark As Read </a>
                                        </span>
                                        <div><a type="btn btn-primary"
                                                href="{{ route('taskToActivity', ['id' => $notification->data['task']['id']]) }}">
                                                Check
                                                it out </a></div>
                                    @break

                                    @case('App\Notifications\IssueCreatedNotification')
                                        <div class="d-inline-block">
                                            A Issue has been generated in
                                            <strong>{{ $notification->data['activity']['name'] }}</strong>
                                        </div>

                                        <div><a type="btn btn-primary"
                                                href="{{ route('issues', ['id' => $notification->data['activity']['id']]) }}">
                                                Check
                                                it out </a></div>
                                    @break

                                    @case('App\Notifications\IssueResolvedNotification')
                                        <div class="d-inline-block">
                                            A Issue has been Resolved : <strong>{{ $notification->data['issue']['name'] }}</strong>
                                        </div>
                                        <div><a type="btn btn-primary"
                                                href="{{ route('comments', ['id' => $notification->data['issue']['id']]) }}"> Check
                                                it out </a></div>
                                    @break

                                    @case('App\Notifications\TaskCompletedNotification')
                                        <div class="d-inline-block">
                                            A Task has been Completed : <strong>{{ $notification->data['task']['name'] }}</strong>
                                        </div>
                                        <div><a type="btn btn-primary"
                                                href="{{ route('activityDetail', ['id' => $notification->data['task']['activity_id']]) }}">
                                                Check
                                                it out </a></div>
                                    @break

                                    @case('App\Notifications\ActivityCompletedNotification')
                                        <div class="d-inline-block">
                                            A Activity has been Completed :
                                            <strong>{{ $notification->data['activity']['name'] }}</strong>
                                        </div>
                                        <div><a type="btn btn-primary"
                                                href="{{ route('activityDetail', ['id' => $notification->data['activity']['id']]) }}">
                                                Check
                                                it out </a></div>
                                    @break

                                    @case('App\Notifications\ActivityCreatedNotification')
                                        <div class="d-inline-block">
                                            A Activity has been Assigned to You :
                                            <strong>{{ $notification->data['activity']['name'] }}</strong>
                                        </div>
                                        <div><a type="btn btn-primary"
                                                href="{{ route('activityDetail', ['id' => $notification->data['activity']['id']]) }}">
                                                Check
                                                it out </a></div>
                                    @break

                                    @default
                                @endswitch

                                <span class="font-sm-gray">Seen :
                                    {{ date('h:i:s F j, Y ', strtotime($notification->read_at)) }}</span>
                            </div>

                            @if ($loop->last)
                                <div class="accordion-body">
                                    <div>
                                        {{ $user->notifications()->whereNotNull('read_at')->simplePaginate(10)->links() }}
                                    </div>
                                </div>
                            @else
                                <hr class="m-0 p-0">
                            @endif
                            @empty
                                <div class="accordion-body">
                                    <div>
                                        No Notifications
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('.delete-msg').on('click', function() {
                            let tempArr = $(this).attr('id').split("-");
                            let id = tempArr[2];

                            if (confirm('Delete Message !')) {
                                $('#id').val(id);
                                // $('#name').val($('#msg-'+id).text());
                                $('#name').val("");
                                $('#form').submit();
                            }
                        });


                        $('.notification-read').on("click", function(e) {
                            // e.preventDefault();
                            let id = $(this).attr('id').split('_')[1];
                            // alert(id);
                            $.ajax({
                                type: "GET",
                                url: host + "/markAsRead/" + id,
                                success: function(response) {},
                                dataType: "html",
                            });
                        });
                    });
                </script>
            @endsection
