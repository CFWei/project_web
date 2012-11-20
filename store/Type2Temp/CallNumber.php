<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$CallNumber=$_POST['CallNumber'];


$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


//找ItemID
$query="SELECT * FROM ".$SerialNumbers." where State !='DIE'";
$db->query($query);

$temp=$db->fetch_array();
$ItemID=$temp['ID'];


$query="SELECT Now_Value FROM ".$SerialNumbers." WHERE ID='".$ItemID."'";
$db->query($query);

$temp=$db->fetch_array();
$Now_Value=$temp['Now_Value'];

//表示此商品正在被服務 傳回-2
if($Now_Value==$Number)
{
	echo "-2";
	exit;	

}

$query="UPDATE custom_information SET `life` = 1 where `store` ='".$SerialNumbers."' and item ='".$ItemID."' and number ='".$Now_Value."'";
//$db->query($query);

$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$CallNumber."\" where `ID` =\"".$ItemID."\"";
//$db->query($query);

$output['Now_Value']=$Now_Value;
$output['Number']=$CallNumber;

echo json_encode($output)

?>







