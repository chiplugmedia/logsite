<?php
$domain = $siteDesc; // Replace with your actual domain

// Helper function to make API requests
if (!function_exists('apiRequest')) {
    function apiRequest($url, $data = [], $method = 'GET') {
        global $apiKey;  // Make sure global key is used
        $curl = curl_init();

        $headers = [
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Authorization-Token: $apiKey", // Corrected this line
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ];

        if ($method === 'POST') {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);  // Ensure data is JSON-encoded
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return ['error' => $error];
        }

        curl_close($curl);
        return json_decode($response, true);
    }
}

// Function to get a list of categories and products
if (!function_exists('getCategoriesAndProducts')) {
    function getCategoriesAndProducts() {
        global $domain, $apiKey;
        $url = "https://$domain/api/products.php?api_key=$apiKey";
        return apiRequest($url, [], 'GET');
    }
}

// // Function to get product details
// if (!function_exists('getProductDetails')) {
//     function getProductDetails($product) {
//         global $domain, $apiKey;
//         $url = "https://$domain/api/product.php?api_key=$apiKey&product=$product";
//         return apiRequest($url, [], 'GET');
//     }
// }


?>
