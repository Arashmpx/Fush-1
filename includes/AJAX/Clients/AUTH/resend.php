<?php
session_start();

require_once('../../../../../../../wp-load.php');

$Sec = new secure();
$Sec->DDOS();
$type = $Sec->input($_POST['type']);
$error_notif = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
$success_notif = 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))';

$currentTime = time();
$registrationTime = $_SESSION['registration_time'] ?? 0;

if ($currentTime - $registrationTime > 60) {
    $validator = new Validator();
    $username = $_SESSION['username'];
    $code = rand(11111, 99999);
    $_SESSION['verify_code'] = $code;
    $timer = $_SESSION['registration_time'] = time();
    $timeRemaining = max(0, ceil(($timer + 60) - $currentTime) / 60);

    $minutes = floor($timeRemaining);
    $seconds = ($timeRemaining - $minutes) * 60;
  
   if ($validator->checkNumberOrEmail($username)) {
        $sms = new sms();
        $sms->verifycode($code, $username);
    } elseif (!$validator->checkNumberOrEmail($username)) {
        $mail = new ShahkarMail();
     if($type=="NoRegister"){
      $_SESSION['NoRegister'] = true;
     }
        $mail->verifycode(' کد احراز هویت  ', ' کد احراز هویت برای شما ارسال شد :  Code : ' . $code, $username);
    }

    $response = ShahkarGetTranslateText('ShahkarSendOtpCodeResponse');

    $color = $success_notif;

    echo json_encode(["status"=>'success',"min" => (int)$minutes, "sec" => (int)$seconds, 'response' => $response, "color" => $color,"NextStep"=>"CheckOtpCode"]);
} else {
    $response = ShahkarGetTranslateText('ShahkarNotPossibleToSendCodeResponse');
    $color = $error_notif;
    echo json_encode(["status"=>'warning','response' => $response, "color" => $color]);
}


   

?>
