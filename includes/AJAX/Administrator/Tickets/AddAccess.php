<?php
session_start();
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$SelectedAdmin = $Sec->input($_POST['SelectedAdmin']);
$SelectedDeparteman = $Sec->input($_POST['SelectedDeparteman']);
if(!empty($SelectedAdmin) && !empty($SelectedDeparteman)){
$table_name = 'Shahkar_departments_admin_access'; 

$data = array(
    'da_AdminID' => $SelectedAdmin,      
    'da_DepID' => $SelectedDeparteman 
);

if ($wpdb->insert($table_name, $data)) {
    $response = ' دسترسی با موفقیت اعطا شد ';
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

echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"color"=>$color]);

?>