<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="role" content="<?= !empty(auth()->user()) ? auth()->user()->role : null ?>">
    <title>YohPal Hustle</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="https://yohpals.com/img/favicon.png" />

    <!-- Bootstrap core CSS-->
    <link href="<?= asset_url('/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset_url('/bootstrap/icons/css/bootstrap-icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset_url('/bootstrap/css/bootstrap-datepicker.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url('/bootstrap/css/select2.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- animate lib -->
    <link href="<?= asset_url('/build/animation/animate/css/animate.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- font awesome lib-->
    <link href="<?= asset_url('/build/fontawesome/css/all.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- datatables css -->
    <link href="<?= asset_url('/build/jquery/css/jquery.dataTables.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- toatr css -->
    <link href="<?= asset_url('/build/toastr/css/toastr.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- printing css library -->
    <link href="<?= asset_url('/build/printjs/css/print.css') ?>" rel="stylesheet" type="text/css">

    <!-- no-ui-slider css lib -->
    <link href="<?= asset_url('build/nouislider/css/nouislider.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- Local custom css -->
    <link href="<?= asset_url('/css/global/props.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset_url('/css/global/master.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- This is the header layout for the web -->

    <!-- statuses - audio alerts -->
    <div class="no-show">
        <audio id="success-audio">
            <source src="<?= asset_url('store/audio/success.ogg') ?>" type="audio/ogg">
            <source src="<?= asset_url('store/audio/success.mp3') ?>" type="audio/mpeg">
        </audio>
        <audio id="error-audio">
            <source src="<?= asset_url('store/audio/error.ogg') ?>" type="audio/ogg">
            <source src="<?= asset_url('store/audio/error.mp3') ?>" type="audio/mpeg">
        </audio>
        <audio id="warning-audio">
            <source src="<?= asset_url('store/audio/warning.ogg') ?>" type="audio/ogg">
            <source src="<?= asset_url('store/audio/warning.mp3') ?>" type="audio/mpeg">
        </audio>
    </div>
    <!-- /statuses - audio alerts -->

    <!-- resource canvases -->
    <!-- modals --> 
    <!-- /modals -->
    <!-- resource canvases --> 