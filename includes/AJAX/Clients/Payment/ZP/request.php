<?php
include "../../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$walletChargeHandler = new WalletChargeHandler();
$walletChargeHandler->handleChargeRequest();
?>