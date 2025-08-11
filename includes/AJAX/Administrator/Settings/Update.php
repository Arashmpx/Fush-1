<?php
include "../../../../../../../wp-load.php";

$Sec = new secure();
$Sec->DDOS('admin');

$allowed_keys = array('title', 'another_field', 'yet_another_field');
$shahkar_option = new ShahkarOption();

foreach ($_POST as $key => $value) {


  if($key=="shahkar_indexpage_url"){
       $shahkar_option->changeIndexPageUrl($Sec->input($value)); 
      }
    update_option($key, $Sec->input($value));
}
$response = ' تنظیمات با موفقیت بروزرسانی شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 0;
$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
