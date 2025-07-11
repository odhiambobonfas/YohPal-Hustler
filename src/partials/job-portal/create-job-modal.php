<!-- create job modal -->
<form class="create-job-modal-form" action="/job/create/<?= htmlspecialchars($category['slug']) ?>" method="post">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-job-modal">Create Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name">Job Title:</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Enter job name" required>
                </div>
                <div class="mb-3">
                    <label for="hustlersCount">Number of Hustler:</label>
                    <input type="number" class="form-control" min="0" max="100" name="hustlersCount" id="hustlersCount" aria-describedby="helpId" placeholder="Enter number of hustlers, eg. 10" required value="0">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="startDateTime" class="form-label">Start</label>
                        <input type="text" id="startDateTime" name="startDateTime" class="form-control fpRangeDate datetime-range" placeholder="Select start datetime">
                    </div>
                    <div class="col-md-6">
                        <label for="endDateTime" class="form-label">End</label>
                        <input type="text" id="endDateTime" name="endDateTime" class="form-control fpRangeDate datetime-range" placeholder="Select end datetime">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description">Job Description:</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter job description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger btn-sm create-job-submit-btn" id="create-job-submit-btn"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Submit Job</button>
            </div>
        </div>
    </div>
</form>