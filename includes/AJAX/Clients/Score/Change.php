<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$ShahkarScore = new ShahkarScore();
$ShahkarScore->handleScoreChange();

?>