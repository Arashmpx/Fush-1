<?php

function ShahkarGetTranslateText($Key){
  if(isset($_COOKIE['ShahkarCurrentUserSelectedLang'])){
   $ShahkarCurrentSelectedLang =  $_COOKIE['ShahkarCurrentUserSelectedLang'];
  }elseif(!empty(get_option('Shahkar_admin_selected_lang'))){
    $ShahkarCurrentSelectedLang = get_option('Shahkar_admin_selected_lang');
  }else{
    $ShahkarCurrentSelectedLang = "fa";
  }
$file_path = WP_PLUGIN_DIR.'/Shahkar/modules/Lang/'.$ShahkarCurrentSelectedLang.'.json';
$json_content = file_get_contents($file_path);
$Translate = json_decode($json_content, true);
  return $Translate[$Key];
}

?>