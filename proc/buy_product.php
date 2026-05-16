<?php
//print_r($_POST);
header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $amount = $_POST['quantity'];
    
    
    
    // API endpoint
    $url = "https://shopviaclone22.com/api/buy_product";
    
    // Form data
    $data = [
        "action" => "buyProduct",
        "id" => $id, // Replace with the actual product ID
        "amount" => $amount, // Replace with the desired quantity
        "api_key" => "30080e27cbc1a4519f52eb923392734d"
    ];
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for testing (not recommended for production)
    
    // Execute the request
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if (curl_errno($ch)) {
        die("cURL error: " . curl_error($ch));
    }
    
    // Close cURL
    curl_close($ch);
    
    // Decode the JSON response
    $responseData = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error: Failed to parse JSON - " . json_last_error_msg());
    }
    
    
    
    
    if ($responseData['status'] == 'success') {
    
        // Extract the first item from the "data" array
        $dataString = $response["data"][0];
    
        // Split the string into parts by "|"
        $dataParts = explode("|", $dataString);
    
        // Extract the username and password
        $username = $dataParts[3] ?? "N/A"; // 4th value (index 3)
        $password = $dataParts[1] ?? "N/A"; // 2nd value (index 1)
        header("Location: ../dash/purchase?username=$username&&password=$password");
    
        // Display the extracted values
        // echo "Username: " . $username . PHP_EOL;
        // echo "<br>";
        // echo "Password: " . $password . PHP_EOL;
    
        header("Location: ../");
    }else {
        $msg = $responseData['msg'];
        header("Location: ../dash/purchase?msg=$msg");
    }
}