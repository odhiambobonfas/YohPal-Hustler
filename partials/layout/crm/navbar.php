<!-- Header / Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="z-index: 9999;">
    <div class="d-flex align-items-center justify-content-between w-100 ms-3 me-3">
        <!-- Left Section: Brand and Search -->
        <div class="d-flex align-items-center w-100 gap-3">
            <!-- Brand and Icon -->
            <div class="d-flex align-items-center gap-4">
                <i class="fas fa-bars text-dark menu-toggle" style="cursor: pointer; font-size: 24px; padding: 10px;"></i>
                <a class="navbar-brand d-flex align-items-center gap-2 mb-0" href="/">
                    <img src="<?= asset_url('/store/logos/logo_circular.png') ?>" alt="YohPal Logo" class="img-fluid logo-resize" style="height: 32px;">
                    <span class="fw-bold mb-0 brandname"><?= env('APP_NAME') ?></span>
                </a>
            </div>

            <!-- Search Form (Desktop only) -->
            <form class="d-none d-md-flex align-items-center flex-grow-1 px-2">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-bar" placeholder="Search">
                </div>
            </form>
        </div>

        <!-- Toggler for Mobile -->
        <div class="d-lg-none d-md-none d-sm-inline ms-auto dropdown">
            <button class="btn btn-link tdl-0 dropdown-toggle" type="button" id="navbarDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user " style="font-size: 16px; color: gray; background-color: #fff; padding: 6px; border-radius: 50%; border: 1px solid gray"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownToggle">
                <li>
                    <a class="dropdown-item" href="<?= isset(auth()->hustlerStatus()->isHustler) ? '/hustler/profile': '/profile' ?>">
                    <i class="fas fa-user me-2"></i>Profile</a>
                </li>
                <li><a class="dropdown-item" href="/settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><a class="dropdown-item" href="/privacy"><i class="bi bi-shield-lock me-2"></i>Privacy</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
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
            <ul class="navbar-nav align-items-center mb-2 mb-lg-0 gap-3">
                <div style="position: relative; cursor: pointer;">
                    <i class="fa fa-envelope"></i>
                    <div class="notification-dot"></div>
                </div>
                <div style="position: relative; cursor: pointer;">
                    <i class="fas fa-bell"></i>
                    <div class="notification-dot"></div>
                </div>
                <li class="nav-item dropdown d-none d-md-flex align-items-center">
                    <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= !empty(auth()->user()->profile_picture) ? auth()->user()->profile_picture :asset_url('store/images/avatars/default-avatar.jpg') ?>" alt="Profile" class="rounded-circle me-2" width="36" height="36">
                        <span class="fw-semibold">
                            <?= !empty(auth()->user()) ? (!empty(auth()->user()->firstName) ? auth()->user()->firstName : auth()->user()->email) : 'Account' ?>
                            <?= !empty(auth()->user()) ?  auth()->user()->lastName : null ?>
                        </span>
                        <i class="fa fa-sort-down icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?= isset(auth()->hustlerStatus()->isHustler) ? '/hustler/profile': '/profile' ?>">
                                <i class="fas fa-user me-2"></i>Profile</a>
                        </li>
                        <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php if (empty(auth()->user())) { ?>
                            <li><a class="dropdown-item" href="/auth"><i class="bi bi-person-plus me-2"></i>Register</a></li>
                            <li><a class="dropdown-item" href="/auth"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                        <?php } ?>
                        <?php if (!empty(auth()->user())) { ?>
                        <li><button class="btn dropdown-item" id="logout-nav">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout</button></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
