<?php
session_start();

if (isset($_POST['reset_password'])){
        $input_email = $_POST['email'];
        $sql = "select email from customer where email = '$input_email'";
        $res = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($res);
        $username = $_SESSION['username'];
        
        if(mysqli_num_rows($res) > 0){
              $email = $data['email'];     

                //Load Composer's autoloader
                require '../../../vendor/autoload.php';

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
                    header("Location:../reset-verify.php");   
                    
                } catch (Exception $e) {
                    $_SESSION['email'] = "$e";
                }
            }
                     
        } else {
            header("Location:./login.php");
      }
    
?>