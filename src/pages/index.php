<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- navbar -->
<?php include 'partials/layout/web/navbar.php'; ?>
<!-- /navbar -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/landing.css') ?>">
<!-- /styles -->

<!-- build main -->
<main class="main">
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">
                Hire the <span class="highlight">Top 3%</span><br>
                of Talent™
            </h1>
            <p class="hero-description">
                YohPal is an exclusive network of the middle and high class talents including developers, designers,
                Hustling experts, management consultants, carpenters, plumbers, electricians and more in the world.
                Top companies and talented people hire YohPal talent for their most important projects.
            </p>
            <a href="#" class="btn btn-primary" style="font-size: 1.1rem; padding: 15px 30px;">
                Hire Top Talent
            </a>
        </div>

        <div class="hero-visual">
            <div class="profile-card">
                <div class="profile-image"><img src="<?= asset_url('/store/images/app/businessman.png') ?>" alt=""></div>
            </div>
        </div>
    </div>
</main>
<!-- /main -->

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/web/landing.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->