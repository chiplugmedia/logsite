<?php

require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";


$genMsg = ""; // Initialize message variable

if (isset($_POST['purchaseapi']) && !empty($_POST['purchaseapi'])) {
    // Validate inputs
    if (empty($_POST['service'])) {
        $status = "error";
        $message = "Enter service";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['year'])) {
        $status = "error";
        $message = "Enter year";
        $genMsg = sendResponse($status, $message);
    } elseif (!is_numeric($_POST['quantity']) || $_POST['quantity'] <= 0) {
        $status = "error";
        $message = "Enter a valid quantity";
        $genMsg = sendResponse($status, $message);
    } elseif (!is_numeric($_POST['cost'])) {
        $status = "error";
        $message = "Enter a valid amount";
       $genMsg = sendResponse($status, $message);
    } else {
        // Sanitize and validate input data
        $service = filter_string($_POST['service']);
        $year = filter_string($_POST['year']);
        $quantity = filter_string($_POST['quantity']);
        $cost = intval($_POST['cost']); // Ensure cost is an integer

        $totalPrice = $cost * $quantity;
// Check if the user has sufficient funds
if ($totalPrice > $funds) {
    $status = "error";
    $message = "Insufficient funds in your wallet";
    $genMsg = sendResponse($status, $message);
} else {
    // Prepare and execute the statement to update user funds
    $sql = $link->prepare("UPDATE users SET funds = funds - ? WHERE username = ?");
    $sql->bind_param("ds", $totalPrice, $username);

    if ($sql->execute()) {
        // Prepare data for purchaseAccount
        $data = [
            "service" => $service,
            "year" => $year,
            "quantity" => $quantity
        ];
        $purchaseAccountResponse = purchaseAccount($data);

        // Convert purchaseAccountResponse to JSON string for better debugging
        $purchaseAccountResponseStr = json_encode($purchaseAccountResponse);

        // Check for insufficient balance in API response
        if (isset($purchaseAccountResponse['messages']['error']) && 
            $purchaseAccountResponse['messages']['error'] === 'Insufficient wallet balance') {
            
            // Revert fund deduction
            $sql = $link->prepare("UPDATE users SET funds = funds + ? WHERE username = ?");
            $sql->bind_param("ds", $totalPrice, $username);
            $sql->execute();

            // Update purchase records with failure status
            $status = "error";
            $message = "Could not buy product at this time, try again later.";
            $sql = $link->prepare("UPDATE userpurchases SET status = ?, message = ? WHERE reference = ?");
            $sql->bind_param("sss", $status, $message, $reference);
            $sql->execute();

            $genMsg = sendResponse($status, $message);

        } else {
            // Proceed with successful purchase logic
            $sql = $link->prepare("INSERT INTO userpurchases (username, orderid ,title, purchaseinfo, description, amount, message, status, reference, date) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?)");

            for ($i = 1; $i <= $quantity; $i++) {
                $reference = get_rand_alphanumeric(30);
                $title = $service; // Assuming the title is the service name
                $description = $year; // Assuming the description is the year
                $status = "Completed"; 
                $sql->bind_param("sssssdssss", $username,$id, $title, $account, $description, $totalPrice, $purchaseAccountResponseStr, $status, $reference, $dateTime);

                if ($sql->execute()) {
                    // Insert earnings
                    $sql = $link->prepare("INSERT INTO userearnings (username, type, amount, time, date) VALUES (?, ?, ?, ?, ?)");
                    $typehg = "Purchased Product"; // Define type for earnings
                    $sql->bind_param("sssss", $username, $typehg, $totalPrice, $dateTime, $dateTime);

                    if ($sql->execute()) {
                        $status = "success";
                        $message = "Product purchased successfully.";
                        $genMsg = sendResponse($status, $message);
                    } else {
                        $status = "error";
                        $message = "Could not buy product at this time, try again later";
                        $genMsg = sendResponse($status, $message);
                    }
                } else {
                    $status = "error";
                    $message = "Something went wrong, try later";
                    $genMsg = sendResponse($status, $message);
                }
            }
        }
    } else {
        $status = "error";
        $message = "Failed to update user funds, try again later";
        $genMsg = sendResponse($status, $message);
    }
}

      



if (isset($_POST['buyData']) && !empty($_POST['buyData'])) {
    $networks = array("mtn", "airtel", "9mobile", "glo");

    if (empty($_POST['serviceID'])) {
        $status = "error";
        $message = "Select dataplan";
        echo sendResponse($status, $message);
    } elseif (!is_numeric($_POST['serviceID'])) {
        $status = "error";
        $message = "Select dataplan";
        echo sendResponse($status, $message);
    } elseif (empty($_POST['network'])) {
        $status = "error";
        $message = "Select your network";
        echo sendResponse($status, $message);
    } elseif (empty($_POST['phone'])) {
        $status = "error";
        $message = "Enter a phone number";
        echo sendResponse($status, $message);
    } elseif (!is_numeric($_POST['phone'])) {
        $status = "error";
        $message = "Enter a valid phone number";
        echo sendResponse($status, $message);
    } elseif (strlen($_POST['phone']) != 11) {
        $status = "error";
        $message = "Enter a valid phone number";
        echo sendResponse($status, $message);
    } elseif (!in_array($_POST['network'], $networks)) {
        $status = "error";
        $message = "Invalid network";
        echo sendResponse($status, $message);
    } elseif (!isset($vtuportal) || !$vtuportal) {
        $status = "error";
        $message = "VTU Portal is currently not available";
        echo sendResponse($status, $message);
    } else {
        $serviceID = filter_string($_POST['serviceID']);
        $network = filter_string($_POST['network']);
        $phone = filter_string($_POST['phone']);

        switch ($network) {
            case "mtn":
                $networkID = 01;
                break;
            case "glo":
                $networkID = 02;
                break;
            case "airtel":
                $networkID = 03;
                break;
            case "9mobile":
                $networkID = 04;
                break;
        }

        $sql = $link->prepare("SELECT * FROM dataprices WHERE serviceid = ?");
        $sql->bind_param("s", $serviceID);
        $sql->execute();
        $result = $sql->get_result();
        $numrow = $result->num_rows;
        $row = $result->fetch_assoc();

        if ($numrow == 0) {
            $status = "error";
            $message = "Something went wrong validating data";
            echo sendResponse($status, $message);
            exit;
        }

        $amount = $row['amount'];
        $amount = productDiscount($amount);
        $network = $row['network'];
        $dataPlan = $row['dataplan'];
        $desc = strtoupper($network) . " " . $dataPlan;

        if ($amount > $vtubalance) {
            $status = "error";
            $message = "Insufficient funds";
            echo sendResponse($status, $message);
            exit;
        }

        $sql = $link->prepare("UPDATE users SET vtubalance = vtubalance - ? WHERE username = ?");
        $sql->bind_param("ss", $amount, $username);
        if ($sql->execute()) {
            $ownReference = get_rand_alphanumeric(30);
            $data = array("network" => $networkID, "phone" => $phone, "reference" => $ownReference, "serviceID" => $serviceID);
            $buyData = buyData($data);
            $dataStatus = $dataMessage = "";

            if (isset($buyData['status'])) {
                $dataStatus = $buyData['status'];
                $dataMessage = $buyData['message'];
            }

            $type = "data";
            $status = "pending";
            $sql = $link->prepare("INSERT INTO transactions(username, serviceID, type, amount, number, description, status, ownreference, date) VALUES(?,?,?,?,?,?,?,?,?)");
            $sql->bind_param("sssssssss", $username, $serviceID, $type, $amount, $phone, $desc, $status, $ownReference, $dateTime);
            $sql->execute();

            if ($dataStatus == "success") {
                $status = "successful";
                $reference = $buyData['data']['clientReference'];
                $amountCharged = $buyData['data']['amount'];
                $sql = $link->prepare("UPDATE transactions SET reference = ?, amountcharged = ?, status = ?, message = ? WHERE ownreference = ?");
                $sql->bind_param("sssss", $reference, $amountCharged, $status, $dataMessage, $ownReference);

                if ($sql->execute()) {
                    $sql = $link->prepare("INSERT INTO userearnings(username, type, amount, time, date) VALUES(?,?,?,?,?)");
                    $sql->bind_param("sssss", $username, $type, $amount, $time, $dateTime);
                    if ($sql->execute()) {
                        $status = "success";
                        $message = "Data purchase successful";
                        echo sendResponse($status, $message);
                    }
                } else {
                    $status = "error";
                    $message = "Something went wrong";
                    echo sendResponse($status, $message);
                }
            } else {
                $status = "pending";
                $expMsgs = array("Insufficient balance on your account", "Authorization token is incorrect");
                if (in_array($dataMessage, $expMsgs) || $buyData['data']['status'] == "failed") {
                    $status = "failed";
                    $sql = $link->prepare("UPDATE users SET vtubalance = vtubalance + ? WHERE username = ?");
                    $sql->bind_param("ss", $amount, $username);
                    $sql->execute();
                }
                $sql = $link->prepare("UPDATE transactions SET status = ?, message = ? WHERE ownreference = ?");
                $sql->bind_param("sss", $status, $dataMessage, $ownReference);
                $sql->execute();

                $sql = $link->prepare("UPDATE users SET vtubalance = vtubalance + ? WHERE username = ?");
                $sql->bind_param("ss", $amount, $username);
                $sql->execute();

                $status = "error";
                $message = "Could not buy data at this time, try again later";
                echo sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "Something went wrong, try later";
            echo sendResponse($status, $message);
        }
    }
}


if(isset($_POST['validateCable']) && !empty($_POST['validateCable'])){
    $cables=array("gotv","dstv","startimes");
    if(empty($_POST['cable'])){
        $status="error";
        $message="Select cable";
        echo sendResponse($status, $message);
    }
    else if(!in_array($_POST['cable'], $cables)){
        $status="error";
        $message="Invalid cable";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['iucNum'])){
        $status="error";
        $message="Enter IUC Number";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['iucNum'])){
        $status="error";
        $message="Invalid IUC Number";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['serviceID'])){
        $status="error";
        $message="Enter Cable plan";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['serviceID'])){
        $status="error";
        $message="Invalid cable plan";
        echo sendResponse($status, $message);
    }
    else{
        $cable=($channel == "dashboard") ? filter_string($_POST['cable']) : "";
        $iucNum=filter_string($_POST['iucNum']);
        $serviceID=filter_string($_POST['serviceID']);
        if($cable == "dstv"){
            $cableID=01;
        }
        else if($cable == "gotv"){
            $cableID=02;
        }
        else if($cable == "startimes"){
            $cableID=03;
        }

        $data=array("serviceID" => $serviceID, "iucNum" => $iucNum);
        $validateCable=validateCable($data);
        $dataStatus=$dataMessage="";
        if(isset($validateCable['status']) && $validateCable['status'] == "success"){
            $dataStatus=$validateCable['status'];
            $dataMessage=$validateCable['message'];
            $customerName=$validateCable['data']['customerName'];
            $currentBouquet=$validateCable['data']['currentBouquet'];

            $status="success";
            $message="Validation successful";
            $data=array("customerName" => $customerName, "currentBouquet" => $currentBouquet);
            echo json_encode(array("status" => $status, "message" => $message, "data" => $data));
        }
        else{
            $status="error";
            $message="Validation failed";
            $data=array("");
            echo json_encode(array("status" => $status, "message" => $message, "data" => $data));
        }
    }
}

if(isset($_POST['subCable']) && !empty($_POST['subCable'])){
    $cables=array("gotv","dstv","startimes");
    if(empty($_POST['serviceID'])){
        $status="error";
        $message="Select cable plan";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['serviceID'])){
        $status="error";
        $message="Select cable plan";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['cable'])){
        $status="error";
        $message="Select your cable";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['iucNum'])){
        $status="error";
        $message="Enter your IUC number";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['iucNum'])){
        $status="error";
        $message="Enter a valid IUC number";
        echo sendResponse($status, $message);
    }
    else if(!in_array($_POST['cable'], $cables)){
        $status="error";
        $message="Invalid cable";
        echo sendResponse($status, $message);
    }
    else{
        $serviceID=filter_string($_POST['serviceID']);
        $cable=filter_string($_POST['cable']);
        $iucNum=filter_string($_POST['iucNum']);
        if($cable == "dstv"){
            $cableID=01;
        }
        else if($cable == "gotv"){
            $cableID=02;
        }
        else if($cable == "startimes"){
            $cableID=03;
        }

        $sql=$link->prepare("SELECT * FROM cableprices WHERE serviceid=?");
        $sql->bind_param("s", $serviceID);
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        $row=$result->fetch_assoc();
        if($numrow == 0){
            $status="error";
            $message="Something went wrong validating cable";
            echo sendResponse($status, $message);
            exit;
        }
        $amount=$row['amount'];
        $amount=productDiscount($amount);
        $cablePlan=$row['plan'];
        $desc=strtoupper($cable)." ".$cablePlan;
        if($amount > $funds){
            $status="error";
            $message="Insuffucient funds";
            echo sendResponse($status, $message);
            exit;
        }
        $sql=$link->prepare("UPDATE users SET funds=funds - ? WHERE username=?");
        $sql->bind_param("ss", $amount, $username);
        if($sql->execute()){
            $reference=get_rand_alphanumeric(20);
            $data=array("serviceID" => $serviceID, "iucNum" => $iucNum, "cable" => $cableID, "reference" => $reference);
            $subCable=subCable($data);
            $dataStatus=$dataMessage="";
            if(isset($subCable['status'])){
                $cableStatus=$subCable['status'];
                $cableMessage=$subCable['message'];
            }

            $type="cable";
            $status="successful";
            if($cableStatus == "success"){
                $reference=$subCable['data']['clientReference'];
                $sql=$link->prepare("INSERT INTO transactions(username, serviceID, type, reference, amount, amountcharged, number, description, status, message, date) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $sql->bind_param("sssssssssss", $username, $serviceID, $type, $reference, $amount, $amount, $iucNum, $desc, $status, $cableMessage, $dateTime);
                if($sql->execute()){
                    $status="success";
                    $message="Cable subscription successful";
                    echo sendResponse($status, $message);
                }
                else{
                    $status="error";
                    $message="Something went wrong";
                    echo sendResponse($status, $message);
                }
            }
            else{
                $sql=$link->prepare("UPDATE users SET funds=funds + ? WHERE username=?");
                $sql->bind_param("ss", $amount, $username);
                if($sql->execute()){
                    $status="error";
                    $message="Could not subscribe at this time, try again later";
                    echo sendResponse($status, $message);
                }
            }
        }
        else{
            $status="error";
            $message="Something went wrong";
            echo sendResponse($status, $message);
        }
    }
}


if(isset($_POST['validateElectric']) && !empty($_POST['validateElectric'])){
    if(empty($_POST['serviceID'])){
        $status="error";
        $message="Select meter company";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['meterNum'])){
        $status="error";
        $message="Enter meter Number";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['meterNum'])){
        $status="error";
        $message="Invalid meter Number";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['amount'])){
        $status="error";
        $message="Enter amount";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['amount'])){
        $status="error";
        $message="Invalid amount";
        echo sendResponse($status, $message);
    }
    else if($_POST['amount'] < 1000){
        $status="error";
        $message="Enter amount greater or equal to 1000";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['meterType'])){
        $status="error";
        $message="Select meter type";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['meterType'])){
        $status="error";
        $message="Invalid meter type";
        echo sendResponse($status, $message);
    }
    else{
        $serviceID=filter_string($_POST['serviceID']);
        $meterNum=filter_string($_POST['meterNum']);
        $meterType=filter_string($_POST['meterType']);
        $amount=filter_string($_POST['amount']);

        $data=array("serviceID" => $serviceID, "meterNum" => $meterNum, "meterType" => $meterType, "amount" => $amount);
        $validateElectric=validateElectric($data);
        $dataStatus=$dataMessage="";
        if(isset($validateElectric['status']) && $validateElectric['status'] == "success"){
            $electricStatus=$validateElectric['status'];
            $electriMessage=$validateElectric['message'];
            $customerName=$validateElectric['data']['customerName'];
            $address=$validateElectric['data']['address'];

            $status="success";
            $message="Validation successful";
            $data=array("customerName" => $customerName, "address" => $address);
            echo json_encode(array("status" => $status, "message" => $message, "data" => $data));
        }
        else{
            $status="error";
            $message="Validation failed".$validateElectric['message'];
            $data=array("");
            echo json_encode(array("status" => $status, "message" => $message, "data" => $data));
        }
    }
}


if(isset($_POST['payElectric']) && !empty($_POST['payElectric'])){
    $cables=array("gotv","dstv","startimes");
    if(empty($_POST['serviceID'])){
        $status="error";
        $message="Select meter company";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['companyName'])){
        $status="error";
        $message="Enter meter company";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['meterNum'])){
        $status="error";
        $message="Enter meter Number";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['meterNum'])){
        $status="error";
        $message="Invalid meter Number";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['amount'])){
        $status="error";
        $message="Enter amount";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['amount'])){
        $status="error";
        $message="Invalid amount";
        echo sendResponse($status, $message);
    }
    else if($_POST['amount'] < 1000){
        $status="error";
        $message="Minimum amount is 1000";
        echo sendResponse($status, $message);
    }
    else if(empty($_POST['meterType'])){
        $status="error";
        $message="Select meter type";
        echo sendResponse($status, $message);
    }
    else if(!is_numeric($_POST['meterType'])){
        $status="error";
        $message="Invalid meter type";
        echo sendResponse($status, $message);
    }
    else{
        $serviceID=filter_string($_POST['serviceID']);
        $companyName=filter_string($_POST['companyName']);
        $meterNum=filter_string($_POST['meterNum']);
        $meterType=filter_string($_POST['meterType']);
        $amountM=filter_string($_POST['amount']);
        $amount=productDiscount($amountM);
        $reference=get_rand_alphanumeric(20);
        
        if($amount > $funds){
            $status="error";
            $message="Insuffucient funds";
            echo sendResponse($status, $message);
            exit;
        }
        else if($amountM < 1000){
            $status="error";
            $message="Amount should be greater than 1000";
            echo sendResponse($status, $message);
            exit;
        }
        $sql=$link->prepare("UPDATE users SET funds=funds - ? WHERE username=?");
        $sql->bind_param("ss", $amount, $username);
        if($sql->execute()){
            $reference=get_rand_alphanumeric(20);
            $data=array("serviceID" => $serviceID, "meterNum" => $meterNum, "meterType" => $meterType, "amount" => $amount);
            $payElectric=payElectric($data);
            $electricStatus=$electricMessage="";
            if(isset($payElectric['status'])){
                $electricStatus=$payElectric['status'];
                $electricMessage=$payElectric['message'];
            }

            $type="electricity";
            if($electricStatus == "success"){
                $productName=$payElectric['data']['productName'];
                $electricAmount=$payElectric['data']['amount'];
                // $meterNum=$payElectric['data']['meterNum'] ;
                $customerName=$payElectric['data']['customerName'] ;
                $token=$payElectric['data']['token'];
                $tokenValue=$payElectric['data']['tokenValue'];
                $units=$payElectric['data']['units'] ;
                $apiReference=$payElectric['data']['clientReference'] ;

                $desc="$companyName";
                $status="successful";
                $sql=$link->prepare("INSERT INTO transactions(username, serviceID, type, reference, amount, amountcharged, number, description, status, message, date) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $sql->bind_param("sssssssssss", $username, $serviceID, $type, $reference, $amount, $amount, $meterNum, $desc, $status, $electricMessage, $dateTime);
                if($sql->execute()){
                    $sql=$link->prepare("INSERT INTO electricity(username, reference, apireference, serviceid, productname, amount, amountpaid, apiamount, status, meternum, customername, token, tokenvalue, units, date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
					$sql->bind_param("sssssssssssssss", $username, $reference, $apiReference, $serviceID, $productName, $amount, $discountAmount, $electricAmount, $status, $meterNum, $customerName, $token, $tokenValue, $units, $dateTime) ;
                    $sql->execute();

                    $status="success";
                    $message="Electric payment successful";
                    echo sendResponse($status, $message);
                }
                else{
                    $status="error";
                    $message="Something went wrong";
                    echo sendResponse($status, $message);
                }
            }
            else{
                $sql=$link->prepare("UPDATE users SET funds=funds + ? WHERE username=?");
                $sql->bind_param("ss", $amount, $username);
                if($sql->execute()){
                    $status="error";
                    $message="Could not pay electricity at this time, try again later";
                    echo sendResponse($status, $message);
                }
            }
        }
        else{
            $status="error";
            $message="Something went wrong";
            echo sendResponse($status, $message);
        }
    }
}

function productDiscount($amount){
    global $productDiscount, $acctType; 
    
    return ($acctType == "standard") ? $amount - ($productDiscount * $amount / 100) : $amount; 
}
}
  }
   
?>