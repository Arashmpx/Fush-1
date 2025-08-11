<?php



		$url = "https://ippanel.com/services.jspd";
		$param = array
					(
						'uname'=>'',
                        'pass'=>'',
                        'subject' => 'موضوع',
                        'description' => 'توضیحات',
                        'type'=> 'fiscal',   //'fiscal','webservice','problem','lineservices'
                        'importance' => 'low',  //'low','middle','quick','acute'
                        'sms_notification' => 'yes', //'yes','no'
                        'file'=> 'http://yoururl/file.zip',   /// .zip
                        'op'=>'ticketadd'
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