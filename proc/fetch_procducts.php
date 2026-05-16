<?php
$url = "https://shopviaclone22.com/api/products.php?api_key=30080e27cbc1a4519f52eb923392734d";

// Initialize cURL
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for testing (not recommended for production)

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    die("cURL error: " . curl_error($ch));
}

// Close cURL
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error: Failed to parse JSON - " . json_last_error_msg());
}

// Display data
echo "<pre>";
print_r($data);
echo "</pre>";
?>
