<?php
include "../../../../../../../wp-load.php";
   $sec = new secure();
$text = $_POST['text'];
$title = $sec->input($_POST['title']);
$ForUID = $sec->input($_POST['ForUID']);
if(empty($_POST['ForUID'])){
  $ForUID = NULL;
}

$SendByStates = $sec->input($_POST['SendByStates']);
$SendByGender = $sec->input($_POST['SendByGender']);

$current_user_id = get_current_user_id();
$date = time();
if(!empty($title) && !empty($text) && !empty($current_user_id)){
    
    
    global $wpdb;

$table_name = 'Shahkar_notifications'; 

$data = array(
    'vn_title' => $title,       
    'vn_text' => $text,  
    'vn_state' => $SendByStates,  
    'vn_gender' => $SendByGender,  
    'vn_date' => $date,
    'vn_UID' => $ForUID  
);

$wpdb->insert($table_name, $data);

if ($wpdb->insert_id) {
	$response = ' اعلان با موفقیت ارسال شد ';
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



$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>