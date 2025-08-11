<?php
session_start();
include "../../../../../../../wp-load.php";

if(get_option('shahkar_wheel_of_luck_status') != "on"){
  echo json_encode(['status'=>'warning','response'=>ShahkarGetTranslateText('ShahkarDisableLuckyWheelResponse')]);
  exit();
}
$WheelLuck = new WheelLuck();



$user_id = get_current_user_id();
$max_chances = get_option('shahkar_Number_chances_in_day');

$current_time = strtotime(date("Y/m/d"));


$chances_used_in_day = $WheelLuck->chancesUsedInDay();
if ($chances_used_in_day >= $max_chances) {
  if($WheelLuck->CountSpinChance($user_id)<1){
  echo json_encode(['status'=>'warning','response'=>ShahkarGetTranslateText('ShahkarNotEnoughChancesResponse')]);
  exit();
  }else{
         
   $WheelLuck->SubtractSpinChance(); 
    $table_name = 'Shahkar_wheel_luck';
$results = $wpdb->get_results("SELECT wl_id FROM $table_name", ARRAY_A);
    $random_wl_id = $results[array_rand($results)]['wl_id'];

    $key = array_search($random_wl_id, array_column($results, 'wl_id'));

    
$sql_one = "SELECT * FROM Shahkar_wheel_luck WHERE wl_id='$random_wl_id'";

$results_one = $wpdb->query($sql_one);
$data_one = $wpdb->get_results($sql_one, OBJECT);
    $WinValue = $data_one[0]->wl_value;
    $Wintype = $data_one[0]->wl_type;
    if($Wintype=="wallet"){
      $WalletChargeHandler = new WalletChargeHandler();
      $WalletChargeHandler->increaseWalletBalance($WinValue,$user_id);
    }
   $WheelLuck->SaveLog($random_wl_id,'1',$WinValue,$Wintype);
    if (get_option('shahkar_sms_notification_after_win_in_wheel_luck') == "on") {
    $user = new user();
    $Wintitle = $data_one[0]->wl_title;
	$Unumber = $user->Shahkar_getNumber($user_id);
    $sms = new sms();
    $sms->NotifWin($Unumber,$Wintitle);
    }
    
    if (get_option('shahkar_email_notification_after_win_in_wheel_luck') == "on") {
    $Wintitle = $data_one[0]->wl_title;
    $Mail = new ShahkarMail();
    $Mail->NotifWinToUser($user_id,$Wintitle);
    }
    
    


echo json_encode(['SelectedSegmentID'=>$key+1]);
    exit();
  }
    echo json_encode(['status'=>'warning','response'=>ShahkarGetTranslateText('ShahkarNotEnoughChancesResponse')]);
  exit();
   
}


$table_name = 'Shahkar_wheel_luck';
$results = $wpdb->get_results("SELECT wl_id,wl_type FROM $table_name", ARRAY_A);

$random_wl_id = $results[array_rand($results)]['wl_id'];
$key = array_search($random_wl_id, array_column($results, 'wl_id'));

$sql_one = "SELECT * FROM Shahkar_wheel_luck WHERE wl_id='$random_wl_id'";

$results_one = $wpdb->query($sql_one);
$data_one = $wpdb->get_results($sql_one, OBJECT);
    $WinValue = $data_one[0]->wl_value;
$Wintype = $data_one[0]->wl_type;
if($Wintype=="wallet"){
      $WalletChargeHandler = new wallet();
      $WalletChargeHandler->increaseWalletBalance($WinValue,$user_id);
    }
$WheelLuck->SaveLog($random_wl_id,NULL,$WinValue,$Wintype);

if (get_option('shahkar_sms_notification_after_win_in_wheel_luck') == "on") {
    $user = new user();
    $Wintitle = $data_one[0]->wl_title;
	$Unumber = $user->Shahkar_getNumber($user_id);
    $sms = new sms();
    $sms->NotifWin($Unumber,$Wintitle);
    }

if (get_option('shahkar_email_notification_after_win_in_wheel_luck') == "on") {
    $Wintitle = $data_one[0]->wl_title;
    $Mail = new ShahkarMail();
    $Mail->NotifWinToUser($user_id,$Wintitle);
    }



echo json_encode(['SelectedSegmentID'=>(int)$key+1]);


