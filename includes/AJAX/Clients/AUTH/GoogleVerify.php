<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS();
require WP_PLUGIN_DIR ."/Shahkar/includes/lib/vendor/autoload.php";

use Vectorface\GoogleAuthenticator;
$ga = new GoogleAuthenticator();
session_start();
$user = new user();
$userid = $Sec->input($_SESSION['usecret']);
$secret = $user->getGoogleSecret($userid);
$code = $Sec->input($_POST['input_code']);
$codeVerified = $ga->verifyCode($secret, $code, 1);


$error_notif = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
$success_notif = 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))';

if($codeVerified){
wp_set_current_user($userid);
            wp_set_auth_cookie($userid);
  $url = '/'.get_option('shahkar_indexpage_url').'/?p=home';
        $response = ShahkarGetTranslateText('ShahkarSuccessfullyLoginResponse');
      	$color = $success_notif;
    	$redirect = 1;

} else {
        $response = ShahkarGetTranslateText('ShahkarIncorrectGoogleCodeResponse');
      	$color = $error_notif;
    	$redirect = 0;
    }



echo json_encode(["status" => $status, 'response' => $response, "redirect" => $redirect, "url" => $url, "color" => $color]);
?>
