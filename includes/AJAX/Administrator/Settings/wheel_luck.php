<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$title = $Sec->input($_POST['title']);
$type = $_POST['type'];
$value = $_POST['value'];
$WheelLuck = new WheelLuck();
if(!empty($title) && !empty($type)){
  if($WheelLuck->CreatItem($title,$type,$value)){
   $response = ' آیتم با موفقیت اضافه شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
  }else{
  $response = ' خطا ، دوباره تلاش کنید ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
  }
}else{
 $response = ' تکمیل تمام موارد الزامیست ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
}
$url = "/dashboard";
echo json_encode(["status"=>$status,"response"=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
