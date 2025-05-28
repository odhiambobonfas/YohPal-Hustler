<?php
// Process form submission only if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get form data
    $email = trim($_POST['email'] ?? '');

    // Basic validation
    if (empty($email)) {
        header("Location: ?url=forgot_pass&error=" . urlencode("Email field is required") . "&status=reset");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ?url=forgot_pass&error=" . urlencode("Please enter a valid email address") . "&status=reset");
        exit;
    }

    // API endpoint for password reset
    $resetApiUrl = "https://yohpal-webapp-api-test.onrender.com/Password_reset";

    // Prepare the POST data
    $data = [
        'email' => $email,
    ];

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $resetApiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HEADER, true); // Include headers in response

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Handle cURL errors
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        error_log("cURL Error: $error, HTTP Code: $httpCode");
        header("Location: ?url=forgot_pass&error=" . urlencode("Server connection failed: $error") . "&status=reset");
        exit;
    }

    // Split headers and body
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    curl_close($ch);

    // Log the raw API response for debugging
    error_log("HTTP Code: $httpCode, Headers: $headers, Body: $body");

    // Decode API response
    $responseData = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Decode Error: " . json_last_error_msg());
        header("Location: ?url=forgot_pass&error=" . urlencode("Invalid API response") . "&status=reset");
        exit;
    }

    // Handle successful or failed password reset request
    if ($httpCode >= 200 && $httpCode < 300) {
        // Success - redirect with success message
        $successMessage = isset($responseData['message']) && !empty($responseData['message']) ? $responseData['message'] : "Password reset email sent successfully.";
        header("Location: ?url=forgot_pass&success=" . urlencode($successMessage) . "&status=reset");
        exit;
    } else {
        // Failed - redirect with error message
        $errorMessage = isset($responseData['message']) && !empty($responseData['message']) ? $responseData['message'] : "Password reset failed. Please try again later.";
        header("Location: ?url=forgot_pass&error=" . urlencode($errorMessage) . "&status=reset");
        exit;
    }
}
?>