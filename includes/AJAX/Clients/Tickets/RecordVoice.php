<?php

include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$getupload_dir = wp_upload_dir();
$uploadDir = $getupload_dir['basedir'] . '/Shahkar/Voice';
if (!file_exists($uploadDir) || !is_dir($uploadDir)) {
            wp_mkdir_p($uploadDir);
        }
$current_user_id = get_current_user_id();
$allowedExtensions = ['mp3']; 
$ticket_id = $_POST['ticket_id'];
$date = time();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audioFile'])) {
    $uploadedFile = $_FILES['audioFile'];

    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {

      $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $uploadedFile['tmp_name']);
        finfo_close($fileInfo);

        $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

        $uniqueFileName = uniqid('audio_') . '.' . $fileExtension;

        $destination = $uploadDir . '/' . $uniqueFileName;
        if (move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
            global $wpdb;

$table_name = 'Shahkar_tickets_reply'; 

$data = array(
    'vtr_uid' => $current_user_id,       
    'vtr_message' => $uniqueFileName,   
    'vtr_time' => $date,      
    'vtr_ticket_id' => $ticket_id,
    'vtr_msg_type' => 'Voice'   
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
          
        } else {
          
            echo ShahkarGetTranslateText('ShahkarServerErrorResponse');
        }
    } else {
        echo ShahkarGetTranslateText('ShahkarUploadErrorTitleResponse');
        switch ($uploadedFile['error']) {
            case UPLOAD_ERR_INI_SIZE:
                echo ShahkarGetTranslateText('ShahkarUploadErrorMaxSizeResponse');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo ShahkarGetTranslateText('ShahkarUploadErrorMaxSizeResponse');
                break;
            case UPLOAD_ERR_PARTIAL:
                echo ShahkarGetTranslateText('ShahkarUploadErrorImperfectResponse');
                break;
            case UPLOAD_ERR_NO_FILE:
                echo ShahkarGetTranslateText('ShahkarUploadErrorNoFileResponse');
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo ShahkarGetTranslateText('ShahkarUploadErrorTemporaryResponse');
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo ShahkarGetTranslateText('ShahkarUploadErrorFailResponse');
                break;
            case UPLOAD_ERR_EXTENSION:
                echo ShahkarGetTranslateText('ShahkarUploadErrorExtensionResponse');
                break;
            default:
                echo ShahkarGetTranslateText('ShahkarUploadErrorFailResponse');
                break;
        }
    }
} else {
    echo ShahkarGetTranslateText('ShahkarUploadErrorFailResponse');
}
?>