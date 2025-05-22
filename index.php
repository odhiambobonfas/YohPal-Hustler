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

  default:
    echo "404 - Page not found";
}
?>
