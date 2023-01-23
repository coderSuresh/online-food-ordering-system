<?php
    session_start();
    include("../../../config.php");
    if(isset($_POST['verify'])){
                        $code = $_SESSION['code'];                    

                        $user_otp_code = mysqli_real_escape_string($conn,$_POST['otp']);                      
                                                
                         if ($code == $user_otp_code){
                                   
                                $_SESSION['verification'] = "sucessful";
                                header("Location:./new-password.php");
                            }
                        
                            else{
                                echo $code ;
                                echo $user_otp_code;
                                $_SESSION['verification'] = "failed";
                                echo "Error";
                            }
    }
                         
                 
    else {
        header("Location:../login.php");
    }

?>