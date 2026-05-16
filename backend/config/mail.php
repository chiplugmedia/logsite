<?php
declare(strict_types=1);

require_once __DIR__ . '/app.php';
require_once dirname(__DIR__, 2) . '/mailer/src/Exception.php';
require_once dirname(__DIR__, 2) . '/mailer/src/PHPMailer.php';
require_once dirname(__DIR__, 2) . '/mailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function send_app_mail(string $email, string $fullname, string $subject, string $htmlBody): array
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = env_value('SMTP_HOST', '');
        $mail->SMTPAuth = true;
        $mail->Username = env_value('SMTP_USERNAME', '');
        $mail->Password = env_value('SMTP_PASSWORD', '');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) env_value('SMTP_PORT', '587');

        $fromEmail = env_value('SMTP_FROM_EMAIL', env_value('SMTP_USERNAME', ''));
        $fromName = env_value('SMTP_FROM_NAME', 'Pinatextech Network');

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($email, $fullname);
        $mail->addReplyTo($fromEmail, $fromName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = strip_tags($htmlBody);
        $mail->send();

        return ['status' => 'success', 'message' => 'Mail sent to recipient'];
    } catch (Exception $exception) {
        return ['status' => 'failed', 'message' => $exception->getMessage()];
    }
}

function forgot_password_mail_body(string $fullname, string $token): string
{
    $resetUrl = app_frontend_url() . '/reset-password?tkn=' . urlencode($token);

    return "
        <body style='font-family: Nunito, Arial, sans-serif; font-size: 15px;'>
            <table cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 50px auto; background-color: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);'>
                <thead>
                    <tr style='text-align: center;'>
                        <th style='padding: 24px;'><img src='https://pinatexlogs.com/mailer/young.png' width='150' alt='Pinatexlogs'></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style='padding: 16px 24px; font-size: 18px; font-weight: 600;'>Hello, " . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') . "</td></tr>
                    <tr><td style='padding: 16px 24px;'>To reset your password, please click the button below:</td></tr>
                    <tr><td style='padding: 16px 24px; text-align: center;'><a href='$resetUrl' style='display: inline-block; background: #00bf63; color: #fff; padding: 12px 22px; border-radius: 8px; text-decoration: none;'>Reset Password</a></td></tr>
                    <tr><td style='padding: 16px 24px;'>If you did not request to reset your password, please ignore this email and your account will not be affected.</td></tr>
                    <tr><td style='padding: 16px 24px;'>Pinatexlogs Support Team</td></tr>
                </tbody>
            </table>
        </body>
    ";
}

function welcome_mail_body(string $fullname): string
{
    return "
        <body style='font-family: Nunito, Arial, sans-serif; font-size: 15px;'>
            <table cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 50px auto; background-color: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);'>
                <thead><tr><th style='padding: 24px;'><img src='https://pinatexlogs.com/mailer/young.png' width='150' alt='Pinatexlogs'></th></tr></thead>
                <tbody>
                    <tr><td style='padding: 16px 24px; font-weight: 600;'>Welcome Onboard " . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') . "</td></tr>
                    <tr><td style='padding: 16px 24px;'>We are elated to become part of your journey. Our support team is one click away should you need any help.</td></tr>
                    <tr><td style='padding: 16px 24px;'>Thank you for choosing Pinatexlogs.</td></tr>
                </tbody>
            </table>
        </body>
    ";
}
