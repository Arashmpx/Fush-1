<?php

include "../../../../../../../wp-load.php";

$Sec = new Secure();
$Sec->DDOS(true);
$user = new user();
if(!empty(get_option('shahkar_zohal_auth_token'))){
    $current_user_id = get_current_user_id();
$mobile = $user->Shahkar_getNumber($current_user_id);
$NCode = $Sec->input($_POST['n_code']);
$ApiKey = get_option('shahkar_zohal_auth_token');


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://service.zohal.io/api/v0/services/inquiry/shahkar',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'mobile=' . urlencode($mobile) . '&national_code=' . urlencode($NCode) . '&apiKey=' . $ApiKey,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer ' . $ApiKey,
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response, true); 

if ($data['response_body']['data']['matched']) {
    $user->Shahkar_setMatch($current_user_id, $NCode);
    $response = ShahkarGetTranslateText('ShahkarMatchNationalCodeResponse');
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $status = true;


}else{
    $response = ShahkarGetTranslateText('ShahkarNotMatchNationalCodeResponse');
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $status = false; 
}

echo json_encode(["status"=>$status,'response'=>$response,"color"=>$color]);



}
  
?>