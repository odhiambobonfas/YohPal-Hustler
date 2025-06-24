<!-- Navbar sits in here -->
<!-- Header -->
<div class="header">
    <div class="header-left">
        <div class="logo-container">
            <div class="logo">
                <div style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    <img src="https://yohpals.com/img/favicon.png" alt="Logo">
                </div>
                <span><?= env('APP_NAME') ?></span>
            </div>
            <i class="fas fa-screwdriver-wrench"></i>
        </div>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-bar" placeholder="Search">
        </div>
    </div>
    <div class="header-right">
        <div class="header-icon me-3">
            <i class="fa fa-envelope fa-2x">
                <div class="notification-dot"></div>
            </i>
        </div>
        <div style="position: relative; cursor: pointer; me-3">
            <i class="fas fa-bell fa-2x"></i>
            <div class="notification-dot"></div>
        </div>
        <a href="javascript:void(0) me-3" class="profile">
            <div class="profile-pic"><img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" alt="Profile"></div>
            <span class="profile-name">Jane Doe</span>
            <i class="fa fa-sort-down"></i>
        </a>
        <div class="menu-toggle"><i class="fa fa-bars"></i></div>
    </div>
</div>