<div class="modal fade" id="new-task-modal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" class="row g-3 needs-validation" action="{{ route('checkTask') }}" method="POST"
                    novalidate>

                    @csrf
                    <div class="col-md-12">
                        <label for="name" class="form-label">Task Name</label>
                        <input type="hidden" class="form-control" id="id" name="id" value="0"
                            required>
                        <input type="hidden" id="method-type" name="_method" value="">
                        <input type="hidden" class="form-control" id="activity_id" name="activity_id"
                            value="{{ $activity->id }}" required>
                        <input type="hidden" class="form-control" id="status" name="status" value="0"
                            required>

                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6" id="userlist-holder">
                        <label for="user_id" class="form-label">Assigned To</label>
                        <select class="form-select w-0" data-live-search="true" id="user_id" name="user_id" required>
                            <option value="0" disabled required selected>Choose...</option>
                            @if ($users)
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid User.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label col-12">Status</label>
                        <select class="form-select" id="type" name="type" required>
                            <option selected value="assigned"><i class="fa-solid fa-hourglass-start"></i> Assigned
                            </option>
                            <option selected value="ongoing"><i class="fa-solid fa-bars-progress"></i>Ongoing
                            </option>
                            <option selected value="completed"><i class="fa-solid fa-check-double">Completed
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date"
                            max="{{ $activity->end_date }}" min="{{ $activity->start_date }}" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="status" class="form-label">Status</label>
                        <div class="d-flex">
                            <div class="form-check mx-2"><input class="form-check-input" type="radio" value='2'
                                    name="status" id="status2">
                                <label class="form-check-label" for="status2">
                                    Not Completed
                                </label>
                            </div>
                            <div class="form-check mx-2"><input class="form-check-input" type="radio" value='1'
                                    name="status" id="status1">
                                <label class="form-check-label" for="status1">
                                    Completed
                                </label>
                            </div>
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="radio" name="status" id="status0"
                                    value='' checked>
                                <label class="form-check-label" for="status0">
                                    Unverified
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="priority" class="form-label">Priority</label>
                        <div class="d-flex">
                            <div class="form-check mx-2"><input class="form-check-input" type="radio"
                                    value='2' name="priority" id="priority2">
                                <label class="form-check-label" for="priority2">
                                    Urgent
                                </label>
                            </div>
                            <div class="form-check mx-2"><input class="form-check-input" type="radio"
                                    value='1' name="priority" id="priority1" checked>
                                <label class="form-check-label" for="priority1">
                                    Normal
                                </label>
                            </div>
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="radio" name="priority" id="priority0"
                                    value='0'>
                                <label class="form-check-label" for="priority0">
                                    Low
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a description" id="description" name="description"
                                style="height: 100px" required></textarea>
                            <label for="description">Description</label>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center col-12 ">
                        <button class="btn btn-primary mx-3" id="submitBtn" type="submit">Submit</button>
                        <button class="btn btn-danger mx-3" id="deleteBtn" type="button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#new").on("click", function() {
            $('#id').val(0);
            $('#name').val("");
            $('#user_id').val(0);
            $('#user_id').trigger('change');
            $('#end_date').val("");
            $("#status0").prop('checked', true);
            $("#priority1").prop('checked', true);
            $('#type').val('assigned');
            $('#description').val("");

            $("#method-type").val("POST");
            $('#form').attr('action', host+'/tasks');

            $("#deleteBtn").hide();
            $("#completeBtn1").hide();
            $("#undoBtn").hide();
            $('#new-task-modal').modal('show');
        });

        $("#deleteBtn").on("click", function() {
            let check = confirm("Confirm Delete");
            if (check) {
                $("#method-type").val("DELETE");
                $('#form').attr('action', host + '/tasks/' + $('#id').val());
            }
        });
    });
</script>
