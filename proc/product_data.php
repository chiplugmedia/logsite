<?php
// Simulated API response
$response = [
    "status" => "success",
    "msg" => "Order created successfully!",
    "trans_id" => "JB78678073198b1b2",
    "data" => [
        "100095371248106|RjUSI2cOlT15|JPAEV5WGNFSWV65ALEX6LTPURG7E3LQC|femritelcn441442@hotmail.com|PicGe665rAx^|femritelcn441442oir5c7f@fviainboxes.com||||"
    ]
];

// Extract the first item from the "data" array
$dataString = $response["data"][0];

// Split the string into parts by "|"
$dataParts = explode("|", $dataString);

// Extract the username and password
$username = $dataParts[3] ?? "N/A"; // 4th value (index 3)
$password = $dataParts[1] ?? "N/A"; // 2nd value (index 1)



if ($response['status'] == 'success') {
    // Display the extracted values
    echo "Username: " . $username . PHP_EOL;
    echo "<br>";
    echo "Password: " . $password . PHP_EOL;
}else {
    echo " Error";
}
?>
