<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$ShahkarProfile = new ShahkarProfile();
$ShahkarProfile->SaveProfileInfo();

?>