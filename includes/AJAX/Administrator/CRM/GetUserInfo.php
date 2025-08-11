<?php
include "../../../../../../../wp-load.php";
//include WP_PLUGIN_DIR . "/Shahkar/includes/Class/CRM.php";
   $Sec = new secure();
$Sec->DDOS('admin');
$ForUID = $Sec->input($_POST['ForUID']);
$current_user_id = get_current_user_id();
$ShahkarUserClass = new user();
// User Info
if(get_user_meta($ForUID, 'Shahkar_Real_info_gender', true)=="MALE"){ $RealGender = " آقا "; }elseif(get_user_meta($ForUID, 'Shahkar_Real_info_gender', true)=="FEMALE"){$RealGender = "خانم";};
if(get_user_meta($ForUID, 'Shahkar_Real_info_userPayeType', true)=="1"){ $RealuserPayeType = " حقیقی "; }elseif(get_user_meta($ForUID, 'Shahkar_Real_info_userPayeType', true)=="2"){$RealuserPayeType = "حقوقی";};

$RealName = get_user_meta($ForUID, 'Shahkar_Real_info_name', true);
$RealFamily = get_user_meta($ForUID, 'Shahkar_Real_info_family', true);
$RealmobileNumber = get_user_meta($ForUID, 'Shahkar_Real_info_mobileNumber', true);
$RealnationalCode = get_user_meta($ForUID, 'Shahkar_Real_info_nationalCode', true);
$RealfatherName = get_user_meta($ForUID, 'Shahkar_Real_info_fatherName', true);
$RealbirthDate = get_user_meta($ForUID, 'Shahkar_Real_info_birthDate', true);


if(get_user_meta($ForUID, 'Shahkar_info_gender', true)=="MALE"){ $Gender = " آقا "; }elseif(get_user_meta($ForUID, 'Shahkar_info_gender', true)=="FEMALE"){$Gender = "خانم";};
if(get_user_meta($ForUID, 'Shahkar_info_userPayeType', true)=="1"){ $userPayeType = " حقیقی "; }elseif(get_user_meta($ForUID, 'Shahkar_info_userPayeType', true)=="2"){$userPayeType = "حقوقی";};
if(get_user_meta($ForUID, 'Shahkar_info_isAtba', true)=="true"){ $IsAtba = " تبعه خارجی "; }elseif(get_user_meta($ForUID, 'Shahkar_info_isAtba', true)=="false"){$IsAtba = " ایرانی ";};

$nationalCode = get_user_meta($ForUID, 'Shahkar_info_nationalCode', true);
$fatherName = get_user_meta($ForUID, 'Shahkar_info_fatherName', true);
$birthDate = get_user_meta($ForUID, 'Shahkar_info_birthDate', true);
$Address1 = get_user_meta($ForUID, 'billing_address_1', true);
$Address2 = get_user_meta($ForUID, 'billing_address_2', true);
$UserEmail = $ShahkarUserClass->Shahkar_getEmail($ForUID);
$UserNumber = $ShahkarUserClass->Shahkar_getNumber($ForUID);
if (user_can($ForUID, 'administrator')) {
$UserType = " مدیر ";
}else{
$UserType = " کاربر ";
}
$UserAvatar = $ShahkarUserClass->getAvatar($ForUID);
$UserDisplayName = $ShahkarUserClass->Shahkar_getDisplayName($ForUID);


global $wpdb;

$query = $wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}usermeta
    WHERE meta_key LIKE %s AND user_id = %d",
    $wpdb->esc_like('Shahkar_Profile_') . '%',
    $ForUID
);

$results = $wpdb->get_results($query);

$user_custom_info = [];

foreach ($results as $result) {
    $user_custom_info[$result->meta_key] = $result->meta_value;
}


                      
                      
echo json_encode(["status"=>'success','IsAtba'=>$IsAtba,'MobileNumber'=>$UserNumber,'Address1'=>$Address1,'Address2'=>$Address2,'Email'=>$UserEmail,'Gender'=>$Gender,'userPayeType'=>$userPayeType,'nationalCode'=>$nationalCode,'fatherName'=>$fatherName,'birthDate'=>$birthDate,'UserDisplayName'=>$UserDisplayName,'UserAvatar'=>$UserAvatar,'UserType'=>$UserType,'RealName'=>$RealName,"RealFamily"=>$RealFamily,"RealGender"=>$RealGender,"RealmobileNumber"=>$RealmobileNumber,"RealuserPayeType"=>$RealuserPayeType,"RealnationalCode"=>$RealnationalCode,"RealfatherName"=>$RealfatherName,"RealbirthDate"=>$RealbirthDate,'CustomField'=>$user_custom_info]);

?>