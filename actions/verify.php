<?php 
require($_SERVER['DOCUMENT_ROOT']."/stream.php") ;
require($_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php") ;
require($_SERVER['DOCUMENT_ROOT']."$stream/includes/verifytransactions.php") ;
require($_SERVER['DOCUMENT_ROOT']."$stream/app/includes/generalinclude.php") ;



if(isset($_POST['fundWallet']) && !empty($_POST['fundWallet'])){
	$amount=$_POST['amount'];
	$amount=filter_string($amount) ;
	$status=$_POST['status'];
	$status=filter_string($status) ;
	$transactionid=$_POST['transactionid'];
	$transactionid=filter_string($transactionid) ;
	$reference=$_POST['reference'];
	$reference=filter_string($reference) ;
	$gateWay=$_POST['gateWay'];
	$gateWay=filter_string($gateWay) ;
	$currency=$_POST['currency'];
	$currency=filter_string($currency) ;
	$channel=$_POST['channel'];
	$channel=filter_string($channel) ;
	
	if($channel == "webhook") {
		$username=$funds="";
		$email=filter_string($_POST['email']) ;
		$sql=$link->prepare("SELECT * FROM users WHERE email=?");
		$sql->bind_param("s", $email);
		$sql->execute();
		$result=$sql->get_result();
		$numrow=$result->num_rows;
		if($numrow == 1){
			$username=$row['username'];
			$funds=$row['funds'];
		}
	} 
		
	if(empty($amount) || empty($username) || empty($status) || empty($transactionid)) {
		$status="error" ;
		$message="Missing Params" ;
		echo json_encode(array("status" => $status, "message" => $message));
		exit;
	}

	$verifyTrx=verifyFlutterWaveTransaction($transactionid) ;
	$verifyTrx=json_decode($verifyTrx, true) ;
	// print_r($verifyTrx);
	// exit;
	$status=$verifyTrx['data']['status'];
	$message=$verifyTrx['message'];
	$amt=$verifyTrx['data']['amount'];
	$payment_type=$verifyTrx['data']['payment_type'];
	$curr=$verifyTrx['data']['currency'];
	$balanceBefore=$funds;
	$balanceAfter=$balanceBefore + $amt;
	
	$sql=$link->prepare("SELECT * FROM fundwallet WHERE email=? AND trxid=?") ;
	$sql->bind_param("ss", $email, $transactionid) ;
	$sql->execute() ;
	$result=$sql->get_result() ;
	$numRows=$result->num_rows;
	if($numRows > 0){
		$status="error" ;
		$message="Instance already exists" ;
		echo json_encode(array("status" => $status, "message" => $message));
		exit;
	} 
	
	if($status=="successful" && $amount >= $amt && $currency == $curr) {
		$sql=$link->prepare("SELECT * FROM fundwallet WHERE email=?");
		$sql->bind_param("s", $email);
		$sql->execute();
		$result=$sql->get_result();
		$numrow_funding=$result->num_rows;

		$sql=$link->prepare("INSERT INTO fundwallet(code, username, email, amount, channel, status, trxid, initiatedfrom, date, message, currency, balancebefore, balanceafter) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
		$sql->bind_param("sssssssssssss", $reference, $username, $email, $amount, $payment_type, $status, $transactionid, $gateWay, $dateTime, $message, $currency, $balanceBefore, $balanceAfter) ;
		if($sql->execute()) {
			$sql=$link->prepare("UPDATE users SET funds=funds + ? WHERE username=? ") ;
			$sql->bind_param("ss", $amt, $username) ;
		}
		if($sql->execute()) {
			if($numrow_funding == 0){
				$sql=$link->prepare("SELECT * FROM referrals WHERE username=?");
				$sql->bind_param("s", $username);
				$sql->execute();
				$result=$sql->get_result();
				$numrow_ref=$result->num_rows;	
				if($numrow_ref == 1){
					$refUsername=$row['referral'];
					$sql=$link->prepare("UPDATE users SET referralfunds=referralfunds + ? WHERE username=?");
					$sql->bind_param("ss", $refCommFirstDeposit, $refUsername);
					$sql->execute();
				}			
			}
            
            $sql=$link->prepare("SELECT * FROM referrals WHERE username=?");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result=$sql->get_result();
            $numrow_refUser=$result->num_rows;
            if($numrow_refUser == 1){
                $row=$result->fetch_assoc();
                $refUsername=$row['referral'];

                $sql=$link->prepare("SELECT * FROM users WHERE username=?");
                $sql->bind_param("s", $refUsername);
                $sql->execute();
                $result=$sql->get_result();
                $numrow_refUser=$result->num_rows;
                $row=$result->fetch_assoc();
                $refVerifiedRef=$row['verified'];
                $refAcctTypeRef=$row['acctype'];
                
                $sql=$link->prepare("SELECT * FROM users WHERE username=?");
                $sql->bind_param("s", $username);
                $sql->execute();
                $result=$sql->get_result();
                $numrow_refUser=$result->num_rows;
                $row=$result->fetch_assoc();
                $refVerifiedUser=$row['verified'];
                $refAcctTypeUser=$row['acctype'];
                
                $sql=$link->prepare("SELECT SUM(amount) AS totalFunding FROM fundwallet WHERE username=?");
                $sql->bind_param("s", $refUsername);
                $sql->execute();
                $result=$sql->get_result();
                $numrow_fundingRef=$result->num_rows;
                $rowRef=$result->fetch_assoc();
                
                $sql=$link->prepare("SELECT SUM(amount) AS totalFunding FROM fundwallet WHERE username=?");
                $sql->bind_param("s", $username);
                $sql->execute();
                $result=$sql->get_result();
                $numrow_fundingUser=$result->num_rows;
                $rowUser=$result->fetch_assoc();
                
                if($numrow_fundingRef > 0){
                    $totalFundingRef=$rowRef['totalFunding'];
                    $totalFundingUser=$rowUser['totalFunding'];
                    if($refAcctTypeUser == "free"){
                        if($totalFundingRef >= 500 && $totalFundingUser >= 500 && $refVerifiedUser && $refVerifiedRef){
                            $refBonus=0;
                            $sql=$link->prepare("UPDATE users SET referralfunds=referralfunds + ? WHERE username=?");
                            $sql->bind_param("ss", $refBonus, $refUsername);
                            $sql->execute();
                            
                            $sql=$link->prepare("UPDATE referrals SET earnings=? WHERE reference=?");
                     	    $sql->bind_param("ss", $refBonus, $reference);
                  	        $sql->execute();
                        }
                    }
                    else{
                        $sql=$link->prepare("UPDATE referrals SET earnings=? WHERE reference=?");
                        $sql->bind_param("ss", $refBonus, $reference);
                        $sql->execute();
                        
                        $sql=$link->prepare("UPDATE users SET referralfunds=referralfunds + ? WHERE username=?");
                        $sql->bind_param("ss", $refBonus, $refUsername);
                        $sql->execute();
                    }
                }
            }
                        
                                
			$status="success" ;
			$message="Wallet funded successfully" ;
			echo json_encode(array("status" => $status, "message" => $message));
		}
		else{
			$status="partial" ;
			$message="Wallet funded but something went wrong" ;
			echo json_encode(array("status" => $status, "message" => $message));
		}
	}
	else{
		$status="error" ;
		$message="Wallet funding failed" ;
		echo json_encode(array("status" => $status, "message" => $message));
	}
}

?> 