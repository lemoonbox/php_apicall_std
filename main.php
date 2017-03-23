<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
if(isset($_COOKIE['auth_token'])){
	echo "로그인 되었습니다.";
	echo "<a href='logout.php'>로그아웃</a><br>";
	echo "<a href='template/product_st.php'>product_st</a><br>";
	echo "<a href='template/product_aj.php'>product_aj</a><br>";
	echo "<a href='template/product_maj.php'>product_maj</a><br>";

}else{
	echo "<a href='template/login.php'>로그인</a>";
};

?>
</body>
</html>