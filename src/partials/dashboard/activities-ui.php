<!-- /header -->



<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?><!-- header -->
<div class="crm-section">
    <aside class="col-md-2" id="sidebar">
        <div class="card bg-transparent border-0">
            <?php include 'partials/layout/crm/sidebar.php'; ?>
        </div>
    </aside>

        <div class="jobs-main-container">
            <div class="jobs-sidebar">
                <div class="jobs-sidebar-header">
                    <h3 class="jobs-sidebar-title">Recent Jobs</h3>
                    <div class="jobs-controls">
                        <label class="jobs-select-all">
                            <input type="checkbox" id="jobs-select-all-checkbox"> Select All
                        </label>
                        <button class="delete" id="jobs-delete-button" disabled>Delete</button>
                    </div>
                </div>
                <ul class="jobs-list" id="jobs-list">
                    <li data-id="1" class="active">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Progress Indicator - Art Designer</span>
                        <span class="jobs-status completed">Completed</span>
                    </li>
                    <li data-id="2">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Tandem Time Inc - iOS Developer</span>
                        <span class="jobs-status ongoing">Ongoing</span>
                    </li>
                    <li data-id="3">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>BlueChip Expenses - Project Manager</span>
                        <span class="jobs-status pending">Pending</span>
                    </li>
                    <li data-id="4">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Creative Agency - UI Designer</span>
                        <span class="jobs-status cancelled">Cancelled</span>
                    </li>
                    <li data-id="5">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Innovation Lab - UI/UX Designer</span>
                        <span class="jobs-status completed">Completed</span>
                    </li>
                    <li data-id="6">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Tech Solutions - DevOps Engineer</span>
                        <span class="jobs-status ongoing">Ongoing</span>
                    </li>
                    <li data-id="7">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>NextGen Corp - Data Analyst</span>
                        <span class="jobs-status pending">Pending</span>
                    </li>
                    <li data-id="8">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Dantech Corp - Data Analyst</span>
                        <span class="jobs-status pending">Pending</span>
                    </li>
                    <li data-id="9">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Future Tech - Software Engineer</span>
                        <span class="jobs-status cancelled">Cancelled</span>
                    </li>
                    <li data-id="10">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Green Solutions - Environmental Consultant</span>
                        <span class="jobs-status pending">Pending</span>
                    </li>
                    <li data-id="11">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Peak Performance - Fitness Coach</span>
                        <span class="jobs-status ongoing">Ongoing</span>
                    </li>
                    <li data-id="12">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Blue Horizon - Marketing Specialist</span>
                        <span class="jobs-status open">Open</span>
                    </li>
                    <li data-id="13">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Silver Lining - HR Manager</span>
                        <span class="jobs-status cancelled">Cancelled</span>
                    </li>
                    <li data-id="14">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Golden Gate Solutions - Financial Analyst</span>
                        <span class="jobs-status ongoing">Ongoing</span>
                    </li>
                    <li data-id="15">
                        <input type="checkbox" class="jobs-checkbox">
                        <span>Red Rock - Sales Representative</span>
                        <span class="jobs-status completed">Completed</span>
                    </li>
                </ul>
            </div>
            <div class="jobs-details-panel" id="jobs-details-content">
                <p>Loading job data...</p>
            </div>
        </div>
</div>
