<!-- Sidebar sits in here -->

<!-- Sidebar -->
<div class="sidebar" role="tablist">
    <!-- Core Navigation -->
    <div class="sidebar-section core-navigation">
        <h1>Core</h1>
        <div class="sidebar-item active" data-tab="dashboard" role="tab" aria-selected="true" tabindex="0">
            <img src="<?= asset_url('store/images/icons/dash.png') ?>" alt="Dashboard Icon"> Dashboard
        </div>
        <div class="sidebar-item" data-tab="profile" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-th-large"></i> Profile
        </div>
    </div>

    <!-- Career Management -->
    <div class="sidebar-section career-management">
        <h3>Career</h3>
        <div class="sidebar-item" data-tab="job-portal" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-briefcase"></i> Job Portal
        </div>
        <div class="sidebar-item" data-tab="applications" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-file-alt"></i> Applications
        </div>
        <div class="sidebar-item" data-tab="analytics" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-chart-line"></i> Analytics
        </div>
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

    <!-- Administration -->
    <div class="sidebar-section administration">
        <h3>Administration</h3>
        <div class="sidebar-item" data-tab="user-management" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-users"></i> User Management
        </div>
        <div class="sidebar-item" data-tab="reports" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-chart-bar"></i> Reports
        </div>
        <div class="sidebar-item" data-tab="settings" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-cog"></i> Settings
        </div>
    </div>

    <!-- Session -->
    <div class="sidebar-section session">
        <div class="btn btn-link sidebar-item logout logout-btn" id="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </div>
    </div>
</div>