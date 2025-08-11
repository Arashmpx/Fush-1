<?php
class sms
{

    public static $user;
    public static $pass;
    public static $fromNum;

    public function __construct()
    {
		self::$user = get_option('shahkar_smspanel_username');
        self::$pass = get_option('shahkar_smspanel_password');
        self::$fromNum = get_option('shahkar_smspanel_sendernumber');
    }

    public function verifycode($code, $number)
    {
      
        $data = array('username' => self::$user, 'password' => self::$pass,'text' => $code,'to' =>$number ,"bodyId"=>get_option('shahkar_otp_pattern'));
$post_data = http_build_query($data);
$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'content-type' => 'application/x-www-form-urlencoded'
));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($handle);


    }


    public function new_ticket_to_admin($uid)
    {
        $number = get_option('shahkar_admin_number');
        $user = new user();
        $username = $user->Shahkar_getDisplayName($uid);
      $data = array('username' => self::$user, 'password' => self::$pass,'text' => $username,'to' =>$number ,"bodyId"=>get_option('shahkar_new_ticket_notification_to_admin_pattern'));
$post_data = http_build_query($data);
$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'content-type' => 'application/x-www-form-urlencoded'
));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($handle);
      
      



    }

    public function reply_ticket_to_user($adminid, $sender_id)
    {
        $user = new user();
        $number = $user->Shahkar_getNumber($sender_id);
        $adminname = $user->Shahkar_getDisplayName($adminid);
      
      $data = array('username' => self::$user, 'password' => self::$pass,'text' => $adminname,'to' =>$number ,"bodyId"=>get_option('shahkar_answer_ticket_notification_to_user_pattern'));
$post_data = http_build_query($data);
$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'content-type' => 'application/x-www-form-urlencoded'
));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($handle);
      
        
      

    }

    public function back_to_payment($number)
    {
        $offcode = get_option('shahkar_offcode_abandoned_shopping_cart_notification');
        
      $data = array('username' => self::$user, 'password' => self::$pass,'text' => $offcode,'to' =>$number ,"bodyId"=>get_option('shahkar_back_to_payment_pattern'));
$post_data = http_build_query($data);
$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'content-type' => 'application/x-www-form-urlencoded'
));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($handle);
      

    }
  
  public function NotifWin($number,$Award)
    {
        $offcode = get_option('shahkar_offcode_abandoned_shopping_cart_notification');
    
    $data = array('username' => self::$user, 'password' => self::$pass,'text' => $Award,'to' =>$number ,"bodyId"=>get_option('shahkar_win_in_wheel_luck_pattern'));
$post_data = http_build_query($data);
$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'content-type' => 'application/x-www-form-urlencoded'
));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($handle);
        
    
    
    }
  
  static function after_payment($number,$uid)
    {
    	$user = new user();
    	$username = $user->Shahkar_getDisplayName($uid);
        $data = array('username' => self::$user, 'password' => self::$pass,'text' => $username,'to' =>$number ,"bodyId"=>get_option('shahkar_after_buying_pattern'));
$post_data = http_build_query($data);
$handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    'content-type' => 'application/x-www-form-urlencoded'
));
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
$response = curl_exec($handle);
    }
}
?>