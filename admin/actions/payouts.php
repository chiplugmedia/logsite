<?php
$genMsg="";

if(isset($_POST['approve'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        $sql=$link->prepare("UPDATE withdrawals SET status='successful' WHERE id=?");
        $sql->bind_param("i", $id);
        if($sql->execute()){
            $status="success";
            $message="Withdrawal approved"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['decline'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrong"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $id=filter_string($_POST['id']);
        
        $sql=$link->prepare("UPDATE withdrawals SET status='rejected' WHERE id=?");
        $sql->bind_param("i", $id);
        if($sql->execute()){
            $sql=$link->prepare("SELECT * FROM withdrawals WHERE id=?");
            $sql->bind_param("s", $id);
            $sql->execute();
            $result=$sql->get_result();
            $row=$result->fetch_assoc();
            $username=$row['username'];
            $amount=$row['amount'];
            $type=strtolower($row['type']);
            switch($type){
                case "activity" : $wallet="funds"; break;
                case "referral" : $wallet="referralfunds"; break;
                case "indirectreferral" : $wallet="indref"; break;
                case "thirdindirectreferral" : $wallet="thirdindref"; break;
            }
            $sql=$link->prepare("UPDATE users SET $wallet=$wallet + ? WHERE username=?");
            $sql->bind_param("ss", $amount, $username);
            $sql->execute();
        
            $status="success";
            $message="Withdrawal rejected"; 
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong"; 
            $genMsg=sendResponse($status, $message);
        }
    }
}





if (isset($_POST['download'])) {
    $status = "error";
    $message = "Something went wrong";
    $genMsg = sendResponse($status, $message); // Assuming sendResponse is defined elsewhere

    // Retrieve pending withdrawals with associated bank account details
    $query = "SELECT w.*, b.* FROM withdrawals w 
              LEFT JOIN bankaccounts b ON w.username = b.username 
              WHERE w.status ='pending' AND w.type ='referral' 
              ORDER BY w.id DESC";
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $numRows = $result->num_rows;

    if ($numRows > 0) {
        // Initialize an empty CSV string
        $csvData = "Account number,Bank,Amount,Description\n";

        // Fetch data from the combined result
        while ($row = $result->fetch_assoc()) {
            $acctNum = $row['acctnum'];
            $bankName = ucwords($row['bankname']);
            $amount = $row['amount'];
            $description = "NOXEN TECHNOLOGY"; // Assuming this is a static description

            // Format data and append to CSV string
            $csvData .= "$acctNum,$bankName,$amount,$description\n";
        }

        // Set headers to prompt download
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=bulk_disbursement.csv");

        // Output CSV data
        echo $csvData;
        exit;
    }
}

if (isset($_POST['downloadactivity'])) {
    $status = "error";
    $message = "Something went wrong";
    $genMsg = sendResponse($status, $message); // Assuming sendResponse is defined elsewhere

    // Retrieve pending withdrawals with associated bank account details
    $query = "SELECT w.*, b.* FROM withdrawals w 
              LEFT JOIN bankaccounts b ON w.username = b.username 
              WHERE w.status ='pending' AND w.type ='activity' 
              ORDER BY w.id DESC";
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $numRows = $result->num_rows;

    if ($numRows > 0) {
        // Initialize an empty CSV string
        $csvData = "Account number,Bank,Amount,Description\n";

        // Fetch data from the combined result
        while ($row = $result->fetch_assoc()) {
            $acctNum = $row['acctnum'];
            $bankName = ucwords($row['bankname']);
            $amount = $row['amount'];
            $description = "NOXEN TECHNOLOGY"; // Assuming this is a static description

            // Format data and append to CSV string
            $csvData .= "$acctNum,$bankName,$amount,$description\n";
        }

        // Set headers to prompt download
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=bulk_disbursement.csv");

        // Output CSV data
        echo $csvData;
        exit;
    }
}


?>