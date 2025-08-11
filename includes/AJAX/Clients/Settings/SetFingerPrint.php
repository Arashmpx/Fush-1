<?php
include "../../../../../../../wp-load.php";





$user_id = get_current_user_id();
$ShahkarFingerPrintSecurityToken = sanitize_text_field($_POST['ShahkarFingerPrintSecurityToken']);


if(update_user_meta($user_id, 'ShahkarFingerPrintSecurityToken',$ShahkarFingerPrintSecurityToken)){
    $color = 'linear-gradient(to right, #00b09b, #96c93d)';
$response = ShahkarGetTranslateText('ShahkarPopupSuccessPaymentStatusTitle');
$redirect = 0;
}else{
    $color = 'red';
$response = ShahkarGetTranslateText('ShahkarPopupFailPaymentStatusTitle');
$redirect = 0;
}
echo json_encode(["color" => $color, 'response' => $response, 'redirect' => $redirect]);


?>
