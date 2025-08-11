<?php

include "../../../../../../../wp-load.php";

$Sec = new secure();
$Sec->DDOS(true);
session_start();
$number = $Sec->input($_POST['new_phone_number']);
$otpcode = $Sec->input($_POST['otpcode']);
$userid = get_current_user_id();
$Validator = new Validator();

if (empty($otpcode)) {
    if ($Validator->checkNumberOrEmail($number)) {
      if(!username_exists($number)){
        if (get_option('shahkar_required_auth') == "on") {
            $sms = new sms();
            $_SESSION['VerifyCode'] = $code = rand(11111, 99999);
            $_SESSION['NewNumber'] = $number;
            $sms->verifycode($code, $number);
            $color = 'linear-gradient(to right, #00b09b, #96c93d)';
            $response = ShahkarGetTranslateText('AuthenticationCodeSentSuccessfully');
            $next = 1;
        } else {
          	$User = new user();
          	$User->UpdateUserNumber($userid,$number);
            $color = 'linear-gradient(to right, #00b09b, #96c93d)';
            $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateMobileNumberResponse');
            $redirect = 1;
        }
      }else{
        $color = 'linear-gradient(to right, #ff5f6d, #ffc371)';
            $response = ShahkarGetTranslateText('ShahkarAlreadyRegisteredMobileNumberResponse');
            $redirect = 0;  
      }
    } else {
        $color = 'linear-gradient(to right, #ff5f6d, #ffc371)';
        $response = ShahkarGetTranslateText('ShahkarInvalidMobileNumberFormatResponse');
        $next = 0;
    }
} else {
    if ($otpcode == $_SESSION['VerifyCode']) {
      $color = 'linear-gradient(to right, #00b09b, #96c93d)';
        $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateMobileNumberResponse');
        $redirect = 1;
      	$User = new user();
        $User->UpdateUserNumber($userid,$number);
        
    } else {
        $color = 'linear-gradient(to right, #ff5f6d, #ffc371)';
        $response = ShahkarGetTranslateText('ShahkarIncorrectCodeResponse');
        $next = 0;
    }
}

echo json_encode(["color" => $color, 'response' => $response, 'next' => $next, 'redirect' => $redirect]);
?>
