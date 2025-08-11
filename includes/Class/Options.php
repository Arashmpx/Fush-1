<?php
class ShahkarOption
{
    public static function createMenu($title, $type, $link = '', $shortcode, $text)
    {
        $pageId = 0;

        if ($type !== "link") {
            $pagecontent = ($type == "shortcode") ? $shortcode : $text;
            $pageTitle = $title;
            $pageTemplate = WP_PLUGIN_DIR . "/Shahkar/user_page/dashboard/ele.php";

            $pageData = [
                'post_title' => $pageTitle,
                'post_content' => $pagecontent,
                'post_status' => 'publish',
                'post_type' => 'page',
                'page_template' => $pageTemplate,
                'post_name' => sanitize_title($pageTitle),
            ];

            $pageId = wp_insert_post($pageData);
        }

        global $wpdb;
        $tableName = 'Shahkar_menu';
        $time = time();

        $data = [
            'vm_title' => $title,
            'vm_wppage_id' => $pageId,
            'vm_type' => $type,
            'vm_link' => $link,
            'vm_status' => 1,
        ];

        return $wpdb->insert($tableName, $data);
    }

    public static function deleteMenu($menuId)
    {
        global $wpdb;
        $tableName = 'Shahkar_menu';
        $sql = $wpdb->prepare("DELETE FROM $tableName WHERE vm_id = %d", $menuId);

        return $wpdb->query($sql);
    }

    public static function setIndexPageId($pageId)
    {
        update_option('shahkar_indexpage_id', $pageId);
    }

    public static function changeIndexPageUrl($url)
    {
        global $wpdb;
        $pageId = get_option('shahkar_indexpage_id');
        $newSlug = $url;
      
if (!$pageId) {
    $page_title = ' حساب کاربری '; 
    $page_template = WP_PLUGIN_DIR . "/Shahkar/modules/load-dashboard.php";
    $page_data = array(
        'post_title'   => $page_title,
        'post_content' => '', 
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'page_template' => $page_template,
        'post_name'    => sanitize_title($newSlug),  
    );

    $page_id = wp_insert_post($page_data); 
	$shahkarOption = new ShahkarOption();
  	$shahkarOption->setIndexPageId($page_id);
}else{
      

        $wpdb->update(
            $wpdb->posts,
            ['post_name' => $newSlug],
            ['ID' => $pageId],
            ['%s'],
            ['%d']
        );

        flush_rewrite_rules();
}
    }

    public static function deleteDepartment($depId)
    {
        global $wpdb;
        $tableName = 'Shahkar_support_departments';
        $sql = $wpdb->prepare("DELETE FROM $tableName WHERE vd_id = %d", $depId);

        return $wpdb->query($sql);
    }

    public static function createDepartment($title)
    {
        global $wpdb;
        $tableName = 'Shahkar_support_departments';
        $data = ['vd_title' => $title];

        return $wpdb->insert($tableName, $data);
    }
  
  static function CreatNewProfileField($title,$target){
    global $wpdb;
        $tableName = 'ShahkarCustomField';
    	$vcf_type = "Shahkar_Profile_".time();
        $data = ['vcf_title' => $title,'vcf_type' => $target,'vcf_name' => $vcf_type];

        return $wpdb->insert($tableName, $data);
  }
  
  static function DeleteProfileField($ItemID){
    global $wpdb;
        $tableName = 'ShahkarCustomField';
        $sql = $wpdb->prepare("DELETE FROM $tableName WHERE vcf_name = '$ItemID'");

        return $wpdb->query($sql);
    
  }
  
  
  

}
?>