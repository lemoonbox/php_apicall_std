<?php

function check_login(){
	if(!isset($_COOKIE['auth_token'])){
		echo "<meta http-equiv='refresh' content='1;url=authen_error.php'>";
	}
	$token = $_COOKIE['auth_token'];

	$curl = curl_init();
	curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL =>'http://opleapi.cloudapp.net:9999/',
			CURLOPT_HTTPHEADER =>array(
			'Authorization:'.$token,
			)

		));
	$resp = curl_exec($curl);

	if(!curl_errno($curl)){
		switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)){
			case 200 :
				session_start();
				$_SESSION['auth_token']=$token;
				return $token;
			default:
				echo "<meta http-equiv='refresh' content='0;url=authen_error.php'>";
				return false;
		}
	};
}
// echo check_login();
?>