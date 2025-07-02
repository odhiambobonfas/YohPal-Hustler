<!-- Header / Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light scrollStickyNav" style="z-index: 9999;">
    <div class="d-flex align-items-center justify-content-between w-100 ms-3 me-3">
        <!-- Left Section: Brand and Search -->
        <div class="d-flex align-items-center w-100 gap-3">
            <!-- Brand and Icon -->
            <div class="d-flex align-items-center gap-4">
                <a class="navbar-brand d-flex align-items-center gap-2 mb-0" href="/">
                    <img src="https://yohpals.com/img/favicon.png" alt="Logo" class="img-fluid logo-resize" style="height: 32px;">
                    <span class="fw-bold mb-0"><?= env('APP_NAME') ?></span>
                </a>
                <i class="fas fa-screwdriver-wrench text-secondary"></i>
            </div>

            <!-- Search Form (Desktop only) -->
            <form class="d-none d-md-flex align-items-center flex-grow-1 px-2">
                <div class="input-group input-group-sm w-50">
                    <button class="btn btn-outline-light border-dark text-dark p-2" type="submit"><i class="fas fa-search ms-2 me-2"></i></button>
                    <input type="search" class="form-control border-dark p-2" placeholder="Search here..." aria-label="Search">
                </div>
            </form>
        </div>

        <!-- Toggler for Mobile -->
        <div class="d-lg-none d-md-none d-sm-inline ms-auto dropdown">
            <button class="btn btn-link tdl-0 dropdown-toggle" type="button" id="navbarDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-list fa-2x"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownToggle">
                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" target="_blank" href="https://chat.yohpal.com"><i class="fas fa-inbox me-2"></i>Live Chat</a></li>
                <li><a class="dropdown-item" target="_blank" href="https://wallet.yohpal.com"><i class="bi bi-wallet2 me-2"></i>Wallet</a></li>
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
            <ul class="navbar-nav align-items-center mb-2 mb-lg-0 gap-2">
                <li class="nav-item text-nowrap">
                    <a class="nav-link active" href="#">
                        <i class="fa fa-envelope fa-2x text-secondary"></i>
                        <sup class="count-badge text-danger">0</sup>
                    </a>
                </li>
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell fa-2x text-secondary"></i>
                        <sup class="count-badge text-warning">0</sup>
                    </a>
                </li>
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="#">
                        <img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" alt="Profile" class="rounded-circle me-2" width="36" height="36">
                        <span class="fw-semibold">
                            <?= !empty(auth()->user()) ? (!empty(auth()->user()->firstName) ? auth()->user()->firstName : auth()->user()->email) : 'Account' ?>
                            <?= !empty(auth()->user()) ?  auth()->user()->lastName : null ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown d-none d-md-flex align-items-center">
                    <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list fa-2x"></i>
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