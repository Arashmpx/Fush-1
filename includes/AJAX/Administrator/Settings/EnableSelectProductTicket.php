<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS('admin');

$DepID = $Sec->input($_POST['DepID']);


    global $wpdb;

    $table_name = 'Shahkar_support_departments';
    $column_name = 'vd_product';

    $current_status = $wpdb->get_var( $wpdb->prepare(
        "SELECT $column_name FROM $table_name WHERE vd_id = %d",
        $DepID
    ));
    if ( $current_status!='on' ) {
if(get_option('shahkar_enable_select_product_in_open_ticket')!='on'){
    
$response = ' ابتدا از تب سایر تنظیمات انتخاب محصول را فعال کنید ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);


exit();
    
}
    }

    $new_status = ( $current_status === 'on' ) ? NULL : 'on';

    $updated = $wpdb->update(
        $table_name,
        array( $column_name => $new_status ),
        array( 'vd_id' => $DepID ),
        array( '%s' ), 
        array( '%d' )  
    );

    $ChangeStatus = ( $updated !== false );





if ( $current_status=='on' ) {
    $response = ' انتخاب محصول غیرفعال شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
} else {
    $response = ' انتخاب محصول فعال شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 1;
}


$url = "/dashboard";
echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);

?>
