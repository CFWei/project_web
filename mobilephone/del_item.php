<?php
	
	$UserIMEI=$_POST['UserIMEI'];
	$Store=$_POST['Store'];
	$Item=$_POST['Item'];
	$Number=$_POST['Number'];
	
	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="UPDATE custom_information SET life=1 where `custom_id`='".$UserIMEI."' and `store` ='".$Store."' and `item`='".$Item."' and `number`='".$Number."'";

	$db->query($query);
?>
