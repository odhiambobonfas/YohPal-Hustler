<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Make sure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ?url=&error=Invalid+request+method');
    exit;
}

// Sanitize input
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$password = htmlspecialchars(trim($_POST['password'] ?? ''));

// Validate input
if (empty($email) || empty($password)) {
    header('Location: ?url=&error=' . urlencode('Please enter email and password'));
    exit;
}

// API endpoint
$signinApiUrl = "https://yohpal-hustler-apis-live.onrender.com/signin";

// Prepare data for POST
$data = json_encode([
    'email' => $email,
    'password' => $password,
]);

// Initialize cURL
$ch = curl_init($signinApiUrl);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => $data,
]);

// Execute request
$response = curl_exec($ch);

// Handle cURL error
if (curl_errno($ch)) {
    curl_close($ch);
    header('Location: ?url=&error=' . urlencode('Server connection failed'));
    exit;
}

curl_close($ch);

// Decode API response
$responseData = json_decode($response, true);

// Handle response
if (isset($responseData['token'])) {
    // Store session data
    $_SESSION['token'] = $responseData['token'];
    $_SESSION['user_id'] = $responseData['user']['uid'];
    $_SESSION['email'] = $responseData['user']['email'];

    // OPTIONAL: Decode JWT token if needed
    // $payload = json_decode(base64_decode(explode('.', $_SESSION['token'])[1]), true);

    // Redirect to dashboard
    header('Location: ?url=dash');
    exit;
} else {
    $errorMessage = $responseData['message'] ?? "Invalid email or password";
    header('Location: ?url=&error=' . urlencode($errorMessage));
    exit;
}
?>