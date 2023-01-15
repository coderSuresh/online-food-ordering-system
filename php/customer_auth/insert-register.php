<?php
include('../../config.php');
session_start();
if (isset($_POST['register'])){
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password =  md5(mysqli_real_escape_string($conn,$_POST['password']));
        $confirmpassword = md5(mysqli_real_escape_string($conn,$_POST['confirm_password']));

    if(!preg_match("/^[A-Z a-z]{2,30}$/", $name))
    {
         $_SESSION["invalid_name"] = "Name sould contain alphabaet only";
         header("Location:./register.php");
    } 
    
    else if(!preg_match("/^[0-9A-Za-z_-]{2,30}$/", $username))
    {
        $_SESSION["invalid_username"] = "Username shouldn't contain special characters";
         header("Location:./register.php");
    }

    else if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
            $_SESSION["invalid_email"] = "invalid_email";                 
    
    }
    else if(!preg_match("/^[0-9A-Z a-z,!@#$%^&*()_+]{8,50}$/", $password)){
        $_SESSION["invlaid_password"] = "password should contain minimum 8 characters";
        header("Location:./register.php");
    }

    else if($password != $confirmpassword){
            $_SESSION["password_not_match"] = "Password doesn't match";
            header("Location:./register.php");
    }

    else {
        $sql_username = "SELECT username FROM customer WHERE username='$username'";
        $res_username = mysqli_query($conn,$sql_username) or die("Error");

        $sql_email = "SELECT email FROM customer WHERE email='$email'";
        $res_email = mysqli_query($conn,$sql_email) or die("Error");
     
        if(mysqli_num_rows($res_name) > 0){
            $_SESSION['name_already_exit'] = "name already exist";
            header("Location:./register.php");
        }
        else if(mysqli_num_rows($res_username) > 0){            
            $_SESSION["username_already_exit"] = "username already exist";
            header("Location:./register.php");            
        }
        else if(mysqli_num_rows($res_email) > 0){        
            $_SESSION["email_already_exit"] = "email already exist";
            header("Location:./register.php");
            }
        
        else{            
            $sql = "Insert into customer values (default,'$name','$username','$email', '$password')";
            $res = mysqli_query($conn,$sql) or die("Error");
            if($res){
                $_SESSION['register-insert'] = "Inserted succesfully";
                header("Location:./register.php");
                if(!$res){
                    echo "error";
                }
            }
        }   
    }    
}
 
else{
        header("Location:./register.php");
}
?>
      

