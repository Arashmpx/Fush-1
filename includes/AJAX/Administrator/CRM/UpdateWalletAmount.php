<?php
include "../../../../../../../wp-load.php";
include WP_PLUGIN_DIR . "/Shahkar/includes/Class/CRM.php";
   $Sec = new secure();
$Sec->DDOS('admin');
$NewAmount = $_POST['NewAmount'];
$ForUID = $Sec->input($_POST['ForUID']);
$current_user_id = get_current_user_id();
$date = time();
if(!empty($ForUID) && !empty($NewAmount)){
  $ShahkarCrm = new ShahkarCrm();
if ($ShahkarCrm->UpdateWalletAmount($ForUID,$NewAmount)) {
	$response = ' اعتبار کیف پول با موفقیت تغییر کرد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
} else {
    $response = ' خطا ، دوباره تلاش کنید ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
}
    
}else{
  $response = 'تکمیل تمام موارد الزامی است';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;  
}



$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>