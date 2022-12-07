@extends('layouts.parent')

@section('title', 'Comments')
@section('comment-nav', 'active')

@section('main-content')
    <div class="d-flex m-3 p-3 flex-column">
        <h2>Issue : {{ $issue->name }}</h2>
        <div class="fw-bold fs-2 my-3 d-flex justify-content-between">
            <u>Comments</u>
            <a class="btn btn-danger mx-3" href="{{ route('issues', $issue->activity->id) }}">Issue</a>
        </div>

        <div>
            <div class="comment-area col-12">
                @forelse ($issue->comments as $comment)
                    <div class="rounded p-2 m-2 comment">
                        <p class="p-1 msg" id="msg-{{ $comment->id }}">
                            {{ $comment->name }}
                        </p>
                        <hr>
                        @if (auth()->user()->id != $comment->user_id)
                            <div class="d-flex justify-content-end">
                                <div class="text-end font-sm-gray text-dark">
                                    {{ $comment->user->name }} ( {{ date('h:i:s F j, Y ', strtotime($comment->created_at)) }} )
                                </div>
                            </div>
                        @else
                        <div class="d-flex justify-content-between">
                            <div class="text-start font-sm-gray text-dark">
                                {{ $comment->user->name }} ( {{ date('h:i:s F j, Y ', strtotime($comment->created_at)) }} )
                            </div>
                            <div>
                                @if($comment->user->id == auth()->user()->id || auth()->user()->role == 2)
                                <div>
                                    <span class="delete-msg" id="delete-msg-{{ $comment->id }}"><i class="fa-solid fa-trash-can p-1"></i></span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                @empty
                    <div class="rounded p-2 m-2 comment col-12">
                        <p class="p-1">
                            No Comments
                        </p>
                        <hr>
                    </div>
                @endforelse
            </div>
            <div class="bg-gray p-3 messege-box rounded m-2 col-12">
                <form id="form" class="row g-3 needs-validation message-form" action="{{ route('checkComment') }}"
                    method="POST" novalidate>
                    @csrf
                    <input type="hidden" value="0" name="id" id="id" />
                    <input type="hidden" value="{{ auth()->user()->id }}" name="user_id" />
                    <input type="hidden" value="{{ $issue->id }}" name="issue_id" />
                    <textarea class="form-control" id="name" name="name" placeholder="Leave a Comment" required></textarea>
                    <div class="d-flex flex-row-reverse mt-3">
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete-msg').on('click',function(){
                let tempArr = $(this).attr('id').split("-");
                let id = tempArr[2];

                if(confirm('Delete Message !')){
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
