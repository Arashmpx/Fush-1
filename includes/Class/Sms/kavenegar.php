<?php
class sms
{

    public $user;
    public $pass;
    public $fromNum;
  	public $ApiKey;

    public function __construct()
    {
        $this->user = get_option('shahkar_smspanel_username');
        $this->pass = get_option('shahkar_smspanel_password');
        $this->fromNum = get_option('shahkar_smspanel_sendernumber');
      	$this->ApiKey = get_option('shahkar_smspanel_api_key');
    }

    public function verifycode($code, $number)
    {
      $Template = get_option('shahkar_otp_pattern');
      $apiKey = $this->ApiKey;
$url = "https://api.kavenegar.com/v1/{$apiKey}/verify/lookup.json?receptor={$number}&token={$code}&template={$Template}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);



    }


    public function new_ticket_to_admin($uid)
    {
        $number = get_option('shahkar_admin_number');
        $user = new user();
        $username = $user->Shahkar_getDisplayName($uid);
      
      $Template = get_option('shahkar_new_ticket_notification_to_admin_pattern');
      $apiKey = $this->ApiKey;
$url = "https://api.kavenegar.com/v1/{$apiKey}/verify/lookup.json?receptor={$number}&token={$username}&template={$Template}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

    }

    public function reply_ticket_to_user($adminid, $sender_id)
    {
        $user = new user();
        $number = $user->Shahkar_getNumber($sender_id);
        $adminname = $user->Shahkar_getDisplayName($adminid);
      
      $Template = get_option('shahkar_answer_ticket_notification_to_user_pattern');
      $apiKey = $this->ApiKey;
$url = "https://api.kavenegar.com/v1/{$apiKey}/verify/lookup.json?receptor={$number}&token={$adminname}&template={$Template}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);
      
        
      

    }

    public function back_to_payment($number)
    {
        $offcode = get_option('shahkar_offcode_abandoned_shopping_cart_notification');
        
      $Template = get_option('shahkar_back_to_payment_pattern');
      $apiKey = $this->ApiKey;
$url = "https://api.kavenegar.com/v1/{$apiKey}/verify/lookup.json?receptor={$number}&token={$offcode}&template={$Template}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);
      

    }
  
  public function NotifWin($number,$Award)
    {
    
    $Template = get_option('shahkar_win_in_wheel_luck_pattern');
      $apiKey = $this->ApiKey;
$url = "https://api.kavenegar.com/v1/{$apiKey}/verify/lookup.json?receptor={$number}&token={$Award}&template={$Template}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);
        
    
    
    }
  
  static function after_payment($number,$uid)
    {
    	$user = new user();
    	$username = $user->Shahkar_getDisplayName($uid);
        $Template = get_option('shahkar_after_buying_pattern');
      $apiKey = $this->ApiKey;
$url = "https://api.kavenegar.com/v1/{$apiKey}/verify/lookup.json?receptor={$number}&token={$username}&template={$Template}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);
    }


        public function SendToUsers($text, $nums){
    $apiKey = $this->ApiKey; 

    $encodedText = urlencode($text);
    $encodedNumbers = urlencode(implode(',', $nums)); 

    $url = "https://api.kavenegar.com/v1/{$apiKey}/sms/send.json?receptor={$encodedNumbers}&message={$encodedText}&sender=10007000300050";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
 
    curl_close($ch);
}



}
?>