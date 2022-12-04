<div class="offcanvas offcanvas-end" id="offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Task Detail</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label for="task-name" class="form-label">Name</label>
            <input type="text" id="task-name" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label for="task-activity" class="form-label">Of Activity</label>
            <input type="text" id="task-activity" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label for="task-user" class="form-label">Assigned To</label>
            <input type="text" id="task-user" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label for="task-due-date" class="form-label">Due Date</label>
            <input type="date" id="task-due-date" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <div class="form-floating">
                <textarea class="form-control h-100" id="task-description" rows='5' disabled></textarea>
                <label for="task-description">Description</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="task-status" class="form-label">Status</label>
            <input type="text" id="task-status" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <form id="form" class="row g-3 needs-validation" novalidate>

                @csrf
                <div class="col-md-6">
                    <input type="hidden" class="form-control" id="task-id" name="id" value="0" required />
                    <label for="type" class="form-label col-12">Status</label>
                    <select class="form-select" id="task-type" name="type" required>
                        <option selected value="assigned"><i class="fa-solid fa-hourglass-start"></i> Assigned
                        </option>
                        <option selected value="ongoing"><i class="fa-solid fa-bars-progress"></i>Ongoing
                        </option>
                        <option selected value="completed"><i class="fa-solid fa-check-double">Completed
                        </option>
                    </select>
                </div>
            </form>
        </div>
        <div class="mb-3">
            <a id="goto-task" href="">Goto Task<a>
            <a id="goto-task-2" href="">Goto Task<a>
        </div>
    </div>
</div>
