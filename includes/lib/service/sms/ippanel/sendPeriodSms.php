<?php



		$url = "https://ippanel.com/services.jspd";
		
		$rcpt_nm = array('9121111111','9122222222');
		$param = array
					(
						'uname'=>'',
						'pass'=>'',
						'from'=>'',
						'message'=>'',
						'to'=>json_encode($rcpt_nm),
						'time' => '2017-01-01',   //'time' => '2017-01-01 12:50:40'
						'op'=>'send'
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