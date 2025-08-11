<?php



		$url = "https://ippanel.com/services.jspd";
		$param = array
					(
						'uname'=>'',
						'pass'=>'',
						'state_id'=>'',
						'op'=>'countrycity'
					);
					
		$handler = curl_init($url);             
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response2 = curl_exec($handler);
		
		$response2 = json_decode($response2);
		$res_code = $response2[0];
		$res_data = $response2[1];
		
		
		echo $res_data;


?>