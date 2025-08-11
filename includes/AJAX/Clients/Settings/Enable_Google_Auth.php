<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
require WP_PLUGIN_DIR ."/Shahkar/includes/lib/vendor/autoload.php";

use Vectorface\GoogleAuthenticator;
$ga = new GoogleAuthenticator();
$authenticator = new TwoFactorAuthenticator($ga);
$authenticator->enableGoogleAuth($Sec->input($_POST['currentpass']), $Sec->input($_POST['verifycode']), get_current_user_id());



?>