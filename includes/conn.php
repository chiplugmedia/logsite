<?php
// Set session lifetime for 2 days
$session_lifetime = 3600 * 24 * 2; 
session_set_cookie_params($session_lifetime);
session_start();
ob_start();

// Database connection
$link = new mysqli("localhost", "famboost_you", "famboost_you", "famboost_you");

// Check for connection errors
if ($link->connect_error) {
    die("Database connection failed: " . $link->connect_error);
}

// Set timezone
date_default_timezone_set("Africa/Lagos");

// Date and time settings
$dateTime = $dates = date('d-m-Y H:i:s');
$date = date('d-m-Y');
$time = time();

// File name information
$fileName = $_SERVER['PHP_SELF'];
$mainFilename = pathinfo($fileName, PATHINFO_FILENAME);

// Site information
$sitelink = "https://pinatexlogs.com";
$dollar = "₦";
$point = "NP";

// Determine greeting based on the current hour
$hour = date("H"); // Get the current hour in 24-hour format

if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning!";
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = "Good Afternoon!";
} elseif ($hour >= 18 && $hour < 24) {
    $greeting = "Good Evening!";
} else {
    $greeting = "Hello!";
}


?>
