<?php
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$segments = explode('/', $url);

switch ($segments[0]) {
  case '':
    include_once 'pages/signin_signup.php'; // Homepage
    break;

  case 'dash':
    include 'pages/dashboard.php';
    break;

  case 'profile':
    include 'pages/profile.php';
    break;

  case "find_service":
    include 'pages/find_service.php';
    break;
  // links for pages with functions
  /* authentication functions */
  case 'signin_function':
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