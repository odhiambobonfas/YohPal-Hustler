<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: ?url=");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YohPal Hustler App</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom styles -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./assets/css/dashboard.css">

    <!-- adding icon -->
    <link rel="icon" href="./assets/logos/logo_circular.png" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=YohPal+Sans:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="./assets/logos/logo_no_background.png" alt="YohPal Logo" height="24"
                    class="profile_image p-1">
                <span class="fw-bold">YohPal Hustler Platform</span>
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Find Service</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdownDocumentation"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownDocumentation">
                            <li><a class="dropdown-item" href="#">Maps SDKs</a></li>
                            <li><a class="dropdown-item" href="#">Routes APIs</a></li>
                            <li><a class="dropdown-item" href="#">Places APIs</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center ms-auto">
                <div class="input-group input-group-sm me-3 custom-search-input">
                    <input type="text" class="form-control border-0" placeholder="Search" aria-label="Search">
                    <span class="input-group-text bg-white border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </span>
                </div>
                <!-- HTML -->
                <!-- Profile Dropdown -->
                <div class="dropdown profile-dropdown">
                    <img src="./assets/images/people/img1.jpg" class="profile_image dropdown-toggle" alt="Profile"
                        height="32" data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>


            </div>
        </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-auto ms-4">
                <button class="btn btn-danger fw-bold me-2">Become a Hustler</button>
                <button class="btn btn-outline-secondary fw-bold">Contact Support</button>
            </div>
        </div>

        <div class="row justify-content-center text-center mt-5 mb-5 py-5">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold">YohPal Hustler <br> Platform</h1>
                <p class="mt-4 custom-blue-btn">Find all the services you need!</p>
            </div>
        </div>
    </div>

    <div id="cookie-banner" class="cookie-banner fixed-bottom py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <p class="mb-0 text-dark me-2">
                hustle.YohPal.com uses cookies to deliver and enhance the quality of its services. If you agree, cookies
                are also used to serve advertising and personalize content.
                <a href="#" class="text-decoration-underline text-danger">Learn more.</a>
            </p>
            <div class="d-flex">
                <button id="agree-cookie" class="btn btn-danger btn-sm fw-bold me-2 px-4">Agree</button>
                <button id="no-thanks-cookie" class="btn btn-light btn-sm text-dark fw-bold px-4">No thanks</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="./assets/js/dashboard.js"></script>

</body>

</html>