<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);

if(get_option('shahkar_enable_remove_message_in_ticket')=="on"){



$Messageid = $Sec->input($_POST['MessageID']);
$TicketRemoveHandler = new TicketRemoveHandler();
if(!empty($Messageid)){
  if($TicketRemoveHandler->Remove($Messageid)){
   $response = ShahkarGetTranslateText('ShahkarSuccessfullyDeletedResponse');
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $status = true;
  }else{
  $response = ShahkarGetTranslateText('ShahkarServerErrorResponse');
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false;
  }
}else{
 echo "Takmil"; 
}

}else{
    $response = ShahkarGetTranslateText('ShahkarServerErrorResponse');
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false;
}
$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"color"=>$color]);

?>
