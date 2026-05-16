<?php

function convertCurrency($amount, $exchangeRate) {
    return round($amount * $exchangeRate, 2); // Convert amount by multiplying with the exchange rate and round to 2 decimal places
}

// Exchange rates
$exchangeRates = [
    'NGN' => ['currency_symbol' => '₦', 'USD' => $sitetag],  // 1 NGN = 0.00061 USD
    'USD' => ['currency_symbol' => '$', 'NGN' => 0.00061]      // 1 USD = 1650 NGN
];

// Determine the target country and set the currency symbol (default to 'NGN')
$targetCountry = isset($_POST['targetCountry']) && array_key_exists($_POST['targetCountry'], $exchangeRates) 
    ? $_POST['targetCountry'] 
    : 'NGN';  // Default to NGN (Naira)

// Set the currency symbol for the target country
$currencySymbol = $exchangeRates[$targetCountry]['currency_symbol'] ?? '₦'; // Default to ₦ for NGN


?>
