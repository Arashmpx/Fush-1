<?php
include "../../../../../../../wp-load.php";
include WP_PLUGIN_DIR . "/Shahkar/includes/Class/CRM.php";
   $Sec = new secure();
$Sec->DDOS('admin');
$UID = $Sec->input($_POST['SuspendUID']);
$CRM = new ShahkarCrm();


$user_data = get_userdata($UID);
     $ProExit = false;
if(get_option('Shahkar_Check_Login_block_enable') !== "on"){
  $response = ' سیستم بلاک را از تنظیمات ورود  فعال کنید ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
      $ProExit = true;
}
    if (!$user_data) {
        $response = ' اطلاعات کاربری یافت نشد ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
      $ProExit = true;
    }
    
    if (in_array('administrator', $user_data->roles) && count($user_data->roles) === 1) {
       $response = ' نمی توانید مدیریت اصلی را مسدود کنید ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
      $ProExit = true;
    }
    if(!$ProExit){
       global $wpdb;
		
      if($user_data->user_status==1){
		  if($CRM->UnsuspendUser($UID)){
        $response = ' کاربر با موفقیت فعال شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 0;
			  }
      }elseif($user_data->user_status==0){
		  
       
      if ($CRM->suspendUser($UID)) {
		  
        $response = ' کاربر با موفقیت مسدود شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 0;
		  
    } 
		  
      }
	
      
    }
    
    
    


echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);


?>