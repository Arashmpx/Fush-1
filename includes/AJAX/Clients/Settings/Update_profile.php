<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);

$states = $Sec->input($_POST['states']);
$city = $Sec->input($_POST['city']);
$address = $Sec->input($_POST['address']);
$postalcode = $Sec->input($_POST['postalcode']);
$displayname = $Sec->input($_POST['displayname']);
$gender = $Sec->input($_POST['gender']);
$nationalCode = $Sec->input($_POST['nationalCode']);
$gender = $Sec->input($_POST['gender']);
$birthday = $Sec->input($_POST['birthday_input']);
$UserPayeType = $Sec->input($_POST['UserPayeType']);
$fatherName = $Sec->input($_POST['fatherName']);
$isAtba = $Sec->input($_POST['isAtba']);
$currentUserId = get_current_user_id();


$allowed_keys = $wpdb->get_col("SELECT vcf_name FROM ShahkarCustomField");


    $user = new User();

    $user_data = array(
        'ID'           => $currentUserId,
        'display_name' => $displayname,
        'first_name'=>$displayname
    );

    wp_update_user($user_data);

    if ($user->ShahkarUpdateProfile($currentUserId, $states, $city, $address, $postalcode)) {
  		update_user_meta($currentUserId, 'Shahkar_info_gender', $gender);
  		update_user_meta($currentUserId, 'Shahkar_info_userPayeType', $UserPayeType);
  		update_user_meta($currentUserId, 'Shahkar_info_fatherName', $fatherName);
  		update_user_meta($currentUserId, 'Shahkar_info_birthDate', $birthday);
  		update_user_meta($currentUserId, 'Shahkar_info_nationalCode', $nationalCode);
  		update_user_meta($currentUserId, 'Shahkar_info_isAtba', $isAtba);
      foreach ($_POST as $key => $value) {

          if (in_array($key, $allowed_keys)) {
  		update_user_meta($currentUserId, $key, $value);
          }
      }
      
        $response = ShahkarGetTranslateText('ShahkarSuccessfullyUpdateUserProfileResponse');
        $color = "linear-gradient(to right, #00b09b, #96c93d)";
        $redirect = 1;
    } else {
        $response = ShahkarGetTranslateText('ShahkarServerErrorResponse');
        $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
        $redirect = 0;
    }


$url = "/dashboard";
echo json_encode(["status" => $status, 'response' => $response, "redirect" => $redirect, "url" => $url, "color" => $color]);

?>