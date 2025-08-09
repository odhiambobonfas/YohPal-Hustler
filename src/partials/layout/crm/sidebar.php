<?php
function isActive($href) {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $href ? 'active' : '';
}
?>

<!-- Sidebar -->
<div class="sidebar" role="tablist">
    <!-- Core Navigation -->
    <div class="sidebar-section core-navigation">
        <h1>Core</h1>

        <a href="<?= $dash = auth()->hustlerStatus()->isHustler ? '/hustler/dashboard' : '/dashboard' ?>"
           class="sidebar-item d-flex align-items-center gap-2 text-decoration-none <?= isActive($dash) ?>">
            <i class="fa-brands fa-windows"></i> Dashboard
        </a>

        <a href="<?= $profile = auth()->hustlerStatus()->isHustler ? '/hustler/profile' : '/profile' ?>"
           class="sidebar-item d-flex align-items-center gap-2 text-decoration-none <?= isActive($profile) ?>">
            <i class="fas fa-th-large icon"></i> Profile
        </a>

        <?php if (!auth()->user()->hustlerStatus): ?>
            <a href="/onboarding/hustler"
               class="sidebar-item d-flex align-items-center gap-2 text-decoration-none text-danger <?= isActive('/onboarding/hustler') ?>">
                <i class="fa-solid fa-user-nurse"></i> Become A Hustler
            </a>
        <?php endif; ?>

        <?php if (!auth()->hustlerStatus()->isHustler): ?>
            <a href="/job-portal"
               class="sidebar-item d-flex align-items-center gap-2 text-decoration-none <?= isActive('/job-portal') ?>">
                <i class="fas fa-briefcase icon"></i> Job Portal
            </a>
        <?php endif; ?>
    </div>

    <!-- Communication -->
    <div class="sidebar-section communication">
        <h3>Communication</h3>
        <div class="sidebar-item <?= isActive('/messages') ?>"
             data-tab="messages" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-envelope icon"></i> Messages
        </div>
        <div class="sidebar-item <?= isActive('/contacts') ?>"
             data-tab="contacts" role="tab" aria-selected="false" tabindex="0">
            <i class="fas fa-address-book icon"></i> Contacts
        </div>
    </div>

    <hr>
    <!-- Session -->
    <div class="sidebar-section session">
        <div class="ms-3">
            <button class="btn btn-link logout logout-btn" id="logout-nav">
                <i class="fas fa-sign-out-alt icon"></i> Logout
            </button>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
