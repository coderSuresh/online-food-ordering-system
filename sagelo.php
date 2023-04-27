<?php
require('./config.php');
$data = [
    "name"=>"paras",
    "username"=> "hero",
    "email"=>"parashbhandari99@gmail.com",
    "password"=>"asdfasdf",
    "date"=>"2023-04-27 01:00:00",
    "active" => 1,
    "otp" => 021232,
    "count" => 0,
    "provider" => "email",
    "status" => "verified"
];

for ($i=0; $i <200 ; $i++) { 
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];
    $date = $data['date'];
    $active = $data['active'];
    $otp = $data['otp'];
    $count = $data['count'];
    $provider = $data['provider'];
    $status = $data['status'];

  $customer = "Insert into customer values(DEFAULT,'$name','$username','$email','$password','$provider','$date','$status',$active,$otp,$count)";
  $customer = mysqli_query($conn,$customer) or die("error");
  if($customer){
        echo "success <br>";
    }

}
?>