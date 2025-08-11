<?php
$timer = time();
$timeRemaining = max(0, ceil(($timer + 60) - time()) / 60);
$minutes = floor($timeRemaining);
$seconds = ($timeRemaining - $minutes) * 60;


require_once('../../../../../../../wp-load.php');

session_start();
$Sec = new secure();
$Sec->DDOS();
$username = $_POST['username'];
$error_notif = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
$success_notif = 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))';

		$code = rand(11111, 99999);
        $_SESSION['verify_code'] = $code;
        $_SESSION['verify_username'] = $username;
$validator = new Validator();
if($validator->checkNumberOrEmail($username)){
  $verificationMethod = new sms();
  $verificationMethod->verifycode($code, $username);
  echo json_encode(["text"=>'sms']);
}else{
    $verificationMethod = new ShahkarMail();
  	$verificationMethod->verifycode(' کد تایید عضویت ', ' کد احراز هویت جهت تکمیل فرایند ثبت نام : '.$code.' ', $username);
  echo json_encode(["text"=>'email']);
}

        $_SESSION['registration_time'] = time();
        

?>
