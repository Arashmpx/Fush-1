<?php
session_start();

require_once('../../../../../../../wp-load.php');
$Sec = new secure();
$Sec->DDOS();
$username = $_POST['username'];
$otpcode = $_POST['OtpCode'];
$ServerCode = $_SESSION['verify_code'];
$error_notif = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
$success_notif = 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))';

		if($ServerCode==$otpcode){
           echo json_encode(["text"=>ShahkarGetTranslateText('ShahkarCorrectCodeResponse')]);
        }else{
          echo json_encode(["text"=>ShahkarGetTranslateText('ShahkarIncorrectCodeResponse')]); 
        }


        
        
?>