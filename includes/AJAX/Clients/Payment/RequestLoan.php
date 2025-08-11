<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$Loan = new Loan();
$Loan->RequestLoan();
?>