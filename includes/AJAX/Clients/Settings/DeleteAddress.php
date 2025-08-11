<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);

$ShahkarAddressID = $Sec->input($_POST['Address']);
$currentUserId = get_current_user_id();
$user = new user();

if (!empty($ShahkarAddressID)  && !empty($currentUserId)) {
    
if(!empty(get_user_meta($currentUserId, 'billing_'.$ShahkarAddressID, true))){
  
  $field_name = "billing_" . $ShahkarAddressID;
  delete_user_meta($currentUserId, $field_name);
  $field_name = "billing_" . $ShahkarAddressID . "_title";
  delete_user_meta($currentUserId, $field_name);
  $field_name = "billing_" . $ShahkarAddressID . "_LatLng";
  delete_user_meta($currentUserId, $field_name);
  $field_name = "billing_" . $ShahkarAddressID . "_states";
  delete_user_meta($currentUserId, $field_name);
  $field_name = "billing_" . $ShahkarAddressID . "_city";
  delete_user_meta($currentUserId, $field_name);
  $field_name = "billing_" . $ShahkarAddressID . "_postalcode";
  if(delete_user_meta($currentUserId, $field_name)){
  
  $response = ShahkarGetTranslateText('ShahkarSuccessfullyDeleteSelectedAddressResponse');
        $color = "linear-gradient(to right, #00b09b, #96c93d)";
        $redirect = 1;
  }else{
  $response = ShahkarGetTranslateText('ShahkarServerErrorResponse');
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;  
  }
}else{
  $response = ShahkarGetTranslateText('ShahkarNotFoundAddressResponse');
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