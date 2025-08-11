<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$MenuId = $Sec->input($_POST['menuid']);
$allowed_keys = array('title', 'another_field', 'yet_another_field');
$shahkar_option = new shahkarOption();
if(!empty($MenuId)){
  if($shahkar_option->deleteMenu($MenuId)){
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
