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

    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -250px;
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1049;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="./assets/logos/logo_no_background.png" alt="YohPal Logo" height="24"
                    class="profile_image p-1">
                <span class="fw-bold">YohPal Hustler Platform</span>
            </a>
            <svg width="30" height="30" onclick="toggleSidebar()" class="hamburger" viewBox="0 0 100 100">
                <path class="line line1"
                    d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                <path class="line line2" d="M 20,50 H 80" />
                <path class="line line3"
                    d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
            </svg>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">My Bookings</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="?url=find_service">Find Service</a>
                    </li>
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

    <!-- side navigation -->
    <div id="sidebar" class="sidebar bg-white border-end shadow">
        <div class="header-cont "
            style="background: url(assets/images/people/img3.jpg); background-position: center; background-repeat: no-repeat; background-size: cover; color: white;">
            <div class="cover-transparent p-3" style="background: rgba(0, 0, 0, 0.7); ">
                <div class="d-flex justify-content-end align-items-end">

                    <div class="text-end close-button d-flex justify-content-center align-items-center">

                        <svg width="20" height="20" onclick="toggleSidebar()" viewBox="0 0 100 100">
                            <line x1="20" y1="20" x2="80" y2="80" stroke="white" stroke-width="10"
                                stroke-linecap="round" />
                            <line x1="80" y1="20" x2="20" y2="80" stroke="white" stroke-width="10"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
                <img src="./assets/images/people/img1.jpg" class="profile_image dropdown-toggle mt-2" style="top:0;"
                    alt="Profile" height="32" data-bs-toggle="dropdown">
                <p class="my-1 fw-bold">email@yohpal.com</p>
            </div>


        </div>

        <ul class="list-unstyled p-4">
            <li class="sidebar_li_item "><a href="#" class="d-block py-2 fw-bold sidebar_item active_sidebar">Home</a></li>
            <li class="sidebar_li_item"><a href="#" class="d-block py-2 fw-bold sidebar_item">About</a></li><hr>
            <li class="sidebar_li_item"><a href="#" class="d-block py-2 fw-bold sidebar_item">Profile</a></li>
            <li class="sidebar_li_item"><a href="#" class="d-block py-2 fw-bold sidebar_item">Settings</a></li>
            <li class="sidebar_li_item"><a href="#" class="d-block py-2 fw-bold sidebar_item">My Bookings</a></li><hr>
            <li class="sidebar_li_item"><a href="?url=find_service" class="d-block py-2 fw-bold sidebar_item">Find Service</a></li>
            <li class="sidebar_li_item"><a href="#" class="d-block py-2 fw-bold sidebar_item">Categories</a></li> <hr>
            <li class="sidebar_li_item"><a href="logout.php" class="d-block py-2 btn btn-danger fw-bold ">Logout</a></li>
        </ul>
    </div>

    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="./assets/js/dashboard.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Close sidebar if overlay is clicked
        document.getElementById('sidebar-overlay').addEventListener('click', () => {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('sidebar-overlay').classList.remove('show');
        });
    </script>

</body>

</html>