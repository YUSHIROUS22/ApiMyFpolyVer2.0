<?php

// http://localhost/foodserver/mail/sendmail.php

include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/Exception.php";
include "PHPMailer/src/OAuthTokenProvider.php";
include "PHPMailer/src/OAuth.php";
include "PHPMailer/src/POP3.php";
include "PHPMailer/src/SMTP.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
    
        //Server settings
        $mail->SMTPDebug = 0;                                 // Bật thông báo lỗi nếu như bị sai cấu hình
        $mail->isSMTP();                                      // Sử dụng SMTP để gửi mail
        $mail->Host = 'smtp.gmail.com';                   // Server SMTP của mình
        $mail->SMTPAuth = true;                               // Bật xác thực SMTP
        $mail->Username = 'vinh2000thanh@gmail.com';                 // Tài khoản email
        $mail->Password = 'vnczkfhwkvssrivv';                           // Mật khẩu email
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
    
        //Recipients
        $mail->setFrom('vinh2000thanh@gmail.com', 'Vapng');           // Địa chỉ email và tên người gửi
        $mail->addAddress($email, 'Vinh Nguyen');     // Địa chỉ người nhận
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Mail veryfication';                                                 // Tiêu đề
        $mail->Body    = "Your otp is $otp"; // Nội dung
    
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
