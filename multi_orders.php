<?php  

session_start();
$token = $_SESSION['auth_token'];

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL =>'http://opleapi.cloudapp.net:9999/multi_orders/',
	CURLOPT_HTTPHEADER =>array(
	'Authorization:'.$token,
	)

	));



$resp = curl_exec($curl);


echo "$resp";
?>