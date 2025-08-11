<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$MenuItem = $Sec->input($_POST['MenuItem']);

    $option_name = "Shahkar_" . $MenuItem . "_DisplayStatus";
    
    $option_value = get_option($option_name);
    
    if ($option_value === 'No' || empty($option_value)) {
        update_option($option_name, 'Yes');
      $response = ' با موفقیت فعال شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
    } else {
        update_option($option_name, 'No');
      $response = ' با موفقیت غیرفعال شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
    }
$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
