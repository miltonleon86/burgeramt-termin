<?php

use Burgeramt\PushoverHelper;

require __DIR__ . '/../vendor/autoload.php';


$curl = curl_init();

curl_setopt_array($curl, array(
	  CURLOPT_URL => getenv('URL'),
	    CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "GET"
	      ));

$pushover = new PushoverHelper();

while (true) {
	$response = curl_exec($curl);
	$err = curl_error($curl);

	if ($err) {
		$pushover->sendPushoverNotification('Curl Error ' . $err);
	} else {
		$count = substr_count($response, 'buchbar');
		
		if ($count > 6)
		{
			 $pushover->sendPushoverNotification('Found ' . $count . ' Times we where searching for 6');
		}
		
	}

	sleep (10);
}

curl_close($curl);
