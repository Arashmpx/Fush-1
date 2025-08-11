<?php
class WheelLuck{
  
    public static function CountSpinChance($uid){
      global $wpdb;
        $query = $wpdb->prepare("SELECT vp_SpinChance FROM Shahkar_users_profile WHERE vp_uid = $uid");
        $data = $wpdb->get_results($query, OBJECT);

        return $data[0]->vp_SpinChance ?? 0;
    
  }
  public static function SubtractSpinChance(){
    $WheelLuck = new WheelLuck();
    $uid = get_current_user_id();
    $NewCountChance = $WheelLuck->CountSpinChance($uid)-1;
    global $wpdb;
        $tableName = 'Shahkar_users_profile';

        $data = [
            'vp_SpinChance' => $NewCountChance,
        ];

        $where = [
            'vp_uid' => $uid,
        ];

        $wpdb->update($tableName, $data, $where);
  }
  
  public static function IncreaseSpinChance(){
    $WheelLuck = new WheelLuck();
    $uid = get_current_user_id();
    $NewCountChance = $WheelLuck->CountSpinChance($uid)+intval(get_option('shahkar_Number_chances_after_wc_buying'));
    global $wpdb;
        $tableName = 'Shahkar_users_profile';

        $data = [
            'vp_SpinChance' => $NewCountChance,
        ];

        $where = [
            'vp_uid' => $uid,
        ];

        $wpdb->update($tableName, $data, $where);
  }

  public static function CustomIncreaseSpinChance($Count){
    $WheelLuck = new WheelLuck();
    $uid = get_current_user_id();
    $NewCountChance = $WheelLuck->CountSpinChance($uid)+$Count;
    global $wpdb;
        $tableName = 'Shahkar_users_profile';

        $data = [
            'vp_SpinChance' => $NewCountChance,
        ];

        $where = [
            'vp_uid' => $uid,
        ];

        $wpdb->update($tableName, $data, $where);
  }


  
  public static function CreatItem($title,$type,$value){
   global $wpdb;

        $tableName = 'Shahkar_wheel_luck';
        $data = [
            'wl_title' => $title,
            'wl_value' => $value,
            'wl_type' => $type,
        ];

        return $wpdb->insert($tableName, $data);
  }
  public static function SaveLog($random_wl_id,$in_profile = NULL,$Value,$Wintype){
    $WheelLuck = new WheelLuck();
    global $wpdb;
	$AwardTitle = $WheelLuck->GetAwardName($random_wl_id);
    $uid = get_current_user_id();
    $time = strtotime(date("Y/m/d"));
        $tableName = 'Shahkar_wheel_luck_log';
        $data = [
            'wll_title' => $AwardTitle,
            'wll_uid' => $uid,
            'wll_time' => $time,
            'wll_value' => $Value,
            'wll_type' => $Wintype,
            'wll_in_profile' => $in_profile,
        ];

        return $wpdb->insert($tableName, $data);
  }
  public static function GetAwardName($AwardId){
    global $wpdb;
        $query = $wpdb->prepare("SELECT wl_title FROM Shahkar_wheel_luck WHERE wl_id = $AwardId");
        $results = $wpdb->query($query);
        $data = $wpdb->get_results($query, OBJECT);

        return $data[0]->wl_title;
  }
  public static function chancesUsedInDay(){
    global $wpdb;
    $user_id = get_current_user_id();
    $current_time = strtotime(date("Y/m/d"));
    $chances_used_in_day = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT COUNT(*) FROM Shahkar_wheel_luck_log WHERE wll_uid = %d AND wll_time = %d AND wll_in_profile IS NULL",
        $user_id,
        $current_time
    )
);
    return $chances_used_in_day;
  }
  public static function CountUsedOffCode($user_id,$coupon_code){
    global $wpdb;
    $CheckOffCode = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT COUNT(wll_id) FROM Shahkar_wheel_luck_log WHERE wll_uid = '$user_id' AND wll_value = '$coupon_code' AND wll_Used = 1"
    )
);
    return $CheckOffCode;
  }
  public static function UserUsedOffCode($coupon_code){
   global $wpdb;
    $user_id = get_current_user_id();
    $CheckOffCode = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT COUNT(wll_id) FROM Shahkar_wheel_luck_log WHERE wll_uid = %d AND wll_value = %d",
        $user_id,
        $coupon_code
    )
);
    if($CheckOffCode>0){
     $tableName = 'Shahkar_wheel_luck_log';

        $data = [
            'wll_Used' => 1,
        ];

        $where = [
            'wll_uid' => $user_id,
            'wll_value' => $coupon_code,
        ];

        $wpdb->update($tableName, $data, $where); 
    }
    
  }
  
  public static function DeleteItem($Itemid){
    global $wpdb;
    $tableNameDelete = 'Shahkar_wheel_luck';

        $sql = $wpdb->prepare("DELETE FROM $tableNameDelete WHERE wl_id = %d", $Itemid);
        $wpdb->query($sql);

        return $wpdb->query($sql) !== false;
  }

  
  
}
?>