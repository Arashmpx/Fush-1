<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$changer = new PasswordChanger();
$changer->changePassword($Sec->input($_POST['pass']), $Sec->input($_POST['repeatpass']));
?>