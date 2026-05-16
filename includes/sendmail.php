<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require $_SERVER['DOCUMENT_ROOT'] . "$stream/mailer/src/Exception.php";
require $_SERVER['DOCUMENT_ROOT'] . "$stream/mailer/src/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT'] . "$stream/mailer/src/SMTP.php"; 

function sendMail($email, $fullname, $message, $subject, $type="") {
    $sitelink = "pinatexlogs.com";
    $body = "
        <head>
            <link rel='preconnect' href='https://fonts.googleapis.com'>
            <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
            <link href='https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap' rel='stylesheet'>
            <style>
                body {
                    font-family: 'Nunito', sans-serif !important;
                }
                /* Buy Button */
.buy-btn {
    background: linear-gradient(135deg, #00bf63 0%, #ffbd59 100%);
    color: #fff; font-size: 0.875rem; font-weight: 600; padding: 0.75rem 1.5rem;
    border-radius: 0.5rem; border: none; display: flex; align-items: center; gap: 0.5rem;
    transition: all 0.3s ease; white-space: nowrap; box-shadow: 0 2px 4px rgba(0, 191, 99, 0.2); flex-shrink: 0;
}
.buy-btn:hover { background: linear-gradient(135deg, #00a857 0%, #e6a84e 100%); transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 191, 99, 0.3); }
.buy-btn:active { transform: translateY(0); box-shadow: 0 1px 2px rgba(0, 191, 99, 0.2); }
.
            </style>
        </head>
        <body style='font-family: Nunito, sans-serif !important; font-size: 15px !important; font-weight: 400 !important;'>
    ";

    if ($type == "forgotPsw") {
        $fullname = $message['fullname'];
        $pswToken = $message['pswToken'];

        $body .= "
        <div style='margin-top: 50px;'>
    <table cellpadding='0' cellspacing='0' style='font-family: Nunito, sans-serif; font-size: 15px; font-weight: 400; max-width: 600px; border: none; margin: 0 auto; border-radius: 6px; overflow: hidden; background-color: #fff; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);'>
        <thead>
            <tr style='background-color: #FFF; padding: 3px 0; line-height: 68px; text-align: center; color: #fff; font-size: 24px; font-weight: 700; letter-spacing: 1px;'>
                <th scope='col'><img src='https://$sitelink/mailer/young.png' width='150' alt='Logo'></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style='padding: 48px 24px 0; color: #000; font-size: 18px; font-weight: 600;'>
                    Hello, $fullname
                </td>
            </tr>
            <tr>
                <td style='padding: 15px 24px; color: #000;'>
                    To reset your password, please click the button below:
                </td>
            </tr>
            <tr>
                <td style='padding: 15px 24px; text-align: center;'>
                    <a href='https://$sitelink/reset-password.php?tkn=$pswToken' style='display: block; text-align: center;'class='buy-btn'>Reset Password</a>
                </td>
            </tr>
            <tr>
                <td style='padding: 15px 24px 0; color: #000;'>
                    This link will be active for 2 minutes from the time this email was sent. If you did not request to reset your password, please ignore this email and your account will not be affected or contact us immediately.
                </td>
            </tr>
            <tr>
                <td style='padding: 15px 24px 15px; color: #f55366; font-size: 15px; font-weight: 600;'>
                    This Email Was Generated Automatically. Kindly Contact Us Using The Email Below
                </td>
            </tr>
            <tr>
                <td style='padding: 15px 24px 15px; color: #000;'>
                    Pinatexlogs <br> Support Team <br> <a href='https://t.me/YUNGFXi' style='color: #f55366; text-decoration: none;'>https://t.me/YUNGFXi</a>
                </td>
            </tr>
            <tr>
                <td style='padding: 16px 8px; color: #fff; background-color: #f55366; text-align: center;'>
                    &copy; 2025 Pinatexlogs.
                </td>
            </tr>
        </tbody>
    </table>
</div>

        ";
    } else if ($type == "welcomeMail") {
        $body .= "
        <div style='margin-top: 50px;'>
            <table cellpadding='0' cellspacing='0' style='font-family: Nunito, sans-serif !important; font-size: 15px !important; font-weight: 400 !important; max-width: 600px !important; border: none !important; margin: 0 auto !important; border-radius: 6px !important; overflow: hidden !important; background-color: #fff !important; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15) !important;'>
                <thead>
                    <tr style='background-color: #fff !important; padding: 3px 0 !important; line-height: 68px !important; text-align: center !important; color: #fff !important; font-size: 24px !important; font-weight: 700 !important; letter-spacing: 1px !important;'>
                        <th scope='col'><img src='https://$sitelink/mailer/young.png' width='150' alt=''></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #161c2d !important; font-size: 15px !important; font-weight: 600 !important;'>
                            Welcome Onboard $fullname
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 0 !important; color: #000 !important;'>
                           We are elated to become part of your journey at this time. It is so good of you to join the simplest platform where you can accounts that can be useful for various purposes, whether it's for marketing, brand promotion, newsletters, and much more.. <br>
                           Our support team is one click away should you need any help as you journey through Youngacctsocials. <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #000 !important;'>
                            send an email to info@$sitelink<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #000 !important;'>
                            Also follow us on social media at:<br><br>
                            https://t.me/+huq-AgqvOU0wMzg0<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #000 !important;'>
                            We are always one step away to assist you with whatever you need to make your journey smooth.<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #000 !important;'>
                            Thank you $fullname for choosing us.<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #f55366 !important; font-size: 15px !important; font-weight: 600 !important;'>
                            Got Queries? No Worries. Kindly Contact Us Using The link Below
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #000 !important;'>
                            Pinatexlogs <br> Support Team <br> https://t.me/YUNGFXi
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 16px 8px !important; color: #fff !important; background-color:#f55366 !important; text-align: center !important;'>
                            &copy; 2024 Pinatexlogs.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        ";
    } else if($type == "adminMail"){
        $body.="
        <div style='margin-top: 50px;'>
            <table cellpadding='0' cellspacing='0' style='font-family: Nunito, sans-serif !important; font-size: 15px !important; font-weight: 400 !important; max-width: 600px !important; border: none !important; margin: 0 auto !important; border-radius: 6px !important; overflow: hidden !important; background-color: #fff !important; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15) !important;'>
                <thead>
                    <tr style='background-color: #fff !important; padding: 3px 0 !important; line-height: 68px !important; text-align: center !important; color: #fff !important; font-size: 24px !important; font-weight: 700 !important; letter-spacing: 1px !important;'>
                        <th scope='col'><img src='https://$sitelink/mailer/young.png' width='150' alt=''></th>
                    </tr>
                </thead>

                <tbody>
                    
                    <tr>
                        <td style='padding: 15px 24px 15px !important; color: #f55366 !important; font-size: 15px !important; font-weight: 600 !important;'>
                            New Pending Deposit from Pinatexlogs
                        </td>
                    </tr>
                    

                    

                    <tr>
                        <td style='padding: 15px 24px 0 !important; color: #000 !important;'>
                           Hello $fullname  made a deposit wait for approval <br><br></td>
                    </tr>

 
                    <tr>
                        <td style='padding: 16px 8px !important; color: #fff !important; background-color: #f55366 !important; text-align: center !important;'>
                            &copy; 2024 Pinatexlogs.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        ";
    } else if($type == "messagetousers"){
        $body.="
       <div style='margin-top: 50px;'>
            <table cellpadding='0' cellspacing='0' style='font-family: Nunito, sans-serif !important; font-size: 15px !important; font-weight: 400 !important; max-width: 600px !important; border: none !important; margin: 0 auto !important; border-radius: 6px !important; overflow: hidden !important; background-color: #fff !important; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15) !important;'>
                <thead>
                    <tr style='background-color: #fff !important; padding: 3px 0 !important; line-height: 68px !important; text-align: center !important; color: #fff !important; font-size: 24px !important; font-weight: 700 !important; letter-spacing: 1px !important;'>
                        <th scope='col'><img src='https://$sitelink/mailer/young.png' width='150' alt=''></th>
                    </tr>
                </thead>

                <tbody>
                    
                     <tr>
                        <td style='padding: 15px 24px 15px !important; color: #000 !important; font-size: 15px !important; font-weight: 600 !important;'>
                           Hello $fullname <br><br></td>
                    </tr>

                      <tr>
                        <td style='padding: 15px 24px 0 !important; color: #000 !important;'>
                            $message
                        </td>
                    </tr>
                    
                    <tr>

 
                    <tr>
                        <td style='padding: 16px 8px !important; color: #fff !important; background-color: #f55366 !important; text-align: center !important;'>
                            &copy; 2024 Pinatexlogs.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        ";    
    } else {
        $body .= $message;
    }

    $body .= "
        </body>
    ";

    // PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'mail.pinatexlogs.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@pinatexlogs.com';
        $mail->Password   = '97SDj~QX@$O}D[hD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Always match setFrom with your domain to avoid spoofing issues
        $mail->setFrom('info@pinatexlogs.com', 'Pinatextech Network');
        $mail->addAddress($email, $fullname);
        $mail->addReplyTo('info@pinatexlogs.com', 'Pinatextech Network');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        $response = ["status" => "success", "message" => "Mail sent to recipient"];

    } catch (Exception $e) {
        $response = ["status" => "failed", "message" => $e->getMessage()];
    }

    return $response;
}

?>