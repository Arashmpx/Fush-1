<?php
session_start();
include "../../../../../../../wp-load.php";

$Sec = new secure();
$Sec->DDOS();

$username = $Sec->input($_POST['username']);
$password = $_POST['password'];


if(username_exists($username)){
  $_SESSION['username'] = $username;
  $Step = "LoginPasswordStep";
  $text = "Login";
}else{
 $_SESSION['username'] = $username;
 $Step = "RegisterPasswordStep";
 $text = "register"; 
}
  

echo json_encode(["status"=>$status,"text"=>$text,"NextStep"=>$Step,'url'=>$url]);


?>
