<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);

$ShahkarLatLng = $Sec->input($_POST['ShahkarLatLng']);
$Shahkar_address_title = $Sec->input($_POST['Shahkar_address_title']);
$Shahkar_states = $Sec->input($_POST['Shahkar_states']);
$Shahkar_address = $Sec->input($_POST['Shahkar_address']);
$Shahkar_address_city = $Sec->input($_POST['Shahkar_address_city']);
$Shahkar_Postal_Code = $Sec->input($_POST['Shahkar_Postal_Code']);
$currentUserId = get_current_user_id();
$user = new user();

if (!empty($ShahkarLatLng) && !empty($Shahkar_address_title) && !empty($Shahkar_states) && !empty($Shahkar_address) && !empty($Shahkar_address_city) && !empty($Shahkar_Postal_Code)  && !empty($currentUserId)) {
    
if(empty(get_user_meta($currentUserId, 'billing_address_1_title', true))){
  update_user_meta($currentUserId, 'billing_address_1', $Shahkar_address);
  update_user_meta($currentUserId, 'billing_address_1_title', $Shahkar_address_title);
  update_user_meta($currentUserId, 'billing_address_1_LatLng', $ShahkarLatLng);
  update_user_meta($currentUserId, 'billing_address_1_states', $Shahkar_states);
  update_user_meta($currentUserId, 'billing_address_1_city', $Shahkar_address_city);
  update_user_meta($currentUserId, 'billing_address_1_postalcode', $Shahkar_Postal_Code);
  $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateUserProfileResponse');
        $color = "linear-gradient(to right, #00b09b, #96c93d)";
        $redirect = 1;
}elseif(empty(get_user_meta($currentUserId, 'billing_address_2_title', true))){
  update_user_meta($currentUserId, 'billing_address_2', $Shahkar_address);
  update_user_meta($currentUserId, 'billing_address_2_title', $Shahkar_address_title);
  update_user_meta($currentUserId, 'billing_address_2_LatLng', $ShahkarLatLng);
  update_user_meta($currentUserId, 'billing_address_2_states', $Shahkar_states);
  update_user_meta($currentUserId, 'billing_address_2_city', $Shahkar_address_city);
  update_user_meta($currentUserId, 'billing_address_2_postalcode', $Shahkar_Postal_Code);
  
  $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateUserProfileResponse');
        $color = "linear-gradient(to right, #00b09b, #96c93d)";
        $redirect = 1;
}else{
  $response = ShahkarGetTranslateText('ShahkarLimitAddingAddressesResponse');
        $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
        $redirect = 0;
}

} else {
    $response = ShahkarGetTranslateText('AllItemsMustBeCompleted');
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
}

$url = "/dashboard";
echo json_encode(["status" => $status, 'response' => $response, "redirect" => $redirect, "url" => $url, "color" => $color]);

?>