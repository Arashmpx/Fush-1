<?php
include "../../../../../../../wp-load.php";

$Sec = new secure();
$Sec->DDOS('admin');
$value = $_POST['items'];


    update_option('shahkar_menu_sorts',$value );

$response = ' ترتیب بندی با موفقیت بروزرسانی شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 0;
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
