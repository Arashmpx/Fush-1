<?php

require_once('../../../../../../../wp-load.php');
session_start();
$Sec = new secure();
$Sec->DDOS();


// Usage
$username = $Sec->input($_SESSION['username']) ?? '';
$password = $Sec->input($_POST['password']) ?? '';

if($Sec->IranAccess() && get_option('Shahkar_IranAccess') == "on"){
    $status = "warning";
    $response = ShahkarGetTranslateText('LoginisonlypossiblewithanIranianIP');
    $color = $error_notif;
    $redirect = 0; 
    echo json_encode(["status" => $status, 'response' => $response, "redirect" => $redirect, "url" => $url, "color" => $color]);

    exit();
}

$registrationHandler = new RegistrationHandler($username, $password);
$registrationHandler->handleRegistration();
?>
