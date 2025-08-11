<?php
session_start();
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$NewDepartemanSelected = $Sec->input($_POST['NewDepartemanSelected']);
$TicketID = $Sec->input($_POST['ticketid']);
if(!empty($NewDepartemanSelected) && !empty($TicketID)){
            $table_name = 'Shahkar_tickets';

            $data = array(
                'vt_department' => $NewDepartemanSelected,
            );

            $where = array(
                'vt_id' => $TicketID,
            );
if ($wpdb->update($table_name, $data, $where)) {
    $response = ' تیکت شماره "  #' . $TicketID . ' " به  دپارتمان جدید منتقل شد ';
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

echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"color"=>$color]);

?>