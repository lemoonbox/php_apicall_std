<?php

include 'authentication.php';

$token = check_login();

$api_urlinit = 'http://opleapi.cloudapp.net:9999/product/';
$limit = "20";
$offset = isset($_GET['offset'])? $_GET['offset']:"0";
$api_urlset = $api_urlinit."?limit=".$limit."&offset=".$offset;

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL =>$api_urlset,
	CURLOPT_HTTPHEADER =>array(
	'Authorization:'.$token,
	)

	));
$resp = curl_exec($curl);
//orginal json data by array
$resparray = json_decode($resp, true);

//data array init
$tabledatas = array();
$resultarr = array();

//paging data generator
$page_num = array();
$page_urlinit = "/product.html";
if(isset($resparray['previous'])){
	if($offset-40>0){
	$tabledatas['url_pre2'] = $offset-40;
	$page_num[($offset/20)-1] = $offset-40;
	}
	$tabledatas['url_pre1'] = $offset-20;
	$page_num[($offset/20)] = $offset-20;

}
$page_num[($offset/20+1)] = $offset+0;
if(isset($resparray['next'])){
	$tabledatas['url_next1'] = $offset+20;
	$page_num[($offset/20)+2] = $offset+20;
	if($offset+40<$resparray['count']){
		$tabledatas['url_next2'] = $offset+40;
		$page_num[($offset/20)+3] = $offset+40;
	}
}
$tabledatas['page_num']=$page_num;

//create value set
foreach ($resparray['results'] as $valueset) {
	array_push($resultarr, array(
		'id' =>$valueset['id'],
		'name' =>$valueset['name'],
		'size' =>$valueset['size'],
		'bundle' =>$valueset['bundle'],
		'supplier' => $valueset['supplier']['name'],
		'is_tax' =>$valueset['is_tax'],
		));
};
$tabledatas['results'] = $resultarr;

echo json_encode($tabledatas);

?>





