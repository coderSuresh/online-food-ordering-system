<?php
    session_start();
    include("../../config.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $user = $_SESSION["usr"];
    $code = rand(999999, 111111);
    $sql_code = "select otp name from customer where otp = $code";
    $res_code = mysqli_query($conn, $sql_code) or die("Error");

    $sql_code = "select email from customer where username = '$user'";
    $res_code = mysqli_query($conn, $sql_code) or die("Error");
    $row = mysqli_fetch_assoc($res_code);
    $email = $row['email'];

    if (mysqli_num_rows($res_code) > 0)
        {
            $code = rand(999999, 111111);
        }
        
        $sql_code_update = "Update customer set otp = $code";
        $res_code_update = mysqli_query($conn, $sql_code_update) or die("Error");
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
                    $mail->addAddress($email, $name);     //Add a recipient
                    $mail->addReplyTo('testperpose56@gmail.com', 'Restro Hub');
                   
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Email Verification Code';
                    $mail->Body    = "Your verification code is $code";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
                    $mail->send();                    
                    
                    header("Location:./verify.php");

                    
                } catch (Exception $e) {
                    $_SESSION['error'] = "$e";
            }
           
?>