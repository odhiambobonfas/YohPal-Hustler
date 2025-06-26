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
        <div class="accordion" id="adminSidebar">

            <!-- User Management -->
            <div class="accordion-itemborder-0">
                <h2 class="accordion-header" id="userHeading">
                    <button class="accordion-button sidebar-item ms-2 collapsed bg-white shadow-none px-3 py-2" type="button"
                        data-bs-toggle="collapse" data-bs-target="#userCollapse" aria-expanded="false"
                        aria-controls="userCollapse">
                        <i class="fas fa-users me-1"></i> User Management
                    </button>
                </h2>
                <div id="userCollapse" class="accordion-collapse collapse" aria-labelledby="userHeading"
                    data-bs-parent="#adminSidebar">
                    <div class="accordion-body ps-5 py-2">
                        <a href="/users" class="sidebar-sub-item d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-people"></i> All Users
                        </a>
                        <a href="/roles" class="sidebar-sub-item d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-person-gear"></i> Access Roles
                        </a>
                        <a href="/permissions" class="sidebar-sub-item d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock"></i> Permissions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Payment Account Management -->
            <div class="accordion-itemborder-0">
                <h2 class="accordion-header" id="paymentAccountHeading">
                    <button class="accordion-button sidebar-item ms-2 collapsed bg-white shadow-none px-3 py-2" type="button"
                        data-bs-toggle="collapse" data-bs-target="#paymentAccountCollapse" aria-expanded="false"
                        aria-controls="paymentAccountCollapse">
                        <i class="fas fa-wallet me-2"></i> A/C Management
                    </button>
                </h2>
                <div id="paymentAccountCollapse" class="accordion-collapse collapse" aria-labelledby="paymentAccountHeading"
                    data-bs-parent="#adminSidebar">
                    <div class="accordion-body ps-5 py-2">
                        <a href="/payments/accounts" class="sidebar-sub-item d-flex align-items-center gap-2 mb-2 text-decoration-none">
                            <i class="bi bi-bank"></i> List Accounts
                        </a>
                        <a href="/payments/methods" class="sidebar-sub-item d-flex align-items-center gap-2 mb-2 text-decoration-none">
                            <i class="bi bi-credit-card"></i> Payment Methods
                        </a>
                        <a href="/payments/transactions" class="sidebar-sub-item d-flex align-items-center gap-2 text-decoration-none">
                            <i class="bi bi-receipt"></i> P.Account Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="accordion-itemborder-0">
                <h2 class="accordion-header" id="reportsHeading">
                    <button class="accordion-button sidebar-item ms-2 collapsed bg-white shadow-none px-3 py-2" type="button"
                        data-bs-toggle="collapse" data-bs-target="#reportsCollapse" aria-expanded="false"
                        aria-controls="reportsCollapse">
                        <i class="fas fa-chart-bar me-2"></i> Report Management
                    </button>
                </h2>
                <div id="reportsCollapse" class="accordion-collapse collapse" aria-labelledby="reportsHeading"
                    data-bs-parent="#adminSidebar">
                    <div class="accordion-body ps-5 py-2">
                        <a href="/reports/monthly" class="sidebar-sub-item d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-calendar-month"></i> Monthly Report
                        </a>
                        <a href="/reports/yearly" class="sidebar-sub-item d-flex align-items-center gap-2">
                            <i class="bi bi-calendar3"></i> Yearly Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="accordion-itemborder-0">
                <h2 class="accordion-header" id="settingsHeading">
                    <button class="accordion-button sidebar-item ms-2 collapsed bg-white shadow-none px-3 py-2" type="button"
                        data-bs-toggle="collapse" data-bs-target="#settingsCollapse" aria-expanded="false"
                        aria-controls="settingsCollapse">
                        <i class="fas fa-cog me-2"></i> Settings
                    </button>
                </h2>
                <div id="settingsCollapse" class="accordion-collapse collapse" aria-labelledby="settingsHeading"
                    data-bs-parent="#adminSidebar">
                    <div class="accordion-body ps-5 py-2">
                        <a href="/settings/general" class="sidebar-sub-item d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-gear"></i> General Settings
                        </a>
                        <a href="/settings/payment-methods" class="sidebar-sub-item d-flex align-items-center gap-2">
                            <i class="bi bi-currency-dollar"></i> Payment Methods
                        </a>
                    </div>
                </div>
            </div>

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