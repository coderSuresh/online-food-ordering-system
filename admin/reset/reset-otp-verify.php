<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include("../../config.php");
if (isset($_POST['send_otp'])) {

    $input_email = mysqli_real_escape_string($conn, $_POST['email']);
    $sql_name = "select name from admin where email = '$input_email'";
    $res_name = mysqli_query($conn, $sql_name) or die("Error");
    $data_name = mysqli_fetch_array($res_name);

    if (mysqli_num_rows($res_name) > 0) {
        $code = rand(100000, 999999);
        $email = $input_email;
        $username = $data_name['names'];
        //Load Composer's autoloader
        require '../../vendor/autoload.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {

            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'testperpose56@gmail.com';                     //SMTP username
            $mail->Password   = 'difxmcqvovolbafy';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('testperpose56@gmail.com', 'Restro Hub');
            $mail->addAddress($email, $username);     //Add a recipient
            $mail->addReplyTo('testperpose56@gmail.com', 'Restro Hub');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Verification Code';
            $mail->Body    = "Your verification code is $code";
            $mail->AltBody = 'Your vrification code is $code';

            $mail->send();
            $_SESSION['code'] = $code;
            $_SESSION['email'] = $email;
            header("Location:./reset-verify.php");

            $sql = "update admin set otp = '$code' where email = '$email'";
            $res = mysqli_query($conn, $sql) or die("Error");

        } catch (Exception $e) {
            $_SESSION['error'] = "$e";
        }
    } else {
        $_SESSION['email_error'] = "Email not found";
        header("Location:./reset-password.php");
    }
} else {
    header("Location:./login.php");
}
