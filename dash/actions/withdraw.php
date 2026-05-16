<?php
$genMsg = $wallet = $amount = $isSelectedActivity = $isSelectedReferral = $isSelectedIndirectReferral = $isSelectedThirdIndirectReferral = $countryname = "";

if (isset($_POST['withdraw'])) {

    $wallets = array("activity", "referral", "social");
    $availableCountries = array("Cameroon", "Nigeria", "Ghana", "Sierra Leone", "South Africa", "Kenya", "Tanzania", "Uganda", "America");

    // Check for empty amount
    if (empty($_POST['amount'])) {
        $status = "error";
        $message = "Enter an amount to withdraw";
        $genMsg = sendResponse($status, $message);
    } 
    // Check if amount is numeric
    else if (!is_numeric($_POST['amount'])) {
        $status = "error";
        $message = "Invalid amount";
        $genMsg = sendResponse($status, $message);
    } 
    // Check for empty country name
    else if (empty($_POST['countryname'])) {
        $status = "error";
        $message = "Select your country";
        $genMsg = sendResponse($status, $message);
    } 
    // Check if country name is valid
    else if (!in_array($_POST['countryname'], $availableCountries)) {
        $status = "error";
        $message = "Invalid country";
        $genMsg = sendResponse($status, $message);
    } 
    // Check for empty wallet
    else if (empty($_POST['wallet'])) {
        $status = "error";
        $message = "Select wallet to withdraw from";
        $genMsg = sendResponse($status, $message);
    } 
    // Check if wallet is valid
    else if (!in_array($_POST['wallet'], $wallets)) {
        $status = "error";
        $message = "Invalid wallet";
        $genMsg = sendResponse($status, $message);
    } 
    else {
        $amount = filter_string($_POST['amount']);
        $countryname = filter_string($_POST['countryname']);
        $wallet = filter_string($_POST['wallet']);

        // Check for minimum withdrawal amounts
        if ($wallet == "activity" && ($amount < $minActWithdrawAmt)) {
            $status = "error";
            $message = "Minimum activity wallet withdrawal is $minActWithdrawAmt";
            $genMsg = sendResponse($status, $message);
        } else if ($wallet == "referral" && ($amount < $minRefWithdrawAmt)) {
            $status = "error";
            $message = "Minimum referral withdrawal is $minRefWithdrawAmt";
            $genMsg = sendResponse($status, $message);
        } elseif ($wallet == "social" && ($amount < $minSocialWith)) {
            $status = "error";
            $message = "Minimum social withdrawal is $minSocialWith";
            $genMsg = sendResponse($status, $message);
        } 
        // Check for sufficient funds
        else if (($wallet == "activity" && $amount > $funds) || ($wallet == "referral" && $amount > $referralFunds) || ($wallet == "social" && $amount > $score)) {
            $status = "error";
            $message = "Insufficient funds in your $wallet wallet";
            $genMsg = sendResponse($status, $message);
        } 
        // Check for country-specific withdrawal availability
        else if (($countryname == "America" && !$AmericaWithdraw) || 
                 ($countryname == "Uganda" && !$UgandaWithdraw) || 
                 ($countryname == "Tanzania" && !$TanzaniaWithdraw) || 
                 ($countryname == "Kenya" && !$KenyaWithdraw) || 
                 ($countryname == "South Africa" && !$SouthAfricaWithdraw) || 
                 ($countryname == "Sierra Leone" && !$SierraLeoneWithdraw) || 
                 ($countryname == "Ghana" && !$GhanaWithdraw) || 
                 ($countryname == "Nigeria" && !$NigeriaWithdraw) || 
                 ($countryname == "Cameroon" && !$CameroonWithdraw)) {
            $status = "error";
            $message = "$countryname withdrawal is currently not available";
            $genMsg = sendResponse($status, $message);
        } 
        // Check for wallet-specific withdrawal availability
        else if (($wallet == "activity" && !$activityWithdraw) || 
                 ($wallet == "referral" && !$refWithdraw) || 
                 ($wallet == "social" && !$sociWithdraw)) {
            $status = "error";
            $message = "$wallet wallet withdrawal is currently not available";
            $genMsg = sendResponse($status, $message);
        } 
        else {
            // Check for pending withdrawals
            $sql = $link->prepare("SELECT * FROM withdrawals WHERE username=? AND status='pending'");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = $sql->get_result();
            $numrow_link = $result->num_rows;

            // Check for existing bank accounts
            $sql = $link->prepare("SELECT * FROM bankaccounts WHERE username=?");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = $sql->get_result();
            $numrow_bnAcct = $result->num_rows;

            if ($numrow_bnAcct == 0) {
                $status = "error";
                $message = "You have not set up any bank account. Update your profile to withdraw";
                $genMsg = sendResponse($status, $message);
            } else if ($numrow_link > 0) {
                $status = "error";
                $message = "You have a pending withdrawal already";
                $genMsg = sendResponse($status, $message);
            } 
            else {
                // Insert withdrawal request
                $sql = $link->prepare("INSERT INTO withdrawals(username, type, amount, description, countryname, number, plan, date) VALUES(?,?,?,?,?,?,?,?)");
                $sql->bind_param("ssssssss", $username, $wallet, $amount, $acctName, $countryname, $acctNum, $acctPlan, $dateTime);
                if ($sql->execute()) {
                    // Update user funds based on wallet type
                    if ($wallet == "activity") {
                        $sql = $link->prepare("UPDATE users SET funds=funds - ? WHERE username=?");
                    } elseif ($wallet == "referral") {
                        $sql = $link->prepare("UPDATE users SET referralfunds=referralfunds - ? WHERE username=?");
                    } elseif ($wallet == "social") {
                        $sql = $link->prepare("UPDATE users SET score=score - ? WHERE username=?");
                    }
                    $sql->bind_param("ss", $amount, $username);
                    $sql->execute();

                    // Fetch updated user data
                    $sql = $link->prepare("SELECT * FROM users WHERE username=?");
                    $sql->bind_param("s", $username);
                    $sql->execute();
                    $result = $sql->get_result();
                    $row = $result->fetch_assoc();
                    $funds = $row['funds'];
                    $referralFunds = $row['referralfunds'];
                    $score = $row['score'];

                    $status = "success";
                    $amount = number_format($amount, 2);
                    $message = "Successfully placed a soft withdrawal of $amount from your $wallet wallet. Kindly wait for the alert.";
                    $genMsg = sendResponse($status, $message);

                } else {
                    $status = "error";
                    $message = "Something went wrong";
                    $genMsg = sendResponse($status, $message);
                }
            }
        }
    }
}















if (isset($_POST['withdrawtodp'])) {
    if (empty($_POST['amount'])) {
        $status = "error";
        $message = "Enter an amount to transfer";
        $genMsg = sendResponse($status, $message);
    } else {
        $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
        $sql = $link->prepare("SELECT * FROM users WHERE username = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $funds = $row['funds'];

        // Define a fixed charge
        $fixed_charge = 2000; // fixed charge

        // Calculate the total amount to deduct including the fixed charge
        $total_deduct = $amount + $fixed_charge;

        if ($total_deduct > $funds) {
            $status = "error";
            $message = "Insufficient funds in Activity funds";
            $genMsg = sendResponse($status, $message);
        } else {
            $sql = $link->prepare("UPDATE users SET funds = funds - ?, vtubalance = vtubalance + ? WHERE username = ?");
            $sql->bind_param("dds", $total_deduct, $amount, $username);
            if ($sql->execute()) {
                $funds -= $total_deduct;
                $vtubalance += $amount;

                $type = "Activity funds transferred to VTU Balance";
                $time = date("H:i:s");
                $dateTime = date("Y-m-d");

                $sql = $link->prepare("INSERT INTO userearnings (username, type, amount, time, date) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param("ssdss", $username, $type, $amount, $time, $dateTime);
                $sql->execute();

                $status = "success";
                $message = "NP $amount Activity funds transferred to VTU Balance, with a charge of NP $fixed_charge";
                $genMsg = sendResponse($status, $message);
            } else {
                $status = "error";
                $message = "Something went wrong";
                $genMsg = sendResponse($status, $message);
            }
        }
    }
}




?>