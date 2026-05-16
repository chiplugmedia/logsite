<?php
$genMsg="";
if(isset($_POST['saveDetails'])){
    
    if(!empty($_POST['firstname'])){
        $firstname=$_POST['firstname'];
    }
    if(!empty($_POST['lastname'])){
        $lastname=$_POST['lastname'];
    }
    if(!empty($_POST['email'])){
        $email=$_POST['email'];
    }
    if(!empty($_POST['phone'])){
        $phoneNumber=$_POST['phone'];
    }

    if(empty($_POST['firstname'])){
        $status="error";
        $message="Enter your firstname"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['lastname'])){
        $status="error";
        $message="Enter your last name";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['email'])){
        $status="error";
        $message="Your email address";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['phone'])){
        $status="error";
        $message="Enter your phone number";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $firstname=filter_string($_POST['firstname']);
        $lastname=filter_string($_POST['lastname']);
        $email=filter_string($_POST['email']);
        $phone=filter_string($_POST['phone']);
        $fullname="$firstname $lastname";
      
        $sql=$link->prepare("UPDATE users SET fullname=?, email=?, phone=? WHERE username=?");
        $sql->bind_param("ssss", $fullname, $email, $phone, $username);
        if($sql->execute()){
            $status="success";
            $message="Details updated";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['saveFlutterwave'])){
    if(empty($_POST['flwSecretKey'])){
        $status="error";
        $message="Enter Bank";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['flwPublicKey'])){
        $status="error";
        $message="Enter Account name";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['paymentaccount'])){
        $status="error";
        $message="Enter Account number";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $flwSecretKey=filter_string($_POST['flwSecretKey']);
        $flwPublicKey=filter_string($_POST['flwPublicKey']);
        $paymentAccount=filter_string($_POST['paymentaccount']);
        $sql=$link->prepare("SELECT * FROM sitedetails");
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        if($numrow == 0){
            $sql=$link->prepare("INSERT INTO sitedetails(flwsecretkey, flwpublickey,paymentaccount, date) VALUES(?,?,?,?)");
        }
        else{
            $sql=$link->prepare("UPDATE sitedetails SET flwsecretkey=?, flwpublickey=?,paymentaccount=?, date=?");
        }
        $sql->bind_param("ssss", $flwSecretKey, $flwPublicKey,$paymentAccount, $dateTime);
        if($sql->execute()){
            $status="success";
            $message="Bank Details updated";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }
    }
}


if(isset($_POST['deleteMsgusees'])){
    $sql = $link->prepare("DELETE FROM products");
    if($sql->execute()){
        $status = "success";
        $message = "All usertasks deleted";
        $genMsg = sendResponse($status, $message);
    } else {
        $status = "error";
        $message = "Something went wrong deleting";
        $genMsg = sendResponse($status, $message);
    }
}


if(isset($_POST['deleteusersponsored'])){
    $sql = $link->prepare("DELETE FROM userpurchases");
    if($sql->execute()){
        $status = "success";
        $message = "All activations deleted";
        $genMsg = sendResponse($status, $message);
    } else {
        $status = "error";
        $message = "Something went wrong deleting";
        $genMsg = sendResponse($status, $message);
    }
}

if(isset($_POST['deusert444asks'])){
    $sql = $link->prepare("DELETE FROM users WHERE role = 'user'");
    if($sql->execute()){
        $status = "success";
        $message = "All users in 'user' role deleted";
        $genMsg = sendResponse($status, $message);
    } else {
        $status = "error";
        $message = "Something went wrong deleting";
        $genMsg = sendResponse($status, $message);
    }
}
if(isset($_POST['saveEarnings'])){
    if($_POST['dailyLogin'] !=""){
        $dailyLogin=$_POST['dailyLogin'];
    }
    if($_POST['refBonus'] !=""){
        $refBonus=$_POST['refBonus'];
    }
    if($_POST['welBonus'] !=""){
        $mywelcomeBonus=$_POST['welBonus'];
    }
    if($_POST['minRefWithdrawAmt'] !=""){
        $minRefWithdrawAmt=$_POST['minRefWithdrawAmt'];
    }
    if($_POST['minActWithdrawAmt'] !=""){
        $minActWithdrawAmt=$_POST['minActWithdrawAmt'];
    }
    if($_POST['spAmt'] !=""){
        $sponsoredPostAmt=$_POST['spAmt'];
    }
    if($_POST['indRef'] !=""){
        $indRef=$_POST['indRef'];
    }
    if($_POST['thirdIndRef'] !=""){
        $thirdIndRef=$_POST['thirdIndRef'];
    }
    
    if($_POST['dailyLogin'] ==""){
        $status="error";
        $message="Enter daily login"; 
        $genMsg=sendResponse($status, $message);
    }
    
    else if($_POST['refBonus'] ==""){
        $status="error";
        $message="Enter referral amount"; 
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['welBonus'] ==""){
        $status="error";
        $message="Enter acct welcome bonus"; 
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['minRefWithdrawAmt'] ==""){
        $status="error";
        $message="Enter minimum referral wallet withdrawal amount";
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['minActWithdrawAmt'] ==""){
        $status="error";
        $message="Enter minimum act wallet withdrawal amount";
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['spAmt'] ==""){
        $status="error";
        $message="Enter sponsored post amount";
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['indRef'] ==""){
        $status="error";
        $message="Enter indirect bonus"; 
        $genMsg=sendResponse($status, $message);
    }
    else if($_POST['thirdIndRef'] ==""){
        $status="error";
        $message="Enter third indirect bonus"; 
        $genMsg=sendResponse($status, $message);
    }
    else{
        $dailyLogin=filter_string($_POST['dailyLogin']);
        $refBonus=filter_string($_POST['refBonus']);
        $welcomeBonus=filter_string($_POST['welBonus']);
        $minRefWithdrawAmt=filter_string($_POST['minRefWithdrawAmt']);
        $minActWithdrawAmt=filter_string($_POST['minActWithdrawAmt']);
        $sponsoredPostAmt=filter_string($_POST['spAmt']);
        $indRef=filter_string($_POST['indRef']);
        $thirdIndRef=filter_string($_POST['thirdIndRef']);

        $sql=$link->prepare("SELECT * FROM earningstructure");
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        if($numrow == 0){
            $sql=$link->prepare("INSERT INTO earningstructure(dailylogin, refbonus, welbonus, minrefwth, minactwth, spamt, indref, thirdindref, date) VALUES(?,?,?,?,?,?,?,?,?)");
        }
        else{
            $sql=$link->prepare("UPDATE earningstructure SET dailylogin=?, refbonus=?, welbonus=?, minrefwth=?, minactwth=?, spamt=?, indref=?, thirdindref=?, date=?");
        }
        $sql->bind_param("sssssssss", $dailyLogin, $refBonus, $welcomeBonus, $minRefWithdrawAmt, $minActWithdrawAmt, $sponsoredPostAmt, $indRef, $thirdIndRef, $dateTime);
        
        if($sql->execute()){
            $status="success";
            $message="Earnings has been updated";
            $genMsg=sendResponse($status, $message);
            
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }
    }
}

if(isset($_POST['siteDetails'])){
    if(!empty($_POST['sitename'])){
        $sitename = $_POST['sitename'];
    }
    if(!empty($_POST['siteDesc'])){
        $siteDesc = $_POST['siteDesc'];
    }
    if(!empty($_POST['sitetag'])){
        $sitetag = $_POST['sitetag'];
    }
    if(!empty($_POST['apiKey'])){
        $apiKey = $_POST['apiKey'];
    }
    
    $enableAct = $enableRef = $enableSpin = $enableCameroon = $enableNigeria = $enableGhana = $enableSierraLeone = $enableSouthAfrica = $enableKenya = $enableTanzania = $enableUganda = $enableAmerica =$enablevtu= $enablesoci= 0;
    
    if(isset($_POST['refWithdraw'])){
        $enableRef = 1;
    }
    
    if(isset($_POST['actWithdraw'])){
        $enableAct = 1;
    }
    
    if(isset($_POST['spinWheel'])){
        $enableSpin = 1;
    }
    if(isset($_POST['CameroonWithdraw'])){
        $enableCameroon = 1;
    }
    if(isset($_POST['NigeriaWithdraw'])){
        $enableNigeria = 1;
    }
    if(isset($_POST['GhanaWithdraw'])){
        $enableGhana = 1;
    }
    if(isset($_POST['SierraLeoneWithdraw'])){
        $enableSierraLeone = 1;
    }
    if(isset($_POST['SouthAfricaWithdraw'])){
        $enableSouthAfrica = 1;
    }
    if(isset($_POST['KenyaWithdraw'])){
        $enableKenya = 1;
    }
    if(isset($_POST['TanzaniaWithdraw'])){
        $enableTanzania = 1;
    }
    if(isset($_POST['UgandaWithdraw'])){
        $enableUganda = 1;
    }
    if(isset($_POST['AmericaWithdraw'])){
        $enableAmerica = 1;
    }
    if(isset($_POST['vtuportal'])){
        $enablevtu=1;
    }
    if(isset($_POST['sociWithdraw'])){
        $enablesoci=1;
    }
    if(empty($_POST['sitename'])){
        $status = "error";
        $message = "Enter sitename";
        $genMsg = sendResponse($status, $message);
    }
    
    else if(empty($_POST['sitetag'])){
        $status = "error";
        $message = "Enter site tagline";
        $genMsg = sendResponse($status, $message);
    }
    else if(empty($_POST['apiKey'])){
        $status = "error";
        $message = "Enter vtu api key";
        $genMsg = sendResponse($status, $message);
    }
    else {
    $sql = $link->prepare("SELECT * FROM sitedetails");
    $sql->execute();
    $result = $sql->get_result();
    $numrow = $result->num_rows;

    if ($numrow == 0) {
        $sql = $link->prepare("INSERT INTO sitedetails (sitename, sitedesc, sitetag, apikey, refwithdraw, mainwithdraw, spinwheel, CameroonWithdraw, NigeriaWithdraw, GhanaWithdraw, SierraLeoneWithdraw, SouthAfricaWithdraw, KenyaWithdraw, TanzaniaWithdraw, UgandaWithdraw, AmericaWithdraw,vtuportal,sociWithdraw, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
    } else {
        $sql = $link->prepare("UPDATE sitedetails SET sitename=?, sitedesc=?, sitetag=?, apikey=?, refwithdraw=?, mainwithdraw=?, spinwheel=?, CameroonWithdraw=?, NigeriaWithdraw=?, GhanaWithdraw=?, SierraLeoneWithdraw=?, SouthAfricaWithdraw=?, KenyaWithdraw=?, TanzaniaWithdraw=?, UgandaWithdraw=?, AmericaWithdraw=?, vtuportal=?, sociWithdraw=?,date=?");
    }

    $sql->bind_param("ssssiiiiiiiiiiiiiis", $sitename, $siteDesc, $sitetag, $apiKey, $enableRef, $enableAct, $enableSpin, $enableCameroon, $enableNigeria, $enableGhana, $enableSierraLeone, $enableSouthAfrica, $enableKenya, $enableTanzania, $enableUganda, $enableAmerica,$enablevtu,$enablesoci, $date);
if($sql->execute()){
            $actWithdraw=$enableAct;
            $refWithdraw=$enableRef;
            $spinWheel=$enableSpin;
            $CameroonWithdraw=$enableCameroon;
            $NigeriaWithdraw=$enableNigeria;
            $GhanaWithdraw=$enableGhana;
            $SierraLeoneWithdraw=$enableSierraLeone;
            $SouthAfricaWithdraw=$enableSouthAfrica;
            $KenyaWithdraw=$enableKenya;
            $TanzaniaWithdraw=$enableTanzania;
            $UgandaWithdraw=$enableUganda;
            $AmericaWithdraw=$enableAmerica;
            $vtuportal=$enablevtu;
            $sociWithdraw=$enablesoci;
            $status="success";
            $message="Site details updated";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }



        if(isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0){
            // Handle image upload for site logo
            $imageName = $_FILES['image']['name'];
            $imageType = $_FILES['image']['type'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageSize = $_FILES['image']['size'];
            $imgExtArr = explode(".", $imageName);
            $newImgName = get_rand_alphanumeric(10).".".end($imgExtArr);
            $allowed = array("png" => "image/png", "jpeg" => "image/jpeg", "jpg" => "image/jpg", "heic" => "application/octet-stream");
            $maxSize = 5 * 1024 * 1024;
            $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            if(!array_key_exists($extension, $allowed) || !in_array($imageType, $allowed) || $imageSize > $maxSize){
                $status = "error";
                $message = "Invalid image file";
                $genMsg = sendResponse($status, $message);
            }
            else{
                if($siteLogo != ""){
                    $oldPath = $_SERVER['DOCUMENT_ROOT']."$stream/app/assets/img/sitelogo/$siteLogo";
                    unlink($oldPath);
                }
                $path = $_SERVER['DOCUMENT_ROOT']."$stream/app/assets/img/sitelogo/$newImgName";
                move_uploaded_file($imageTmpName, $path);
                $siteLogo = $newImgName;
                $sql = $link->prepare("UPDATE sitedetails SET sitelogo=?");
                $sql->bind_param("s", $newImgName);
                $sql->execute();
            }
        }
        
        if(isset($_FILES['imagefav']['name']) && $_FILES['imagefav']['error'] == 0){
            // Handle image upload for site favicon
            $imageName = $_FILES['imagefav']['name'];
            $imageType = $_FILES['imagefav']['type'];
            $imageTmpName = $_FILES['imagefav']['tmp_name'];
            $imageSize = $_FILES['imagefav']['size'];
            $imgExtArr = explode(".", $imageName);
            $newImgName = get_rand_alphanumeric(10).".".end($imgExtArr);
            $allowed = array("png" => "image/png", "jpeg" => "image/jpeg", "jpg" => "image/jpg", "heic" => "application/octet-stream");
            $maxSize = 5 * 1024 * 1024;
            $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            if(!array_key_exists($extension, $allowed) || !in_array($imageType, $allowed) || $imageSize > $maxSize){
                $status = "error";
                $message = "Invalid image file";
                $genMsg = sendResponse($status, $message);
            }
            else{
                if($siteFav != ""){
                    $oldPath = $_SERVER['DOCUMENT_ROOT']."$stream/app/assets/img/sitelogo/$siteFav";
                    unlink($oldPath);
                }
                $path = $_SERVER['DOCUMENT_ROOT']."$stream/app/assets/img/sitelogo/$newImgName";
                move_uploaded_file($imageTmpName, $path);
                $siteFav = $newImgName;
                $sql = $link->prepare("UPDATE sitedetails SET sitefav=?");
                $sql->bind_param("s", $newImgName);
                $sql->execute();
            }
        }
    }




if(isset($_POST['saveMonnify'])){
    if(empty($_POST['mfySecKey'])){
        $status="error";
        $message="Enter monnify secret key";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['mfyApiKey'])){
        $status="error";
        $message="Enter monnify API key";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['mfyContractCode'])){
        $status="error";
        $message="Enter monnify contract code";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $mfySecKey=filter_string($_POST['mfySecKey']);
        $mfyApiKey=filter_string($_POST['mfyApiKey']);
        $mfyContractCode=filter_string($_POST['mfyContractCode']);
        $sql=$link->prepare("SELECT * FROM sitedetails");
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        if($numrow == 0){
            $sql=$link->prepare("INSERT INTO sitedetails(mfyseckey, mfyapikey, mfycontractcode, date) VALUES(?,?,?,?)");
        }
        else{
            $sql=$link->prepare("UPDATE sitedetails SET mfyseckey=?, mfyapikey=?, mfycontractcode=?, date=?");
        }
        $sql->bind_param("ssss", $mfySecKey, $mfyApiKey, $mfyContractCode, $dateTime);
        if($sql->execute()){
            $status="success";
            $message="Monnify keys updated";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $genMsg=sendResponse($status, $message);
        }
    }
}


if(isset($_POST['addMtnData'])){

    if(validateInput()){
        $data1=$mtnSME500MB=filter_string($_POST['data1']);
        $data2=$mtnSME1GB=filter_string($_POST['data2']);
        $data3=$mtnSME2GB=filter_string($_POST['data3']);
        $data4=$mtnSME5GB=filter_string($_POST['data4']);
        $data5=$mtnSME10GB=filter_string($_POST['data5']);
        $data6=$mtnCG500MB=filter_string($_POST['data6']);
        $data7=$mtnCG1GB=filter_string($_POST['data7']);
        $data8=$mtnCG2GB=filter_string($_POST['data8']);
        $data9=$mtnCG5GB=filter_string($_POST['data9']);
        $data10=$mtnCG10GB=filter_string($_POST['data10']);

        $network="mtn";
        $data=array(
            array(
                "dataPlan" => "500MB", 
                "serviceID" => 10, 
                "dataType" => "sme", 
                "amount" => $data1
            ), 
            array(
                "dataPlan" => "1GB", 
                "serviceID" => 11, 
                "dataType" => "sme", 
                "amount" => $data2
            ), 
            array(
                "dataPlan" => "2GB", 
                "serviceID" => 12, 
                "dataType" => "sme", 
                "amount" => $data3
            ), 
            array(
                "dataPlan" => "5GB", 
                "serviceID" => 13, 
                "dataType" => "sme", 
                "amount" => $data4
            ),
            array(
                "dataPlan" => "10GB", 
                "serviceID" => 14, 
                "dataType" => "sme", 
                "amount" => $data5
            ), 
            array(
                "dataPlan" => "500MB", 
                "serviceID" => 15, 
                "dataType" => "cg", 
                "amount" => $data6
            ), 
            array(
                "dataPlan" => "1GB", 
                "serviceID" => 16, 
                "dataType" => "cg", 
                "amount" => $data7
            ), 
            array(
                "dataPlan" => "2GB", 
                "serviceID" => 17, 
                "dataType" => "cg", 
                "amount" => $data8
            ), 
            array(
                "dataPlan" => "5GB", 
                "serviceID" => 18, 
                "dataType" => "cg", 
                "amount" => $data9
            ), 
            array(
                "dataPlan" => "10GB", 
                "serviceID" => 19, 
                "dataType" => "cg", 
                "amount" => $data10
            )
        );
        $genMsg=updateDataPrices($network, $data);
        
    }
    else{
        $status="error";
        $message="Amount for one or more field is required";
        $genMsg=sendResponse($status, $message);
    }
 }



if(isset($_POST['addGloData'])){

   if(validateInput()){
        $data1=$glo1_35GB=filter_string($_POST['data1']);
        $data2=$glo2_90GB=filter_string($_POST['data2']);
        $data3=$glo4_10GB=filter_string($_POST['data3']);
        $data4=$glo5_80GB=filter_string($_POST['data4']);
        $data5=$glo10GB=filter_string($_POST['data5']);

        $network="glo";
        $data=array(
            array(
                "dataPlan" => "1.35GB", 
                "serviceID" => 20, 
                "dataType" => "direct", 
                "amount" => $data1
            ), 
            array(
                "dataPlan" => "2.90GB", 
                "serviceID" => 21, 
                "dataType" => "direct", 
                "amount" => $data2
            ), 
            array(
                "dataPlan" => "4.10GB", 
                "serviceID" => 22, 
                "dataType" => "direct", 
                "amount" => $data4
            ),
            array(
                "dataPlan" => "5.80GB", 
                "serviceID" => 23, 
                "dataType" => "direct", 
                "amount" => $data3
            ), 
            array(
                "dataPlan" => "10GB", 
                "serviceID" => 24, 
                "dataType" => "direct", 
                "amount" => $data5
            )
        );
        $genMsg=updateDataPrices($network, $data);
        
    }
    else{
        $status="error";
        $message="Amount for one or more field is required";
        $genMsg=sendResponse($status, $message);
    }
}


if(isset($_POST['addAirtelData'])){

    if(validateInput()){
        $data1=$airtel500MB=filter_string($_POST['data1']);
        $data2=$airtel1GB=filter_string($_POST['data2']);
        $data3=$airtel2GB=filter_string($_POST['data3']);
        $data4=$airtel5GB=filter_string($_POST['data4']);
        $data5=$airtel10GB=filter_string($_POST['data5']);

        $network="airtel";
        $data=array(
            array(
                "dataPlan" => "500MB", 
                "serviceID" => 25, 
                "dataType" => "cg", 
                "amount" => $data1
            ), 
            array(
                "dataPlan" => "1GB", 
                "serviceID" => 26, 
                "dataType" => "cg", 
                "amount" => $data2
            ), 
            array(
                "dataPlan" => "2GB", 
                "serviceID" => 27, 
                "dataType" => "cg", 
                "amount" => $data3
            ), 
            array(
                "dataPlan" => "5GB",
                "serviceID" => 28, 
                "dataType" => "cg",  
                "amount" => $data4
            ), 
            array(
                "dataPlan" => "10GB", 
                "serviceID" => 29, 
                "dataType" => "cg", 
                "amount" => $data5
            )
        );
        $genMsg=updateDataPrices($network, $data);
        
    }
    else{
        $status="error";
        $message="Amount for one or more field is required";
        $genMsg=sendResponse($status, $message);
    }
}


if(isset($_POST['add9mobileData'])){

    if(validateInput()){
        $data1=$etisalat500MB=filter_string($_POST['data1']);
        $data2=$etisalat1_5GB=filter_string($_POST['data2']);
        $data3=$etisalat2GB=filter_string($_POST['data3']);
        $data4=$etisalat3GB=filter_string($_POST['data4']);
        $data5=$etisalat11GB=filter_string($_POST['data5']);

        $network="9mobile";
        $data=array(
            array(
                "dataPlan" => "500MB", 
                "serviceID" => 30,
                "dataType" => "direct",  
                "amount" => $data1
            ), 
            array(
                "dataPlan" => "1.5GB", 
                "serviceID" => 31,
                "dataType" => "direct",  
                "amount" => $data2
            ), 
            array(
                "dataPlan" => "2GB", 
                "serviceID" => 32, 
                "dataType" => "direct", 
                "amount" => $data3
            ), 
            array(
                "dataPlan" => "3GB", 
                "serviceID" => 33, 
                "dataType" => "direct", 
                "amount" => $data4
            ), 
            array(
                "dataPlan" => "11GB", 
                "serviceID" => 34, 
                "dataType" => "direct", 
                "amount" => $data5
            )
        );
        $genMsg=updateDataPrices($network, $data);
        
    }
    else{
        $status="error";
        $message="Amount for one or more field is required";
        $genMsg=sendResponse($status, $message);
    }
}

function validateInput(){

    $count=0;
    $totalCount=count($_POST);
    foreach($_POST as $key => $value){
        if($_POST[$key] == ""){
            break;
        }
        else {
            $count++;
        }
    }

    if($count == $totalCount){
        $response=true;
    }
    else{
        $response=false;
    }
    return $response;
}

function updateDataPrices($network, $datas){
    global $link, $dateTime;

    $sql=$link->prepare("SELECT * FROM dataprices WHERE network=? ");
    $sql->bind_param("s", $network);
    $sql->execute();
    $result=$sql->get_result();
    $numrow=$result->num_rows;

    if($numrow == 0){
        $sql=$link->prepare("INSERT INTO dataprices(network, dataplan, amount, serviceid, datatype, date) VALUES(?,?,?,?,?,?)");
        $sql->bind_param("ssssss", $network, $dataPlan, $amount, $serviceID, $dataType, $dateTime);
    }
    else{
        $sql=$link->prepare("UPDATE dataprices SET amount=? WHERE dataplan=? AND network=? AND datatype=?");
        $sql->bind_param("ssss", $amount, $dataPlan, $network, $dataType);
    }
    foreach($datas as $key => $data){
        $dataPlan=$datas[$key]['dataPlan'];
        $amount=$datas[$key]['amount'];
        $serviceID=$datas[$key]['serviceID'];
        $dataType=$datas[$key]['dataType'];
        $sql->execute();
    }

    $status="success";
    $message=strtoupper($network)." Prices updated";

    return sendResponse($status, $message);
}
 }
  
?>