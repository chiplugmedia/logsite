<?php
function reserveMonnifyAccount($data){
    global $mfyContractCode;
    $accountName=$data['accountName'];
    $accountReference=$data['accountReference'];
    $customerEmail=$data['customerEmail'];
    $customerName=$data['customerName'];
    $token=$data['token'];

    $url="https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
    $method="POST";
    $headers=array("Authorization: Bearer $token", "Content-Type:application/json");
    $postFields=json_encode(array(
        "accountReference" => $accountReference,
        "accountName" => $accountName,
        "currencyCode" => "NGN",
        "contractCode" => $mfyContractCode,
        "customerEmail" => $customerEmail,
        "bvn" => "21212121212",
        "customerName" => $customerName,
        "getAllAvailableBanks" => true
    ));
    $data=array("url" => $url, "method" => $method, "headers" => $headers, "postFields" => $postFields);

    $curlRequest=curlRequest($data);
    $curlStatus=$curlRequest['requestSuccessful'];
    $curlMessage=$curlRequest['responseMessage'];
    $curlMessage=$curlRequest['responseMessage'];
    if($curlStatus){
        $status="success";
        $message="Accounts created";
        $accounts=$curlRequest['responseBody']['accounts'];
        $reservationReference=$curlRequest['responseBody']['reservationReference'];
        $data=array("accounts" => $accounts, "reservationReference" => $reservationReference);
    }
    else{
        $status="error";
        $message=$curlMessage;
        $data=array();
    }
    return $response=array("status" => $status, "message" => $message, "data" => $data);
}

function getMonnifyToken(){
    global $mfyApiKey, $mfySecKey;
    $url="https://api.monnify.com/api/v1/auth/login";
    $method="POST";
    $headers=array("Authorization: Basic ". base64_encode("$mfyApiKey:$mfySecKey"));
    $postFields=json_encode(array());
    $data=array("url" => $url, "method" => $method, "headers" => $headers, "postFields" => $postFields);

    $curlRequest=curlRequest($data);
    $curlStatus=$curlRequest['requestSuccessful'];
    $curlMessage=$curlRequest['responseMessage'];
    $curlMessage=$curlRequest['responseMessage'];
    if($curlStatus){
        $status="success";
        $message="Token fetched successfully";
        $token=$curlRequest['responseBody']['accessToken'];
        $data=array("token" => $token);
    }
    else{
        $status="error";
        $message=$curlMessage;
        $data=array();
    }
    return $response=array("status" => $status, "message" => $message, "data" => $data);
}
?>
