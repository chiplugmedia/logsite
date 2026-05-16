<?php
$genMsg="";
	if (isset($_POST["submit"])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$message = $_POST['message'];
		$from = 'VistaPay New Contact Form'; 
		$to = 'marvisadeniyi0@gmail.com'; 
		$subject = $_POST['subject']; 
		
		$body = "From: $name\n E-Mail: $email\n Phone: $phone\n Subject: $subject\n Message:\n $message";
	

	mail($to, $subject, $body, $from) or die("Error!");

	$status="success";
    $message="Your message was sent successfully, we'll reply to you soon.";
    $genMsg=sendResponse($status, $message);
	}
	//{
   // $status="error";
    //$message="Something went wrong";
    //$genMsg=sendResponse($status, $message);
    //}
	
?>