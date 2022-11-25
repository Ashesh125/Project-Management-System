
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
                <label for="task-type" class="form-label">Progress</label>
                <input type="text" id="task-type" class="form-control" disabled>
            </div>
            <div class="mb-3">
                <label for="task-status" class="form-label">Status</label>
                <input type="text" id="task-status" class="form-control" disabled>
            </div>
            <div class="mb-3">
                <a id="goto-task" href="">Goto Task<a>
            </div>
        </div>
    </div>
