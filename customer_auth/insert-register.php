<?php
session_start();
include('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $signin_provider = "email";

    if (!preg_match("/^[A-Z a-z]{2,30}$/", $name)) {
        $_SESSION["invalid_name"] = "Name sould contain alphabaet only";
        header("Location:./register.php");
    } else if (!preg_match("/^[0-9A-Za-z_-]{2,30}$/", $username)) {
        $_SESSION["invalid_username"] = "Username shouldn't contain special characters";
        header("Location:./register.php");
    } else if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $_SESSION["invalid_email"] = "invalid_email";
        header("Location:./register.php");
    } else if (!preg_match("/^[0-9A-Z a-z,!@#$%^&*()_+]{8,50}$/", $password)) {
        $_SESSION["invlaid_password"] = "password should contain minimum 8 characters";
        header("Location:./register.php");
    } else if ($password != $confirmpassword) {
        $_SESSION["password_not_match"] = "Password doesn't match";
        header("Location:./register.php");
    } else {
        $sql_username = "SELECT username FROM customer WHERE username='$username'";
        $res_username = mysqli_query($conn, $sql_username) or die("Error");

        $sql_email = "SELECT email FROM customer WHERE email='$email'";
        $res_email = mysqli_query($conn, $sql_email) or die("Error");        
       

        if (mysqli_num_rows($res_username) > 0) {
            $_SESSION["username_already_exit"] = "username already exist";
            header("Location:./register.php");
        } else if (mysqli_num_rows($res_email) > 0) {
            $_SESSION["email_already_exit"] = "email already exist";
            header("Location:./register.php");
        } else {
            
            $code = rand(999999, 111111);
            $sql_code = "select otp from customer where otp = $code";
            $res_code = mysqli_query($conn, $sql_code) or die("Error");

            if (mysqli_num_rows($res_code) > 0) {
                $code = rand(999999, 111111);
            }
            $password = md5($password);
            $status = "not verified";
            $sql = "Insert into customer values (default,'$name','$username','$email', '$password','$signin_provider',NULL,'$status','$code')";
            $res = mysqli_query($conn, $sql) or die("Error");
            if ($res) {
                $_SESSION['register-insert'] = "Inserted succesfully";
              
                //Load Composer's autoloader
                require '../vendor/autoload.php';

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
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
                    $mail->send();
                    
                    $_SESSION['username'] = $username;
                    header("Location:../customer_auth/verify/verify.php");   
                    
                } catch (Exception $e) {
                    $_SESSION['error'] = "$e";
                }
                      
            }        
        }
    }
} else {
    header("Location:./register.php");
}
?>