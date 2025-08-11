<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$ItemId = $Sec->input($_POST['itemid']);
$WheelLuck = new WheelLuck();
if(!empty($ItemId)){
  if($WheelLuck->DeleteItem($ItemId)){
   $response = ' با موفقیت حذف شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
  }else{
  $response = ' خطا ، دوباره تلاش کنید ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
  }
}else{
 echo "Takmil"; 
}
$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
