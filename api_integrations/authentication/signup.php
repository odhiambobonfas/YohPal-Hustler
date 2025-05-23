<?php
// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ?url=&error=" . urlencode("Invalid request method") . "&status=signup");
    exit;
}

// Sanitize and get form data
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password1'] ?? '');
$password2 = trim($_POST['password2'] ?? '');

// Basic validation
if (empty($email) || empty($password) || empty($password2)) {
    header("Location: ?url=&error=" . urlencode("All fields are required") . "&status=signup");
    exit;
}

if ($password !== $password2) {
    header("Location: ?url=&error=" . urlencode("Passwords do not match") . "&status=signup");
    exit;
}

// API endpoint for signup
$signupApiUrl = "https://yohpal-hustler-apis-live.onrender.com/signup/";

// Prepare the POST data
$data = [
    'email' => $email,
    'password' => $password,
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $signupApiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute the cURL request
$response = curl_exec($ch);

// Handle cURL errors
if (curl_errno($ch)) {
    curl_close($ch);
    header("Location: ?url=&error=" . urlencode("Server connection failed") . "&status=signup");
    exit;
}

curl_close($ch);

// Decode API response
$responseData = json_decode($response, true);

// Handle successful or failed signup
if (isset($responseData['token'])) {
    session_start(); // Needed to store login data
    $_SESSION['token'] = $responseData['token'];
    $_SESSION['user_id'] = $responseData['user']['uid'] ?? null;
    $_SESSION['email'] = $responseData['user']['email'] ?? $email;

    header("Location: ?url=dash");
    exit;
} else {
    $errorMessage = $responseData['message'] ?? "Signup failed.";
    header("Location: ?url=&error=" . urlencode($errorMessage) . "&status=signup");
    exit;
}
?>