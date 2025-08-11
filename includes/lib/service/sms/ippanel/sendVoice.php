<?php



		$url = "https://ippanel.com/services.jspd";
		
		$rcpt_nm = array('9127305485');
		$param = array
					(
						'uname'=>'',
						'pass'=>'',
						'repeat'=>'1', 
						'to'=>json_encode($rcpt_nm),
						'fileUrl'=>"http://file_url",		//wav
						'op'=>'sendvoice'
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