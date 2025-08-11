<?php
session_start();
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);

$ticketReplyHandler = new TicketReplyHandler();
$ticketReplyHandler->handleTicketReply();
?>