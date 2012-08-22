<?php
require_once("session.php");

$session=new session();
if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
//	echo "******************取得SerialNumbers失敗******************";
	echo "-1";
	exit();
}

$ItemID=$_POST['ItemID'];
$CustomID=$_POST['CustomID'];
$Value=$_POST['Value'];

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$query="UPDATE custom_information SET life=2 where `store` ='".$SerialNumbers."' and `item`='".$ItemID."' and `number`='".$Value."' and custom_id='".$CustomID."'";
$db->query($query);

echo '1';
?>
