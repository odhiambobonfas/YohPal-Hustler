<!-- Sidebar sits in here -->

<!-- Sidebar -->
<div class="sidebar" role="tablist">
    <!-- Core Navigation -->
    <div class="sidebar-section core-navigation">
        <h1>Core</h1>
        <a href="/dashboard" class="sidebar-item d-flex align-items-center gap-2 text-decoration-none active">
            <img src="<?= asset_url('store/images/icons/dash.png') ?>" alt="Dashboard Icon"> Dashboard
        </a>
        <a href="/profile" class="sidebar-item d-flex align-items-center gap-2 text-decoration-none">
            <i class="fas fa-th-large"></i> Profile
        </a>
    </div>

    <!-- Career Management -->
    <div class="sidebar-section career-management">
        <h3>Career</h3>
        <a href="/job-portal" class="sidebar-item d-flex align-items-center gap-2 text-decoration-none">
            <i class="fas fa-briefcase"></i> Job Portal
        </a>
        <a href="/applications" class="sidebar-item d-flex align-items-center gap-2 text-decoration-none">
            <i class="fas fa-file-alt"></i> Applications
        </a>
        <a href="/analytics" class="sidebar-item d-flex align-items-center gap-2 text-decoration-none">
            <i class="fas fa-chart-line"></i> Analytics
        </a>
    </div>

    <!-- Communication -->
    <div class="sidebar-section communication">
        <h3>Communication</h3>
        <div class="sidebar-item" data-tab="messages" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-envelope"></i> Messages
        </div>
        <div class="sidebar-item" data-tab="contacts" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-address-book"></i> Contacts
        </div>
    </div>

    <!-- Communication -->
    <div class="sidebar-section communication">
        <h3>Administration</h3>
        <div class="sidebar-item" data-tab="users" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-envelope"></i> Users
        </div>
        <div class="sidebar-item" data-tab="reports" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-address-book"></i> Reports
        </div>
        <div class="sidebar-item" data-tab="settings" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-cog"></i> Settings
        </div>
    </div>

    <hr>
    <!-- Session -->
    <div class="sidebar-section session">
        <div class="ms-3">
            <div class="btn btn-link logout logout-btn" id="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </div>
        </div>
    </div>
</div>