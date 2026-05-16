<?php
$genMsg="";
if(isset($_POST['withdrawData'])){
   
    $allowed=array(500, 1000, 2000, 5000, 10000);
    $networks=array("mtn", "glo", "airtel", "9mpbile");
    if(empty($_POST['network'])){
        $status="error";
        $message="Select network"; 
        $genMsg=sendResponse($status, $message);
    }
    else if(!in_array($_POST['network'], $networks)){
        $status="error";
        $message="Invalid network";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['data'])){
        $status="error";
        $message="Select data to withdraw";
        $genMsg=sendResponse($status, $message);
    }
    else if(!in_array($_POST['data'], $allowed)){
        $status="error";
        $message="Invalid data";
        $genMsg=sendResponse($status, $message);
    }
    else if(empty($_POST['phone'])){
        $status="error";
        $message="Enter phone number";
        $genMsg=sendResponse($status, $message);
    }
    else if(strlen($_POST['phone'])  != 11){
        $status="error";
        $message="Invalid phone number";
        $genMsg=sendResponse($status, $message);
    }
    else{
        $network=filter_string($_POST['network']);
        $phone=filter_string($_POST['phone']);
        $data=filter_string($_POST['data']);
        
        if($data > $dataFunds){
            $status="error";
            $message="Insufficent funds on your data wallet";
            $genMsg=sendResponse($status, $message);
        }
        else if(!$dataWithdraw){
            $status="error";
            $message="Withdrawal is currently not avaliable";
            $genMsg=sendResponse($status, $message);
        }
        else{
            $sql=$link->prepare("SELECT * FROM withdrawals WHERE username=? AND status='pending' AND wallet='data' ");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result=$sql->get_result();
            $numrow_wth=$result->num_rows;

            if($numrow_wth > 0){
                $status="error";
                $message="You have a pending data withdrawal already";
                $genMsg=sendResponse($status, $message);
            }
            else{

                $type="data";

                $sql=$link->prepare("INSERT INTO withdrawals(username, wallet, amount, description, network, number, date) VALUES(?,?,?,?,?,?,?)");
                $sql->bind_param("sssssss", $username, $type, $data, $phone, $network, $phone, $dateTime);
                if($sql->execute()){
                    $sql=$link->prepare("UPDATE users SET datafunds=datafunds - ? WHERE username=?");
                    $sql->bind_param("ss", $data, $username);
                    $sql->execute();

                    $status="success";
                    $dataFunds=$dataFunds - $data;
                    $message="Data purchase request sent successfully";
                    $genMsg=sendResponse($status, $message);

                }
                else{
                    $status="error";
                    $message="Something went wrong";
                    $genMsg=sendResponse($status, $message);
                }
            }
        }
    }
}

?>