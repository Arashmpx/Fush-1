<?php
class sms
{

    public $user;
    public $pass;
    public $fromNum;

    public function __construct()
    {
        $this->user = get_option('shahkar_smspanel_username');
        $this->pass = get_option('shahkar_smspanel_password');
        $this->fromNum = get_option('shahkar_smspanel_sendernumber');
    }

    public function verifycode($code, $number)
    {
        $client = new SoapClient("http://sms.farazsms.com/class/sms/wsdlservice/server.php?wsdl");
        $user = $this->user;
        $pass = $this->pass;
        $fromNum = $this->fromNum;
        $toNum = array($number);
        $pattern_code = get_option('shahkar_otp_pattern');
        $input_data = array("code" => $code);

        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);


    }


    public function new_ticket_to_admin($uid)
    {
        $number = get_option('shahkar_admin_number');
        $user = new user();
        $username = $user->Shahkar_getDisplayName($uid);
        $client = new SoapClient("http://sms.farazsms.com/class/sms/wsdlservice/server.php?wsdl");
        $user = $this->user;
        $pass = $this->pass;
        $fromNum = $this->fromNum;
        $toNum = array($number);
        $pattern_code = get_option('shahkar_new_ticket_notification_to_admin_pattern');
        $input_data = array("username" => $username);

        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);


    }

    public function reply_ticket_to_user($adminid, $sender_id)
    {
        $user = new user();
        $number = $user->Shahkar_getNumber($sender_id);
        $adminname = $user->Shahkar_getDisplayName($adminid);
        $client = new SoapClient("http://sms.farazsms.com/class/sms/wsdlservice/server.php?wsdl");
        $user = $this->user;
        $pass = $this->pass;
        $fromNum = $this->fromNum;
        $toNum = array($number);
        $pattern_code = get_option('shahkar_answer_ticket_notification_to_user_pattern');
        $input_data = array("adminname" => $adminname);

        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);


    }

    public function back_to_payment($number)
    {
        $offcode = get_option('shahkar_offcode_abandoned_shopping_cart_notification');
        $client = new SoapClient("http://sms.farazsms.com/class/sms/wsdlservice/server.php?wsdl");
        $user = $this->user;
        $pass = $this->pass;
        $fromNum = $this->fromNum;
        $toNum = array($number);
        $pattern_code = get_option('shahkar_back_to_payment_pattern');
        $input_data = array("offoce" => $offcode);

        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
    }
  
  public function NotifWin($number,$Award)
    {
        $offcode = get_option('shahkar_offcode_abandoned_shopping_cart_notification');
        $client = new SoapClient("http://sms.farazsms.com/class/sms/wsdlservice/server.php?wsdl");
        $user = $this->user;
        $pass = $this->pass;
        $fromNum = $this->fromNum;
        $toNum = array($number);
        $pattern_code = get_option('shahkar_win_in_wheel_luck_pattern');
        $input_data = array("Award" => $Award);

        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
    
    
    }
  
  static function after_payment($number,$uid)
    {
    	$user = new user();
    	$username = $user->Shahkar_getDisplayName($uid);
        $offcode = get_option('shahkar_after_buying_pattern');
        $client = new SoapClient("http://sms.farazsms.com/class/sms/wsdlservice/server.php?wsdl");
        $user = $this->user;
        $pass = $this->pass;
        $fromNum = $this->fromNum;
        $toNum = array($number);
        $pattern_code = get_option('shahkar_after_buying_pattern');
        $input_data = array("username" => $username);

        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
    }
}
?>