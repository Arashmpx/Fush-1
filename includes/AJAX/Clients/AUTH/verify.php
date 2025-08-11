<?php
session_start();

require_once('../../../../../../../wp-load.php');
$Sec = new secure();
$Sec->DDOS();

// Usage
$verificationHandler = new VerificationHandler();
$verificationHandler->handleVerification();
?>
