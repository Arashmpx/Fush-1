<?php

		$url = "https://ippanel.com/services.jspd";
		$param = array
					(
						'uname'=>'',
						'pass'=>'',
						'op'=>'booklist'
					);
					
		$handler = curl_init($url);             
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handler);
		$responseJsonDecode = json_decode($response);
		$responseJsonDecode2 = json_decode($responseJsonDecode[1]);
		foreach ($responseJsonDecode2 as $value) {
			echo $value->title; //PhoneBookTitle
			echo $value->id; //PhoneBookID
			echo"\n\r";
		}
	
?>