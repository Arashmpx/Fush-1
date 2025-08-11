<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$title = $Sec->input($_POST['title']);
$target = $Sec->input($_POST['target']);
$shahkar_option = new shahkarOption();
if(!empty($title)){
  if($shahkar_option->CreatNewProfileField($title,$target)){
   $response = 'درخواست شما با موفقیت ثبت شد';
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
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
