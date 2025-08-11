<?php
include "../../../../../../../wp-load.php";
$Sec = new secure();
$Sec->DDOS(true);
$FavoritesHandler = new ShahkarFavorites();
$FavoritesHandler->handleRemovePost();

?>