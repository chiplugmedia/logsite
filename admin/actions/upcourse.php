<?php

require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";



// Check if the request is coming from AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the API key from the POST data
    $apiKey = $_POST['apiKey'] ?? '';

    if (empty($apiKey)) {
        echo 'API Key is missing.';
        exit;
    }

    // Set the global API key
    $GLOBALS['apiKey'] = $apiKey;

    // Call the bulkUpload function and get the result
    $result = bulkUpload();
    
    // Return the result as plain text
    echo $result;
}
?>


