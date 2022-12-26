<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Activity Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" class="row g-3 needs-validation" action=""
                    method="POST" novalidate>

                    @csrf
                    <div class="col-md-12">
                        <label for="name" class="form-label">Activity Name</label>
                        <input type="hidden" class="form-control" id="id" name="id" value="0"
                            required>
                        <input type="hidden" id="method-type" name="_method" value="">
                        <input type="hidden" class="form-control" id="project_id" name="project_id"
                            value="{{ $project->id }}" required>

                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">

                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            min='{{ $project->start_date }}' max='{{ $project->end_date }}' required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            min='{{ $project->start_date }}' max='{{ $project->end_date }}' required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-6" id="userlist-holder">
                        <label for="user_id" class="form-label">Supervisor</label>
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

                        <button class="btn btn-danger mx-3" id="deleteBtn">Delete</button>
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
            $('#user_id').val("0");
            $('#end_date').val("");
            $("#status").val(0);
            $('#type').val('assigned');
            $('#description').val("");
            $("#deleteBtn").hide();
            $('#user_id').val(0);
            $('#user_id').trigger('change');

            $("#method-type").val("POST");
            $('#form').attr('action', host+'/activities');

            $("#completeBtn1").hide();
            $("#undoBtn").hide();
            $('#modal').modal('show');
        });


        $("#deleteBtn").on("click", function () {
        let check = confirm("Confirm Delete");
        if (check) {
            $("#method-type").val("DELETE");
            $('#form').attr('action', host+'/activities/'+$('#id').val());
        }
    });
    });
</script>
