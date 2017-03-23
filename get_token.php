<?php  
//server should keep seesion data for AT LEAST 1 hour
ini_set('session.gc_maxlifeitme', 600);
session_set_cookie_params(600);
session_start();
$curl = curl_init();
$username = $_POST['username'];
$password = $_POST['password'];

curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'http://opleapi.cloudapp.net:9999/api-token-auth/',
	CURLOPT_USERAGENT => "auth-token request",
	CURLOPT_POST => 0,
	CURLOPT_POSTFIELDS => array(
		'username' => $username,
		'password' => $password,
		)
	));
$resp = curl_exec($curl);
curl_close($curl); 

$tokenobj =json_decode($resp, false);
$token="Token ".$tokenobj->token;

$_SESSION['auth_token'] = $token;
setcookie('auth_token', $token, time()+3600*24*365);

$resp = $_SESSION['auth_token'];

if(isset($_SESSION['auth_token'])){
	echo "<meta http-equiv='refresh' content='1;url=main.php'>";
};
?>
