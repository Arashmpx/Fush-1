<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);

$UserBDate = $Sec->input($_POST['UserBDate']);
$currentUserId = get_current_user_id();
$user = new user();

if (!empty($UserBDate) && !empty($currentUserId)) {
  update_user_meta($currentUserId, 'Shahkar_info_birthDate', $UserBDate);
  $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateDateOfBirthResponse');
        $color = "linear-gradient(to right, #00b09b, #96c93d)";
        $redirect = 1;

} else { 
    $response = ShahkarGetTranslateText('AllItemsMustBeCompleted');
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
}

$url = "/dashboard";
echo json_encode(["status" => $status, 'response' => $response, "redirect" => $redirect, "url" => $url, "color" => $color]);

?>