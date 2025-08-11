<?php

session_start(); 
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS();
$username = $Sec->input($_SESSION['username']);

$error_notif = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
$success_notif = 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))';
$currentTime = time();
if (!empty($username)) {
    if (username_exists($username)) {
      	$_SESSION['reset_password'] = true;
        $validator = new Validator();
      $user_data = get_user_by('login', $username);
			$user_id = $user_data->ID;
          	$_SESSION['resetpassword_uid'] = $user_id; 
        if ($validator->checkNumberOrEmail($username)) {

            $code = rand(11111, 99999);
            $_SESSION['verify_code'] = $code;
            $_SESSION['verify_username'] = $username;
            $_SESSION['verify_type'] = "Number";

            $sms = new sms();
            $sms->verifycode($code, $username);
          
            $timer = $_SESSION['registration_time'] = time();
            $timeRemaining = max(0, ceil(($timer + 60) - $currentTime) / 60);

            $minutes = floor($timeRemaining);
            $seconds = ($timeRemaining - $minutes) * 60;
          
            $response = ShahkarGetTranslateText('ShahkarSendOtpCodeResponse');
            $color = $success_notif;
          	$status = 'success';
            $redirect = 1;
            $url = '/' . get_option('shahkar_indexpage_url') . '/?p=verify';

        } else {

            $code = rand(11111, 99999);
            $_SESSION['verify_code'] = $code;
            $_SESSION['verify_username'] = $username;
            $_SESSION['verify_type'] = "Email";

            $mail = new ShahkarMail();
            $mail->verifycode(' کد احراز هویت  ', ' کد احراز هویت برای تکمیل فرایند ثبت نام :  Code : ' . $code, $username);
            $timer = $_SESSION['registration_time'] = time();
            $timeRemaining = max(0, ceil(($timer + 60) - $currentTime) / 60);

            $minutes = floor($timeRemaining);
            $seconds = ($timeRemaining - $minutes) * 60;
          
            $response = ShahkarGetTranslateText('ShahkarSendOtpCodeResponse');
            $color = $success_notif;
          	$status= 'success';
            $redirect = 1;
            $url = '/' . get_option('shahkar_indexpage_url') . '/?p=verify';

        }
    }else{
        $response = ShahkarGetTranslateText('ShahkarUserNotFoundResponse');
        $color = $error_notif;
      	$status= 'warning';
        $redirect = 0;
    }
} else {
    $response = ShahkarGetTranslateText('AllItemsMustBeCompleted');
    $color = $error_notif;
  	$status= 'warning';
    $redirect = 0;
}

echo json_encode(["status" => $status, 'response' => $response, "redirect" => $redirect, "url" => $url, "color" => $color,"min" => (int)$minutes, "sec" => (int)$seconds]);



