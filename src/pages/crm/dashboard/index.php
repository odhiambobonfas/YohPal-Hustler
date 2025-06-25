<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/dashboard.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section mt-5">
    <div class="d-flex gap-3">
        <!-- Sidebar -->
        <aside class="col-md-2 d-none d-md-block" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1 mt-3 bg-light">
            <div class="card bg-transparent border-0 m-3">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center bg-white rounded p-2 mb-3">
                    <h4 class="m-0">
                        <span id="sidebarToggleBtn" class="me-2"><i class="fas fa-bars fw-bold"></i></span>
                        Dashboard
                    </h4>
                    <div>
                        <a href="/dashboard" class="text-dark me-2"><i class="fas fa-home"></i></a>
                        <button class="btn btn-sm border-info rounded-pill">
                            <span class="badge text-dark">Home Dashboard</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="card bg-white border-0 rounded mb-3">
                    <div class="stats-grid d-flex justify-content-around p-5 gap-3">
                        <?php
                        foreach ($stats as $stat): ?>
                            <div class="stat-card <?= $stat['class'] ?>">
                                <svg class="progress-ring">
                                    <circle class="progress-ring-bg" cx="40" cy="40" r="36"></circle>
                                    <circle class="progress-ring-fill" cx="40" cy="40" r="36" stroke-dasharray="<?= $stat['dash'] ?> 200"></circle>
                                </svg>
                                <div class="stat-number"><?= $stat['value'] ?></div>
                                <div class="stat-label"><?= $stat['label'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Stats Section -->

                <!-- Graphical stats -->
                <div class="card bg-white border-0 rounded mb-3">
                    <div class="chart-header m-3">
                        <h3 class="chart-title">Job status Details</h3>
                    </div>
                    <div class="d-flex justify-content-between p-5 gap-1">
                        <div class="col-8">

                            <canvas id="earningsChart" class="earningsChart"></canvas>

                            <div class="row mt-4 g-3">
                                <div class="col-md-4">
                                    <div class="side-stat">
                                        <i class="fas fa-clipboard-list fs-4" style="color: #fdcb6e;"></i>
                                        <div>
                                            <div class="number" style="color: #fdcb6e;">3,845</div>
                                            <div class="label">Total Posts</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="side-stat">
                                        <i class="fas fa-users fs-4" style="color: #00b894;"></i>
                                        <div>
                                            <div class="number" style="color: #00b894;">1,520</div>
                                            <div class="label">New Monthly</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="side-stat">
                                        <i class="fas fa-share fs-4" style="color: #0984e3;"></i>
                                        <div>
                                            <div class="number" style="color: #0984e3;">915</div>
                                            <div class="label">Profile Views</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-cards col-4">
                            <div class="info-card job-seekers">
                                <div class="val">69</div>
                                <div class="cont">
                                    <h3>Total Job Seekers</h3>
                                    <p>A comprehensive view of all registered job seekers on the platform.</p>
                                </div>
                            </div>
                            <div class="info-card job-providers">
                                <div class="val">104</div>
                                <div class="cont">
                                    <h3>Total Job Providers</h3>
                                    <p>A small river named Duden flows by their place and supplies necessary.</p>
                                </div>
                            </div>
                            <div class="info-card active-listings">
                                <div class="val">80</div>
                                <div class="cont">
                                    <h3>Active Listings</h3>
                                    <p>Active and more recovery and editing.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Graphical stats -->

                <!-- Recent Activities -->
                <div class="card bg-white border-0 rounded shadow-sm mb-4">
                    <div class="p-4">
                        <!-- Table Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Recent Activities</h5>
                            <div class="d-flex align-items-center gap-2">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="checkbox" id="select-all-checkbox">
                                    <label class="form-check-label" for="select-all-checkbox">Select All</label>
                                </div>
                                <button class="btn btn-sm btn-outline-danger" disabled>Bulk Delete</button>
                            </div>
                        </div>

                        <!-- Activities Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" disabled style="visibility: hidden;"></th>
                                        <th>Actions</th>
                                        <th>ID</th>
                                        <th>Company</th>
                                        <th>Posted</th>
                                        <th>Expires</th>
                                        <th>Position</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Repeatable Row -->
                                    <tr>
                                        <td>
                                            <div class="dropdown open">
                                                <button class="btn btn-outline-danger dropdown-toggle btn-sm" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    <button class="dropdown-item" href="#">Edit</button>
                                                    <button class="dropdown-item" href="#">View</button>
                                                    <button class="dropdown-item" href="#">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="checkbox" class="form-check-input row-checkbox"></td>
                                        <td>1</td>
                                        <td>Progress Indicator</td>
                                        <td>04.06.2025</td>
                                        <td>30.06.2025</td>
                                        <td>Art Designer</td>
                                        <td>New York</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="dropdown open">
                                                <button class="btn btn-outline-danger dropdown-toggle btn-sm" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    <button class="dropdown-item" href="#">Edit</button>
                                                    <button class="dropdown-item" href="#">View</button>
                                                    <button class="dropdown-item" href="#">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="checkbox" class="form-check-input row-checkbox"></td>
                                        <td>2</td>
                                        <td>Tandem Time Inc</td>
                                        <td>05.06.2025</td>
                                        <td>24.07.2025</td>
                                        <td>iOS Developer</td>
                                        <td>Houston</td>
                                        <td><span class="badge bg-warning text-dark">Ongoing</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="dropdown open">
                                                <button class="btn btn-outline-danger dropdown-toggle btn-sm" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    <button class="dropdown-item" href="#">Edit</button>
                                                    <button class="dropdown-item" href="#">View</button>
                                                    <button class="dropdown-item" href="#">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="checkbox" class="form-check-input row-checkbox"></td>
                                        <td>3</td>
                                        <td>BlueChip Expenses</td>
                                        <td>02.06.2025</td>
                                        <td>15.07.2025</td>
                                        <td>Project Manager</td>
                                        <td>Jacksonville</td>
                                        <td><span class="badge bg-secondary">Pending</span></td>
                                    </tr>
                                    <!-- Hidden Rows -->
                                    <tr class="d-none">
                                        <td>
                                            <div class="dropdown open">
                                                <button class="btn btn-outline-danger dropdown-toggle btn-sm" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    <button class="dropdown-item" href="#">Edit</button>
                                                    <button class="dropdown-item" href="#">View</button>
                                                    <button class="dropdown-item" href="#">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="checkbox" class="form-check-input row-checkbox"></td>
                                        <td>7</td>
                                        <td>NextGen Corp</td>
                                        <td>28.05.2025</td>
                                        <td>10.07.2025</td>
                                        <td>Data Analyst</td>
                                        <td>Chicago</td>
                                        <td><span class="badge bg-secondary">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Widgets Section -->
                    <div class="border-top p-4 bg-light">
                        <div class="row g-4">
                            <!-- Widget Card -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">🔗 Link to this Job</h6>
                                        <p class="small">Select and copy the link below (For this specific job posting page):</p>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="https://jobrick.do/job/post" id="jobLink" readonly>
                                            <button class="btn btn-outline-danger" type="button" onclick="navigator.clipboard.writeText(document.getElementById('jobLink').value)">Copy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Widget Card -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">📊 Use the Button Widget</h6>
                                        <p class="small">Put the code below in your site where you want the buttons to appear:</p>
                                        <div class="input-group">
                                            <textarea class="form-control" id="embedCode" rows="1" placeholder="<embed-code>" readonly>&lt;script src="widget.js"&gt;&lt;/script&gt;</textarea>
                                            <button class="btn btn-outline-danger" type="button" onclick="navigator.clipboard.writeText(document.getElementById('embedCode').value)">Copy</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Widget Card -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">📧 Upload Resumes by Email</h6>
                                        <p class="small mb-0">Set up an auto-forward rule from your email to collect incoming resumes:</p>
                                        <strong class="text-primary">resume@easyapply.co</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Recent Activities -->

                <!-- Map section -->
                <div class="container-fluid bg-white rounded shadow-sm p-3 mb-4">
                    <!-- Hustle Categories -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div class="d-flex flex-wrap gap-2 overflow-auto">
                            <button class="btn btn-outline-primary btn-sm">All</button>
                            <?php foreach ($hustleCategories as $category): ?>
                                <button class="btn btn-outline-danger btn-sm <?= $category['id'] ?>" id="<?= $category['id'] ?>"><?= $category['name'] ?></button>
                            <?php endforeach; ?> 
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="position-relative rounded overflow-hidden border" style="height: 400px; background-color: #f2f2f2;">
                        <div id="services-map" class="d-flex align-items-center justify-content-center h-100 text-muted">
                            Map Placeholder (Google Maps API not included)
                        </div>
                        
                        <div class="position-absolute top-50 start-50 translate-middle text-dark bg-white px-3 py-1 rounded shadow-sm">
                            <small>📍 Current Location</small>
                        </div> 

                        <div class="position-absolute bottom-0 start-0 m-3">
                            <button class="btn btn-outline-dark btn-sm d-flex align-items-center gap-1">
                                <i class="material-icons">my_location</i> Locate
                            </button>
                        </div>
                        
                        <div class="position-absolute bottom-0 end-0 m-3 d-flex flex-column gap-2">
                            <button class="btn btn-outline-dark btn-sm"><i class="material-icons">zoom_in</i></button>
                            <button class="btn btn-outline-dark btn-sm"><i class="material-icons">zoom_out</i></button>
                        </div>
                        
                        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 text-muted small">
                            © 2025 Map Provider
                        </div>
                    </div>
                </div>
                <!-- /Map section -->
            </div>
        </main>
    </div>
</div>

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/dashboard.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->