<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$title = $Sec->input($_POST['title']);
$text = $_POST['text'];
$link = $_POST['link'];
$shortcode = $_POST['shortcode'];
$type = $_POST['selectedContentType'];
$allowed_keys = array('title', 'another_field', 'yet_another_field');
$shahkar_option = new shahkarOption();
if(!empty($title) && !empty($type)){
  if($shahkar_option->createMenu($title,$type,$link,$shortcode,$text)){
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
echo json_encode(["status"=>$status,"response"=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
