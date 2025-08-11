<?php

include "../../../../../../../wp-load.php";

$Sec = new secure();
$Sec->DDOS(true);
  session_start();
$email = $Sec->input($_POST['new_email_address']);
$otpcode = $Sec->input($_POST['otpcode']);
$Validator = new Validator();
$userid = get_current_user_id();

if(empty($otpcode)){
if($Validator->checkEmail($email)){
  if(!email_exists($email)){
  if (get_option('shahkar_required_auth') == "on") {
$ShahkarMail = new ShahkarMail();
$_SESSION['VerifyCode'] = $code = rand(11111,99999);
$_SESSION['NewEmail'] = $email;
$ShahkarMail->verifycode(' کد تایید عضویت ', ' کد احراز هویت جهت تغییر ایمیل در پروفایل    : '.$code.' ', $_SESSION['NewEmail']);
  $color = 'linear-gradient(to right, #00b09b, #96c93d)';
  $response = ShahkarGetTranslateText('ShahkarSendOtpCodeResponse');
  $next = 1;
  }else {
    
      		$User = new user();
        	$User->UpdateUserEmail($userid,$email);
            $color = 'linear-gradient(to right, #00b09b, #96c93d)';
            $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateEmailResponse');
            $redirect = 1;
        }
  }else{
        $color = 'linear-gradient(to right, #ff5f6d, #ffc371)';
            $response = ShahkarGetTranslateText('TheEmailAddressEnteredIsDuplicate');
            $redirect = 0;  
      }
}else{
  $color = 'linear-gradient(to right, #ff5f6d, #ffc371)';
  $response = ShahkarGetTranslateText('ShahkarInvalidEmailFormatResponse');
  $next = 0;
}
  // Verify Code Proccess
}else{
  if($otpcode==$_SESSION['VerifyCode']){
    $User = new user();
        	$User->UpdateUserEmail($userid,$email);
  $color = 'linear-gradient(to right, #00b09b, #96c93d)';
  $response = ShahkarGetTranslateText('ShahkarSuccessfulAuthenticationResponse');
  $redirect = 1;
  }else{
   $color = 'linear-gradient(to right, #ff5f6d, #ffc371)';
  $response = ShahkarGetTranslateText('ShahkarIncorrectCodeResponse');
  $next = 0; 
  }
}

  echo json_encode(["color"=>$color,'response'=>$response,'next'=>$next,'redirect'=>$redirect]);

?>