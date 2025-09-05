<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- Ensure Bootstrap CSS is included -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<aside class="col-md-2" id="sidebar">
    <div class="card bg-transparent border-0">
        <?php include 'partials/layout/crm/sidebar.php'; ?>
    </div>
</aside>
<div class="jobs-main-container">
    <div id="filterControls" style="grid-area: controls;"></div>

    <div class="jobs-sidebar" style="grid-area: sidebar;">
        <ul class="jobs-list" id="jobs-list">
            <!-- Activities will be loaded here dynamically -->
        </ul>
        <div class="jobs-no-activities" id="jobs-no-activities" style="display: none;">
            <p>No activities available.</p>
        </div>
    </div>

    <div class="jobs-details-panel" id="jobs-details-content" style="grid-area: details;"></div>
</div>

<!-- Bootstrap Modal for Invoice -->
<div class="modal" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoiceModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="reportIssueBtn" style="background: white; color: #FF0000; font-weight: bold; border: none">Report Issue</button>
                <button type="button" class="btn btn-primary" id="downloadReceiptBtn" style="background: white; color: #FF0000; font-weight: bold; border: none">Download Receipt</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #FF0000!important; border: none">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Ensure Bootstrap JS is included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
