<?php
include "../../../../../../../wp-load.php";
include WP_PLUGIN_DIR . "/Shahkar/includes/Class/Repair.php";
   $Sec = new secure();
$Sec->DDOS('admin');
$page_slug = get_option('shahkar_indexpage_url');
if(empty($page_slug)){
    $page_slug = "panel";
}else{
    $page = get_page_by_path($page_slug);
if ($page) {
    $result = wp_delete_post($page->ID, true);
 
}
}




    
$Repair = new ShahkarRepair();
$newpageid = $Repair->RepairPanlePage($page_slug);
$new_page_slug = get_post_field('post_name', $newpageid);
if(!empty($new_page_slug)){
    update_option('shahkar_indexpage_url', $new_page_slug);
    update_option('shahkar_indexpage_id', $newpageid);
    
  $response = ' برگه با آدرس ' . $new_page_slug . ' بازسازی شد ';
    $color = "linear-gradient(to right, #00b09b, #96c93d)";
    $redirect = 0;
      $ProExit = true;
}
    if ($user_data) {
        $response = ' اطلاعات کاربری یافت نشد ';
    $color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    $redirect = 0;
      $ProExit = true;
    }


    
    
    


echo json_encode(["status"=>$status,'response'=>$response,"redirect"=>$redirect,"url"=>$url,"color"=>$color]);


?>