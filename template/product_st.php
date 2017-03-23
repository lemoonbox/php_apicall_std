<?php

include '../authentication.php';

$token = check_login();

$api_urlinit = 'http://opleapi.cloudapp.net:9999/product/';
$limit = "20";

if(!isset($_GET['offset'])){
	$offset = "0";
}else{
	$offset = $_GET['offset'];
}
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
$page_urlinit = "product_st.php";
if(isset($resparray['previous'])){
	if($offset-40>0){
	$tabledatas['url_pre2'] = $page_urlinit."?limit=".$limit."&offset=".($offset-40);
	$page_num[($offset/20)-1] = $page_urlinit."?limit=".$limit."&offset=".($offset-40);
	}
	$tabledatas['url_pre1'] = $page_urlinit."?limit=".$limit."&offset=".($offset-20);
	$page_num[($offset/20)] = $page_urlinit."?limit=".$limit."&offset=".($offset-20);

}
$page_num["now_num"] = ($offset/20)+1;
if(isset($resparray['next'])){
	$tabledatas['url_next1'] = $page_urlinit."?limit=".$limit."&offset=".($offset+20);
	$page_num[($offset/20)+2] = $page_urlinit."?limit=".$limit."&offset=".($offset+20);
	if($offset+40<$resparray['count']){
		$tabledatas['url_next2'] = $page_urlinit."?limit=".$limit."&offset=".($offset+40);
		$page_num[($offset/20)+3] = $page_urlinit."?limit=".$limit."&offset=".($offset+40);
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
?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
<h1>상품 리스트 입니다.</h1>
 <table>
 	<tr>
 		<th>ID</th>
 		<th>이름</th>
 		<th>용량,중량,크기</th>
 		<th>포장단위</th>
 		<th>공급업체</th>
 		<th>면세상품</th>
 	</tr>
 	<?php
 		//it'll make to function. parameters : <th>list, valusetarry(it havn't string key)
 		foreach ($tabledatas['results'] as $valueset) {
 			$id = $valueset['id'];
 		  	echo "<tr>";
		  	echo "<td>{$valueset['id']}</td>";
		  	echo "<td>{$valueset['name']}</td>";
		  	echo "<td>{$valueset['size']}</td>";
		  	echo "<td>{$valueset['bundle']}</td>";
		  	echo "<td>{$valueset['supplier']}</td>";
		  	echo "<td>{$valueset['is_tax']}</td>";
 		  	echo "</tr>";
 		}
 	?>
 </table>
<ul class="pagination">
	<?php
	$limit = $limit;
	$offset = $offset;
	if(isset($tabledatas['url_pre1'])){
		echo "<li><a href='{$tabledatas['url_pre1']}'><span><<<</span></li>";
	}else{
		echo "<li><a href='#'><span><<<</span></li>";
	};
	foreach ($tabledatas['page_num'] as $key => $value) {
		if($key == "now_num"){
			echo "<li><a href='#'><span>$value</span></li>";
		}else{
			echo "<li><a href='$value'><span>$key</span></li>";
		};
	}
	if(isset($tabledatas['url_next1'])){
		echo "<li><a href='{$tabledatas['url_next1']}'><span>>>></span></li>";
	}else{
		echo "<li><a href='#'><span>>>></span></li>";
	}
	?>

</ul>

 </body>
 </html>