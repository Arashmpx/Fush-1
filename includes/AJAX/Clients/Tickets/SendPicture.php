<?php

include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$shahkar_dashurl = '/'.get_option('shahkar_indexpage_url');
session_start();
$current_user_id = get_current_user_id();
$ticket_id = $Sec->input($_SESSION['ticketid']);
    $upload = new Upload();
    $response_data = $upload->handleFileUpload($_FILES['file'],"TicketFile/");
	$response_data_decode = json_decode($response_data);
	$response = $response_data_decode->response;
	$file = $response_data_decode->filename;
	$color = $response_data_decode->color;
	$redirect = $response_data_decode->redirect;
	$ShahkarFtpStatus = $response_data_decode->FtpStatus;
if(empty($ShahkarFtpStatus)){
 $ShahkarFtpStatus = null; 
}
$date = time();
            global $wpdb;

$table_name = 'Shahkar_tickets_reply'; 

$data = array(
    'vtr_uid' => $current_user_id,      
    'vtr_message' => $file,  
    'vtr_time' => $date,      
    'vtr_ticket_id' => $ticket_id,  
    'vtr_msg_type' => 'picture'  ,
    'vtr_ftp' => $ShahkarFtpStatus
);
$wpdb->insert($table_name, $data);
if(get_option('shahkar_sms_notification_of_new_ticket_registration_to_admin')=="on"){
   $sms = new sms();
  $sms->new_ticket_to_admin($current_user_id); 
  }
  
  if(get_option('shahkar_email_notification_of_new_ticket_registration_to_admin')=="on"){
   $mail = new shahkarMail();
  $mail->new_ticket_to_admin($current_user_id," اطلاع رسانی ثبت تیکت جدید "," یک تیکت جدید در وب سایت شما ثبت شده است "); 
  }


echo json_encode(["color"=>$color,'response'=>$response,'redirect'=>$redirect]);

?>