<?php
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$segments = explode('/', $url);

switch ($segments[0]) {
  case '':
    include_once 'pages/landing_page.php'; // Homepage
    break;

  case 'dash':
    include 'pages/dashboard.php';
    break;

  case 'profile':
    include 'pages/profile.php';
    break;

  case 'public_prof':
    include 'pages/public_prof.php';
    break;

  case 'about':
    include 'pages/about.php';
    break;

  case "find_service":
    include 'pages/find_service.php';
    break;

  case "my_bookings":
    include 'pages/my_bookings.php';
    break;
  case "log_in":
    include 'pages/signin_signup.php';
    break;
  case "forgot_pass":
    include 'pages/forgot_pass.php';
    break;
  // links for pages with functions
  /* authentication functions */
  case 'signin_function';
    include 'api_integrations/authentication/signin.php';
    break;

  case "signup_function":
    include 'api_integrations/authentication/signup.php';
    break;

  case "logout_function":
    include 'api_integrations/authentication/logout.php';
    break;

  case "forgot_password_function":
    include 'api_integrations/authentication/forgot_pass.php';
    break;

  case "email_authentication":
    include 'api_integrations/authentication/email_authentication.php';
    break;

  /* authentication functions */
  default:
    echo "404 - Page not found";
}
?>