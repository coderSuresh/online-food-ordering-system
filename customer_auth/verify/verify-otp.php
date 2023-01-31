<?php
    session_start();
     include("../../config.php");
     if(isset($_POST['verify'])){
                        $otp = mysqli_real_escape_string($conn,$_POST['otp']); 
                        $user = $_SESSION['username'];                        

                        $sql_otp = "select otp from customer where username = '$user'" ;
                        $res_otp = mysqli_query($conn, $sql_otp) or die("Error");
                        
                        $data  = mysqli_fetch_array($res_otp);
                        if(mysqli_num_rows($res_otp) > 0){
                         if ($otp === $data['otp']){
                            $sql_update = "update customer set status = 'verified' where username = '$user'";
                            $res_update = mysqli_query($conn, $sql_update) or die("Error");
                            if($res_update){
                                $_SESSION['verification'] = "sucessful";
                                header("Location:../login.php");
                            }
                         }
                            else{                            
                                $sql_count  = "Select count from customer where username = '$user'";
                                $res =  mysqli_query($conn,$sql_count ) or die("could not fetch count");
                                $data = mysqli_fetch_array($res);
                                $count = $data['count'];
                                $count += 1;
                            
                                $sql = "update customer set count = $count where username = '$user'";
                                mysqli_query($conn, $sql) or die("could not update count");
                                $_SESSION["otp-count"] = 3 - $count . " attempt left" ;       
                                
                                header("Location:./verify.php");                        
                                if($data['count'] >=2 ){        
                                    $sql = "delete from customer where username = '$user'";
                                    mysqli_query($conn, $sql) or die("could not delete user");                            
                                    $_SESSION["otp-failed"] ="OTP verification failed register again";
                                    header("Location:../register.php");                                                                      }
                                }                             
                               
                        }
                        
}
 else {
    header("Location:../login.php");
}
?>