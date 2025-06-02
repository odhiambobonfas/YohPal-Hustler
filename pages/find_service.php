<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps - Replica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/find_service.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="icon" href="./assets/logos/logo_circular.png" type="image/x-icon">
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


            <div class="d-flex align-items-center ms-auto">

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
    <div class="map-container">
        <div class="top-bar d-flex align-items-center p-2 shadow-sm">
            <div class="d-flex align-items-center bg-white search-input-group me-3">
                <button class="btn btn-icon" id="sidebar-toggle">
                    <span class="material-icons">menu</span>
                </button>
                <input type="text" class="form-control border-0 px-2" placeholder="Search YohPal Services">
                <button class="btn btn-icon me-1">
                    <span class="material-icons">search</span>
                </button>
            </div>
            <div class="categories-scroll d-flex overflow-auto">
                <button class="btn btn-category active">House Manager</button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">restaurant</span> Personal Chef
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">hotel</span> Cleaner
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">local_attraction</span> Electrician
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">museum</span> Plumber
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">directions_bus</span> Matatu Driver
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">local_pharmacy</span> Doctor
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">atm</span> Accountant
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">lock</span> Lock Smith
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">computer</span> Software developer
                </button>
                <button class="btn btn-category">
                    <span class="material-icons me-1">book</span> Teacher
                </button>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <ul class="list-unstyled sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <span class="material-icons me-3">bookmark</span> Saved
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <span class="material-icons me-3">history</span> Recent
                    </a>
                </li>
            </ul>
            <div class="sidebar-bottom">
                <div class="location-label">
                    <p class="mb-0">KAHAWA SOWETO</p>
                </div>
            </div>
        </div>

        <div id="map" class="map-placeholder">
            <div class="map-overlay-controls">
                <div class="location-text">
                    <p class="mb-0">NAIROBI KENYA</p>
                </div>
                <div class="bottom-left-controls">
                    <button class="btn btn-light shadow-sm mb-2">
                        <span class="material-icons">layers</span>
                        <br>Layers
                    </button>
                    <button class="btn btn-light shadow-sm">
                        <span class="material-icons">smartphone</span>
                        <br>Get the app
                    </button>
                </div>
                <div class="bottom-right-controls">
                    <button class="btn btn-light shadow-sm mb-2">
                        <span class="material-icons">add</span>
                    </button>
                    <button class="btn btn-light shadow-sm">
                        <span class="material-icons">remove</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="assets/js/find_service.js"></script>
</body>

</html>