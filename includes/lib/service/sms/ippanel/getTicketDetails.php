<?php



		$url = "https://ippanel.com/services.jspd";
		$param = array
					(
						'uname'=>'',
                        'pass'=>'',
                        'ticket_id'=>'',
                        'op'=>'ticketdetails'
					);

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($handler);

        $response2 = json_decode($response2);

        $res_code = $response2[0];
        $res_data_one = $response2[1];
        $res_data_two = $response2[2];

        echo $res_data_one;
        echo'<br><br>';
        echo $res_data_two;
?>