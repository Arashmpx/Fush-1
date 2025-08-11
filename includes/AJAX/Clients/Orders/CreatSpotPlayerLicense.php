<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$OrdersClass = new orders();
$WcProductID = $Sec->input($_POST['ProductID']);
$current_user_id = get_current_user_id();
$user = new user();
if(!empty($user->Shahkar_getDisplayName($current_user_id))){
$username = $user->Shahkar_getDisplayName($current_user_id);
}else{
$username = $user->ShahkarGetUserLogin($current_user_id);
}
if(!empty($user->Shahkar_getNumber($current_user_id))){
$userNumber = $user->Shahkar_getNumber($current_user_id);
}else{
$userNumber = $user->ShahkarGetUserLogin($current_user_id);
}
$SpotLicenseKey_Key = 'Shahkar_SpotLicenseKey_'.$WcProductID;
$courseID = $OrdersClass->GetSpotPlayerCourseID($WcProductID);

if(!empty($WcProductID)){
if (wc_customer_bought_product($current_user_id, $current_user_id, $WcProductID)) {

if(empty(get_user_meta($current_user_id, $SpotLicenseKey_Key, true))){
$CourseID = $OrdersClass->GetSpotPlayerCourseID($WcProductID);
function filter($a): array {
	return array_filter($a, function ($v) { return !is_null($v); });
}

function request($u, $o = null) {
	$LicenseKey = get_option('shahkar_spotplayer_LicenseKey');
	curl_setopt_array($c = curl_init(), [
		CURLOPT_URL => $u,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST => $o ? 'POST' : 'GET',
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_FOLLOWLOCATION => false,
		CURLOPT_HTTPHEADER => ['$API: '.$LicenseKey, '$LEVEL: -1', 'content-type: application/json' ],
	]);
	if ($o) curl_setopt($c, CURLOPT_POSTFIELDS, json_encode(filter($o)));
	$json = json_decode(curl_exec($c), true);
	curl_close($c);
	if (is_array($json) && ($ex = @$json['ex'])) throw new Exception($ex['msg']);
	return $json;
}

function license($name, $courses, $watermarks, $test) {
	return request('https://panel.spotplayer.ir/license/edit/', [
		'test' => $test,
		'name' => $name,
		'course' => $courses,
		'watermark' => ['texts' => array_map(function ($w) { return ['text' => $w]; }, $watermarks)]
	]);
}

// ----------------------------------------------------------------------------

// $L['key']
// https://dl.spotplayer.ir/' . $L['url'];
try {
	$License = license($username, $courseID, [$userNumber], false);
	//echo 'ID: ' . ($LID = $L['_id']);
	//echo 'KEY: ' . $L['key'];
	//echo 'URL: https://dl.spotplayer.ir/' . $L['url'];
  
$Shahkar_SpotLicenseKey_Key = 'Shahkar_SpotLicenseKey_'.$WcProductID;
$Shahkar_SpotLicenseKey_Value = $License['key'];
update_user_meta($current_user_id, $Shahkar_SpotLicenseKey_Key, $Shahkar_SpotLicenseKey_Value);

$Shahkar_SpotLicenseURL_Key = 'Shahkar_SpotLicenseURL_'.$WcProductID;
$Shahkar_SpotLicenseURL_Value = 'https://dl.spotplayer.ir/' . $License['url'];
update_user_meta($current_user_id, $Shahkar_SpotLicenseURL_Key, $Shahkar_SpotLicenseURL_Value);
  $response = 'لایسنس با موفقیت ایجاد شد';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $status = true;
}
catch (Exception $e) {
     $response = $e->getMessage();
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false; 
	//echo(;
}

}else{
 $response = 'لایسنس این دوره قبلا برای شما ایجاد شده است';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false;   
}
 
}else{
 $response = 'خطا در ایجاد لایسنس';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false; 
}
  
}else{
 $response = 'خطا در ایجاد لایسنس';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false;  
}




echo json_encode(["status"=>$status,'response'=>$response,"color"=>$color]);

?>