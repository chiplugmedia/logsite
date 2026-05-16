<?php
$domain = $siteDesc; // Replace with your actual domain
//$myapiKey = '30080e27cbc1a4519f52eb923392734d'; // Replace with your actual API key

// Function to get account information
function getAccountInformation() {
    global $domain, $apiKey;
    $url = "https://$domain/api/profile.php?api_key=$apiKey"; // Use domain and API key dynamically
    $response = apiRequest($url, [], 'GET'); // Get the response from apiRequest function

    if (isset($response['status']) && $response['status'] === 'success') {
        return isset($response['data']) ? $response['data'] : [];
    }

    return ['error' => 'Failed to fetch account information']; // Return error if request fails
}


// Function to convert amount to desired currency using custom exchange rate
function convertCurrency($amount, $exchangeRate) {
    $convertedAmount = $amount * $exchangeRate; // Convert amount by multiplying with the exchange rate
    return $convertedAmount;
}

// Exchange rates
$exchangeRates = [
    'NGN' => ['currency_symbol' => '₦', 'USD' => 1680],  // 1 USD = 1680  NGN
    'USD' => ['currency_symbol' => '$', 'NGN' => 0.00059524]  // 1 NGN = 0.00059524 USD
];

// Get account information
$accountInfo = getAccountInformation(); // Fetch account information

// Check if account info is retrieved successfully
if (isset($accountInfo['error'])) {
    echo "Error: " . $accountInfo['error'];
    exit; // Exit if account info is not available
}
$myapiusername = isset($accountInfo['username']) ? $accountInfo['username'] : 'Username not found';
// Determine the target country/currency for conversion (e.g., NGN or USD)
$targetCountry = isset($_POST['targetCountry']) && array_key_exists($_POST['targetCountry'], $exchangeRates) ? $_POST['targetCountry'] : 'NGN'; // Default to Naira

// Get the exchange rate based on the target country (currency)
$exchangeRate = isset($exchangeRates[$targetCountry]['USD']) ? $exchangeRates[$targetCountry]['USD'] : 1;

// Convert the balance to the target currency (Naira in this case)
$convertedAmount = convertCurrency($accountInfo['money'], $exchangeRate);

// Get the currency symbol for the target country (Naira symbol)
$currencySymbol = isset($exchangeRates[$targetCountry]['currency_symbol']) ? $exchangeRates[$targetCountry]['currency_symbol'] : '';

// Function to make API request (GET or POST)
function apiRequest($url, $data = [], $method = 'GET') {
    global $apiKey;
    $curl = curl_init();

    // Set up request options based on method (GET or POST)
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json",
            "Authorization-Token: $apiKey",
        ),
    ));

    if ($method === 'POST') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return ['error' => $error]; // Return error if cURL fails
    }

    curl_close($curl);
    return json_decode($response, true); // Return the decoded response
}
?>