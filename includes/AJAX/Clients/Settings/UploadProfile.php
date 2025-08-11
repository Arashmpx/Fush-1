<?php

include "../../../../../../../wp-load.php";

$Sec = new secure();
$Sec->DDOS(true);

$shahkar_dashurl = '/'.get_option('shahkar_indexpage_url');
session_start();
$current_user_id = get_current_user_id();
    $upload = new Upload();
    $response_data = $upload->handleFileUpload($_FILES['file'],"ProfilePicture/");
	$response_data_decode = json_decode($response_data);
	$response = $response_data_decode->response;
	$file = $response_data_decode->filename;
	$color = $response_data_decode->color;
	$redirect = $response_data_decode->redirect;
	$fileurl = site_url() . "/wp-content/uploads/Shahkar/ProfilePicture/" . $file . ".webp";
$date = time();

$user = new user();
$user->UpdateProfile($file);

echo json_encode(["color"=>$color,'response'=>$response,'redirect'=>$redirect,'file'=>$fileurl]);

?>