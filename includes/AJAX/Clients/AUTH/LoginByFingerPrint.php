<?php

include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS();
$full_shahkar_dashurl = get_site_url() . "/" . get_option('shahkar_indexpage_url');

$user_id = $Sec->input($_POST['ShahkarUID']);
$secToken = $Sec->input($_POST['ShahkarFingerPrintSecurityToken']);
$DBSecToken = get_user_meta($user_id,'ShahkarFingerPrintSecurityToken', true);
if($secToken===$DBSecToken){
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        $color = 'linear-gradient(to right, #00b09b, #96c93d)';
        $status = "success";
        $response = ShahkarGetTranslateText('ShahkarSuccessfullyLoginResponse');
        $redirect = 1;
        }else{
        $status = "error";
         $color = 'error';
        $response = ShahkarGetTranslateText('ShahkarIncorrectLoginInfoResponse');
        $redirect = 0;   
        }
        
        
       $nextpanel =  $full_shahkar_dashurl . '/?p=home';
echo json_encode(["color" => $color,"status" => $status, 'response' => $response, 'redirect' => $redirect, 'next' => $nextpanel]);


 ?>