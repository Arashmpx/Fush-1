<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$ticketHandler = new TicketHandler();
$ticketHandler->handleTicketSubmission();

?>