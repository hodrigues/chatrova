<?php 
	$access_token = "EAADrhWiX85EBANVk5exrRZBBdk3qvrt1wBEZBNliczcM6RgaANRKQOCo50cmxqEn5mxJ2ezG2ioE6I79ncoZCofdoNYVcRVFXTaX6YId30YQAa4sr1UvgWzsMvQ6AvgxJQeOLnWiztnPAzInT3ZC3hABeZCdXAh50XqaNlcZAZA76Bx1MwUDicy";
	$verify_token = "sucesso";
	$hub_verify_token = null;

	if(isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe'){
		$challenge = $_REQUEST['hub_challenge'];
		$hub_verify_token = $_REQUEST['hub_verify_token'];
		if ($hub_verify_token === $verify_token) {
			header('HTTP/1.1 200 OK');
			echo $challenge;
			die;
		}
	}

	$input = json_decode(file_get_contents('php://input'), true);

	$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
	$message = isset($input['entry'][0]['messaging'][0]['message']['text']) ? $input['entry'][0]['messaging'][0]['message']['text'] : '';

	if($message){
		if($message == 'oi'){
			$message_to_reply = "Oee";
		}
		$message_to_reply = "Trab do trabson !!";

		$url = "https://graph.facebook.com/v2.6/me/message?access_token".$access_token;
		$jsonData = '{
			"recipient":{
				"id":"'.$sender'"
			},
			"message":{
				"text":"'.$message_to_reply'"
			}
		}';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);
	}
?>