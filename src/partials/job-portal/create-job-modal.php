<!-- create job modal -->
<form action="/job/create/<?= htmlspecialchars($category['id']) ?>" method="post">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-job-modal">Create Job Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name">Job Name:</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Enter job name" required>
                </div>
                <div class="mb-3">
                    <label for="code">Job Code:</label>
                    <input type="text" class="form-control" name="code" id="code" aria-describedby="helpId" placeholder="Enter job code" required>
                </div>
                <div class="mb-3">
                    <label for="description">Job Description:</label>
                    <input type="text" class="form-control" name="description" id="description" aria-describedby="helpId" placeholder="Enter job description">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger btn-sm create-job-submit-btn" id="create-job-submit-btn"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Save</button>
            </div>
        </div>
    </div>
</form>