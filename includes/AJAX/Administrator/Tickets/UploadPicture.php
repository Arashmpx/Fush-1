<?php
session_start();
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$ticket_id = $Sec->input($_POST['ticketid']);
$text = $Sec->input($_POST['text']);
$current_user_id = get_current_user_id();
$date = time();
if(!empty($ticket_id) && !empty($text) && !empty($current_user_id)){
    
    
    global $wpdb;
  $query = $wpdb->prepare("SELECT vt_uid FROM Shahkar_tickets WHERE vt_id = $ticket_id");
            $results = $wpdb->query($query);
         $data = $wpdb->get_results($query, OBJECT);
        $sender_id = $data[0]->vt_uid;

$table_name = 'Shahkar_tickets_reply'; 

$data = array(
    'vtr_uid' => $current_user_id,       
    'vtr_message' => $text,   
    'vtr_time' => $date,      
    'vtr_msg_type' => 'admin_picture',      
    'vtr_ticket_id' => $ticket_id   
);

$wpdb->insert($table_name, $data);

if ($wpdb->insert_id) {
  $tickets = new TicketReplyHandler();
  $tickets->updateStatus(1);
  
  if(get_option('shahkar_sms_notification_ticket_response_to_user')=="on"){
   $sms = new sms();
  $sms->reply_ticket_to_user($current_user_id,$sender_id);
  }
  
  if(get_option('shahkar_email_notification_ticket_response_to_user')=="on"){
   $mail = new shahkarmail();
  $mail->reply_ticket_to_user($current_user_id,$sender_id," اطلاع رسانی ثبت تیکت جدید "," یک تیکت جدید در وب سایت شما ثبت شده است "); 
  }

    $response = 'درخواست شما با موفقیت ثبت شد';
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