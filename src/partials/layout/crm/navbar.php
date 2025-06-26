<!-- Header / Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light scrollStickyNav" style="z-index: 9999;">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <img src="https://yohpals.com/img/favicon.png" alt="Logo" class="img-fluid logo-resize">
            <span class="fw-bold"><?= env('APP_NAME') ?></span>
            <i class="fas fa-screwdriver-wrench text-secondary"></i>
        </a>

        <!-- Search Form -->
        <form class="d-none d-md-flex flex-grow-1 justify-content-center px-3 w-50">
            <input class="form-control form-control-sm me-2 w-100" type="search" placeholder="Search here..." aria-label="Search">
            <button class="btn btn-danger btn-sm" type="submit">Search</button>
        </form>

        <!-- Toggler for Mobile -->
        <div class="d-lg-none d-md-none d-sm-inline ms-auto flex-row dropdown">
            <button class="btn btn-link tdl-0 dropdown-toggle" type="button" id="navbarDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-list fa-2x"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownToggle">
                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" target="_blank" href="https://chat.yohpal.com"><i class="fas fa-inbox me-2"></i>Live Chat</a></li>
                <li><a class="dropdown-item" target="_blank" href="https://wallet.yohpal.com"><i class="bi bi-wallet2 me-2"></i>Wallet</a></li>
                <li><a class="dropdown-item" href="/auth/settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><a class="dropdown-item" href="/auth/privacy"><i class="bi bi-shield-lock me-2"></i>Privacy</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item searchToggle" id="searchToggle" href="javascript:void(0)"><i class="fas fa-search me-2"></i>Search</a></li>
                <?php
                if (empty(auth()->user())) { ?>
                    <li><a class="dropdown-item" href="/auth"><i class="bi bi-person-plus me-2"></i>Register</a></li>
                    <li><a class="dropdown-item" href="/auth"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                <?php
                }
                ?>
                <?php
                if (!empty(auth()->user())) { ?>
                    <li><a class="btn dropdown-item logout-btn" href="javascript:void(0)"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                <?php
                }
                ?> 
            </ul>
        </div>

        <!-- Right Menu -->
        <div class="d-none d-md-inline justify-content-end">
            <ul class="navbar-nav align-items-center mb-2 mb-lg-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fa fa-envelope fa-2x text-secondary"></i>
                        <sup class="count-badge text-danger">0</sup>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell fa-2x text-secondary"></i>
                        <sup class="count-badge text-warning">0</sup>
                    </a>
                </li>
                <li class="nav-item dropdown d-none d-md-flex align-items-center">
                    <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" alt="Profile"
                            class="rounded-circle me-2" width="36" height="36">
                        <span class="fw-semibold">
                            <?= !empty(auth()->user()) ? auth()->user()->firstName : 'Account' ?>
                            <?= !empty(auth()->user()) ?  auth()->user()->lastName : null ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" target="_blank" href="https://chat.yohpal.com"><i class="fas fa-inbox me-2"></i>Live Chat</a></li>
                        <li><a class="dropdown-item" target="_blank" href="https://wallet.yohpal.com"><i class="bi bi-wallet2 me-2"></i>Wallet</a></li>
                        <li><a class="dropdown-item" href="/settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="/privacy"><i class="bi bi-shield-lock me-2"></i>Privacy</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php if (empty(auth()->user())) { ?>
                            <li><a class="dropdown-item" href="/auth"><i class="bi bi-person-plus me-2"></i>Register</a></li>
                            <li><a class="dropdown-item" href="/auth"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                        <?php } ?>
                        <?php if (!empty(auth()->user())) { ?>
                            <li><a class="btn dropdown-item logout-btn" href="javascript:void(0)"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>