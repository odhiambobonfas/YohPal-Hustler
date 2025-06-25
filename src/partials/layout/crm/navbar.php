<!-- Header / Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-3 py-2 fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3 w-100">
            <!-- Logo Section -->
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle overflow-hidden" style="width: 40px; height: 40px;">
                    <img src="https://yohpals.com/img/favicon.png" alt="Logo" class="img-fluid">
                </div>
                <span class="fw-bold"><?= env('APP_NAME') ?></span>
                <i class="fas fa-screwdriver-wrench text-secondary ms-2"></i>
            </div>

            <!-- Search Bar -->
            <div class="input-group ms-4 w-75">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search">
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 ms-auto">
            <!-- Messages -->
            <div class="position-relative">
                <i class="fa fa-envelope fa-2x text-secondary"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle"></span>
            </div>

            <!-- Notifications -->
            <div class="position-relative">
                <i class="fas fa-bell fa-2x text-secondary"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning rounded-circle"></span>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none text-dark gap-2 dropdown-toggle"
                    id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" alt="Profile"
                        class="rounded-circle" width="36" height="36">
                    <span class="fw-semibold"><?= auth()->user()->firstName ?> <?= auth()->user()->lastName ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="/settings"><i class="bi bi-gear me-2"></i> Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger logout-btn" id="logout-btn" href="javascript:void(0)">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sidebar Toggle (for smaller screens) -->
            <button class="btn btn-outline-secondary d-lg-none">
                <i class="fa fa-bars"></i>
            </button>
        </div>

    </div>
</nav>