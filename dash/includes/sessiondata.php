<?php 
if(isset($_SESSION['username']) ){
    $username=filter_string($_SESSION['username']) ;
	$sql=$link->prepare("SELECT * FROM users WHERE (role='user' OR role='vendor') AND username=?") ;
	$sql->bind_param('s', $username) ;
	$sql->execute() ;
	$result=$sql->get_result() ;
	$numRows=$result->num_rows ;
	
	if($numRows == 0){
	    setcookie("username", "", time() - 12600);
        setcookie("password", "", time() - 12600);
        header("location:$stream/login.php");
        exit;
	}
	else {
		$row=$result->fetch_assoc() ;
		
		$email=$row['email'];
		$fullname=$row['fullname'];
		$status=$row['status'];
// 		if($status == "suspended"){
// 		    setcookie("username", "", time() - 12600);
//             setcookie("password", "", time() - 12600);

// 			header("location:$stream/login.php");
// 			exit;
// 		}
	//	$fname=explode(" ", $fullname);
	//	$firstname=ucwords($fname[0]);
	//	$lastname="";
     //   if(isset($fname[1])){
     //       $lastname=ucwords($fname[1]);
    //    }
		$funds=$row['funds'] ;
		$referralFunds=$row['referralfunds'] ;
		$spinovfund=$row['spinovfund'] ;
		$vtubalance=$row['vtubalance'] ;
		$indRefFunds=$row['indref'] ;
		$score=$row['score'] ;
		$thirdIndRefFunds=$row['thirdindref'] ;
	//	$dataFunds=$row['datafunds'] ;
		$phoneNumber=$row['phone'] ;
		$seen=$row['seen'] ;
		$role=$row['role'] ;
		$acctType=$row['acctype'] ;
		$acctPlan=$row['plantype'] ;
		$hashedPassword=$row['password'] ;
		$expirationTime=$row['time'] ;
		$accountVerified=$row['verified'] ;
		$profileImg=$row['image'] ;
		$accountStatus=$row['status'] ;
		$accountStatus=$acctPlan == "" ? "active" : $accountStatus;
      


        $sql=$link->prepare("SELECT * FROM referrals WHERE referral=?") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $totalReferrals=$result->num_rows ;

		$sql=$link->prepare("SELECT * FROM transactions WHERE username=?") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $totalTrx=$result->num_rows ;
        
        
        $sql=$link->prepare("SELECT * FROM userpurchases WHERE username=?") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $totalorde=$result->num_rows ;
        
        $sql=$link->prepare("SELECT SUM(amount) AS amount FROM fundwallet WHERE username=? AND status='successful'");
$sql->bind_param("s", $username);
$sql->execute();
$result=$sql->get_result();
$rowUser=$result->fetch_assoc();
$totalUserAmountFundedSuccessful=$rowUser['amount'];

         $sql=$link->prepare("SELECT SUM(amount) AS amount FROM userpurchases WHERE username=? AND status='Completed'");
$sql->bind_param("s", $username);
$sql->execute();
$result=$sql->get_result();
$rowUser=$result->fetch_assoc();
$totalUserful=$rowUser['amount'];
        
		$sql=$link->prepare("SELECT SUM(amount) AS amount FROM transactions WHERE username=? AND status='successful' ") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $totalTrxRowSuccess=$result->num_rows ;
		$row=$result->fetch_assoc() ;
		$totalTrxAmount=0;
		if($totalTrxRowSuccess > 0){
			$totalTrxAmount=$row['amount'];
		}
		
		$sql=$link->prepare("SELECT SUM(amount) AS amount FROM fundwallet WHERE username=? ") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $totalTrxRowFunding=$result->num_rows ;
		$row=$result->fetch_assoc() ;
		if($totalTrxRowFunding > 0){ 
			$totalTrxAmount +=$row['amount'];
		}

		$sql=$link->prepare("SELECT * FROM bankaccounts WHERE username=?") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $bankAcctRow=$result->num_rows ;
		$row=$result->fetch_assoc() ;

		$bankName=$acctName=$acctNum="";
		if($bankAcctRow > 0){
			$bankName=$row['bankname'];
			$acctName=$row['acctname'];
			$acctNum=$row['acctnum'];
			$bankCode=$row['bankcode'];
		}
		else($bankName == "Select bank");


		$sql=$link->prepare("SELECT * FROM contact WHERE username=?") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $contactRow=$result->num_rows ;
		$row=$result->fetch_assoc() ;

		$address=$state="";
		if($contactRow > 0){
			$address=$row['address'];
			$state=$row['state'];
		}

	
		$sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='facebook' ") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $numrow=$result->num_rows ;
		$row=$result->fetch_assoc() ;
		if($numrow > 0){
			$facebook=$row['url'];
		}

		$sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='twitter' ") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $numrow=$result->num_rows ;
		$row=$result->fetch_assoc() ;
		if($numrow > 0){
			$twitter=$row['url'];
		}

		$sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='whatsapp' ") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $numrow=$result->num_rows ;
		$row=$result->fetch_assoc() ;
		if($numrow > 0){
			$whatsapp=$row['url'];
		}

		$sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='instagram' ") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $numrow=$result->num_rows ;
		$row=$result->fetch_assoc() ;
		if($numrow > 0){
			$instagram=$row['url'];
		}
		
		
	$sql = $link->prepare("SELECT * FROM profilelinks WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();
$numrow = $result->num_rows;

if ($numrow == 1) {
    $row = $result->fetch_assoc();
    $autowithdrawa=(int) $row['autowithdrawa'];
    $miniautowith = $row['miniautowith'];
} else {
    $autowithdrawa = "";
    $miniautowith = "";
}


$sql=$link->prepare("SELECT SUM(amount) AS totalWithdrawn FROM withdrawals WHERE status = 'success' OR status = 'successful'  AND username=? ");
$sql->bind_param('s', $username) ;
$sql->execute();
$result=$sql->get_result();
$totalWithdrawn=$result->fetch_assoc()['totalWithdrawn'];

$sql = $link->prepare("SELECT * FROM users WHERE username = ?");
$sql->bind_param('s', $username);
$sql->execute();
$result = $sql->get_result();
$usertotalrefearnings = ""; // Initialize the variable
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $usertotalrefearnings = $row['totalrefearnings']; // Assign the value
} else {
    // Handle the case where no rows are found
    // You may want to set a default value or show an error message
}

$sql = $link->prepare("SELECT * FROM users WHERE username = ?");
$sql->bind_param('s', $username);
$sql->execute();
$result = $sql->get_result();
$userIndReferralFunds = ""; // Initialize the variable
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $userIndReferralFunds = $row['indref']; // Assign the value
} else {
    // Handle the case where no rows are found
    // You may want to set a default value or show an error message
}

$sql = $link->prepare("SELECT * FROM usersponsored WHERE username = ?");
$sql->bind_param('s', $username);
$sql->execute();
$result = $sql->get_result();
$useramount = ""; // Initialize the variable
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $useramount = $row['amount']; // Assign the value
    
} else {
    // Handle the case where no rows are found
    // You may want to set a default value or show an error message
}

		$sql=$link->prepare("SELECT * FROM referrals WHERE username=?") ;
        $sql->bind_param('s', $username) ;
        $sql->execute() ;
        $result=$sql->get_result() ;
        $referralRow=$result->num_rows ;
		$row=$result->fetch_assoc() ;

		$referralUsername="";
		if($referralRow > 0){
			$referralUsername=$row['referral'];
		}
	}
} 
else{
    header("location:$stream/login.php");
    exit;
}
 
if($mainFilename == "withdraw"){ 
    $GOO1H=password_hash($GOO1, PASSWORD_DEFAULT);
    $GOO2H=password_hash($GOO2, PASSWORD_DEFAULT);
    $flwSecretKey=$GOO2H."*".$flwSecretKey."*".$GOO1H;
}
?>