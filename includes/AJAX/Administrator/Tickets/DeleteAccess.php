<?php
session_start();
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$SelectedAdmin = $Sec->input($_POST['SelectedAdmin']);
$SelectedDeparteman = $Sec->input($_POST['SelectedDeparteman']);
if(!empty($SelectedAdmin) && !empty($SelectedDeparteman)){


        $tableNameDelete = 'Shahkar_departments_admin_access';
        $sql = $wpdb->prepare("DELETE FROM $tableNameDelete WHERE da_AdminID = %d AND da_DepID =%d", $SelectedAdmin,$SelectedDeparteman);
    


if ($wpdb->query($sql)) {
    $response = ' دسترسی با موفقیت حذف شد ';
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