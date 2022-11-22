@extends('layouts.parent')

@section('title', 'Notifications')
@section('notification-nav', 'active')

@section('main-content')
    <div class="d-flex m-3 p-3 flex-column">
        <h2>Notifications</h2>


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
                                        You were Assigned a New Task : {{ $notification->data['task']['name'] }}
                                    </div>
                                @break

                                @case('App\Notifications\TaskReviewedNotification')
                                    <div class="d-inline-block">
                                        A task has been Reviewed ( {!! $notification->data['task']['status'] == 0
                                            ? '<i class="fa-solid fa-thumbs-up text-success"></i>'
                                            : '<i class="fa-solid fa-exclamation text-danger"></i>' !!} ) :
                                        {{ $notification->data['task']['name'] }}
                                    </div>
                                @break

                                @default
                            @endswitch

                            <span class="float-end">
                                <a type="btn btn-primary"
                                    href="{{ route('markAsRead', ['type' => 'taskGiven', 'id' => $notification->id]) }}">
                                    Mark As Read </a>
                            </span>
                            <div><a type="btn btn-primary"
                                    href="{{ route('taskToActivity', ['id' => $notification->data['task']['id']]) }}"> Check
                                    it out </a></div>
                        </div>
                        @if (!$loop->last)
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
                <div class="accordion my-3" id="old-notifications">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Old
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#old-notifications">

                            @forelse ($oldNotifications as $index => $notification)
                                <div class="accordion-body">
                                    @switch($notification->type)
                                        @case('App\Notifications\TaskGivenNotification')
                                            <div>
                                                You were Assigned a New Task : {{ $notification->data['task']['name'] }}
                                            </div>
                                        @break

                                        @case('App\Notifications\TaskReviewedNotification')
                                            <div>
                                                A task has been Reviewed ( {!! $notification->data['task']['status'] == 0
                                                    ? '<i class="fa-solid fa-thumbs-up text-success"></i>'
                                                    : '<i class="fa-solid fa-exclamation text-danger"></i>' !!} ) :
                                                {{ $notification->data['task']['name'] }}
                                            </div>
                                        @break

                                        @default
                                    @endswitch

                                    <span class="font-sm-gray">Seen :
                                        {{ date('h:i:s F j, Y ', strtotime($notification->read_at)) }}</span>
                                </div>

                        @if (!$loop->last)
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

                    anime({
                        targets: '.comment-area .comment',
                        opacity: 1,
                        duration: 1500,
                        delay: anime.stagger(100)
                    });
                });
            </script>
        @endsection
