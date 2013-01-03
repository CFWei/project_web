<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];
$Value=$_POST['Value'];
$StoreType=$_POST['StoreType'];

$query="UPDATE custom_information SET life=2 where `store` ='".$Store."' and `item`='".$ItemID."' and `number`='".$Value."' and custom_id='".$CustomID."'";

$db->query($query);

if($StoreType=="2"){
	$query="Delete FROM Type2".$ItemID." where CustomID='".$CustomID."'";
	$db->query($query);
	
}
echo "1";
?>
