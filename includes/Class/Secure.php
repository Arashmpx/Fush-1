<?php
class Secure
{
  	static function DDOS($ForceUser = false) {
    $parsed_url = wp_parse_url(get_site_url());

    $clean_domain = $parsed_url['scheme']."://".$parsed_url['host'];

    $allowedOrigin = $clean_domain;
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
	if($ForceUser==="admin") {
        if (!current_user_can('administrator')) {
            wp_redirect($allowedOrigin);
            exit();
        }
    }
    if ($ForceUser !== "admin") {
        if ($origin !== $allowedOrigin) {
            die("FireWall Is Enable");
        }
    } 

    if ($ForceUser) {
        if (!is_user_logged_in()) {
            die("Login In");
        }
    }
        
  if(get_option('shahkar_firewall_status')=="on"){
    session_start();
    $timeout = get_option('shahkar_Firewall_inSecend');
    $maxRequests = get_option('shahkar_Firewall_number_of_request');
    $blockTime = get_option('shahkar_Firewall_suspendTime')*60;

    if ($_SESSION['block_end_time'] >= time() && !current_user_can('administrator')) {
        $color = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
        $response = [
            "status" => 'danger',
            'response' => ShahkarGetTranslateText('ShahkarFirewallBlackListResponse'),
            "redirect" => 0,
            "url" => '',
            "color" => $color
        ];
        echo json_encode($response);
        exit();
    }

    $lastRequestTime = $_SESSION['last_request_time'] ?? null;
    $requestCount = $_SESSION['request_count'] ?? 0;

    if ($lastRequestTime !== null) {
        $currentTime = time();
        $timeElapsed = $currentTime - $lastRequestTime;

        if ($timeElapsed > $timeout) {
            $lastRequestTime = $currentTime;
            $requestCount = 0;
        }

        $blockEndTime = $_SESSION['block_end_time'] ?? 0;
        if ($currentTime > $blockEndTime) {
            unset($_SESSION['block_end_time']);
        }
    }

    if ($requestCount >= $maxRequests) {
      if(!current_user_can('administrator')){
        $color = 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
        $response = [
            "status" => 'danger',
            'response' => ShahkarGetTranslateText('ShahkarFirewallBlockedRequestResponse'),
            "redirect" => 0,
            "url" => '',
            "color" => $color
        ];
        $_SESSION['block_end_time'] = time() + $blockTime;
        echo json_encode($response);
        exit();
      }
    }

    $_SESSION['request_count'] = ++$requestCount;
    $_SESSION['last_request_time'] = time();

  } 
}
    static function input($input)
    {
        $data = htmlspecialchars($input);
        //$data = str_replace("'", "", $data);
       // $data = str_replace('"', '', $data);
        $data = strip_tags($data);

        return $data;
    }

    static function enableGoogleAuthenticator($secret)
    {
        global $wpdb;
        $current_user_id = get_current_user_id();
        $table_name = 'Shahkar_users_profile';

        $data = array('vp_auth_secret' => $secret);
        $where = array('vp_uid' => $current_user_id);

        return $wpdb->update($table_name, $data, $where);
    }

    static function disableGoogleAuthenticator($user_id)
    {
        global $wpdb;
        $table_name = 'Shahkar_users_profile';

        $data = array('vp_auth_secret' => null);
        $where = array('vp_uid' => $user_id);

        return $wpdb->update($table_name, $data, $where);
    }
    public function SetSession($UID){
        include WP_PLUGIN_DIR . "/Shahkar/includes/Class/DeviceDetect.php";
        $ShahkarDevice = new ShahkarDevice();
        $SESSIONID = session_id();
        $platform = $ShahkarDevice->getPlatform();
        $browser = $ShahkarDevice->getBrowser();
        $time = time();
        update_user_meta($user_id, 'ShahkarUserPlatform',$platform );
        update_user_meta($user_id, 'ShahkarUserBrowser', $browser);

        global $wpdb;
        $tableName = 'Shahkar_UserSessions';
        $data = [
            'vus_uid' => $UID,
            'vus_platform' => $platform,
            'vus_browser' => $browser,
            'vus_SESSID' => $SESSIONID,
            'vus_time' => $time
        ];

         $wpdb->insert($tableName, $data);


    }
    public function DeActiveSession(){
        $sec = new Secure();
        $SessID = $sec->input($_POST['SessID']);
        $UID = get_current_user_id();
        global $wpdb;
        $tableName = 'Shahkar_UserSessions';
        $sql = $wpdb->prepare("DELETE FROM $tableName WHERE vus_uid = '$UID' AND vus_id = '$SessID'");

         if($wpdb->query($sql)){
            $this->response(ShahkarGetTranslateText('ShahkarSuccessfullyDeletedResponse') , true, 0);
            
         }
    }
    private function response($message, $success, $url = '')
    {
        $color = $success ? 'linear-gradient(to right, rgb(0, 165, 146), rgb(51, 139, 147))' : 'linear-gradient(to right, rgb(243, 0, 75), rgb(255, 93, 75))';
        $redirect = $success ? 1 : 0;
        echo json_encode(["status" => $success, 'response' => $message, "redirect" => $redirect, "url" => $url, "color" => $color]);
        exit();
    }
    public function CheckActiveSession($Page = NULL){
    global $wpdb;
    $SESSID = session_id();
    $UID = get_current_user_id();
    $row_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(vus_id) FROM Shahkar_UserSessions WHERE vus_uid = '$UID' AND vus_SESSID='$SESSID'"));
	if($row_count<1 && $Page!=="profile"){
        $full_shahkar_dashurl = get_site_url() . "/" . get_option('shahkar_indexpage_url');
    wp_logout();
    ?>
    <script>
        var redirectTo = '<?php echo $full_shahkar_dashurl; ?>/?p=login';
        setTimeout(function() {
            window.location.href = redirectTo;
        }, 1000);
    </script>
    <?php
    exit();
    }
    }



function IranAccess(){
    $ShIRAip = $_SERVER['REMOTE_ADDR'];
    $ShIRAurl = "http://ip-api.com/json/{$ShIRAip}?fields=status,countryCode";
    $ShIRAch = curl_init($ShIRAurl);
    curl_setopt($ShIRAch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ShIRAch, CURLOPT_TIMEOUT, 5);
    $ShIRAresponse = curl_exec($ShIRAch);
    curl_close($ShIRAch);
    $ShIRAdata = json_decode($ShIRAresponse, true);
    return $ShIRAdata['countryCode'] && $ShIRAdata['status'] === 'success' && $ShIRAdata['countryCode'] !== 'IR';
}
}
?>