<?php
require_once("session.php");
$se=new session();	
if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "-1";
	exit();
}
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$Number=$_POST['Number'];
$ItemID=$_POST['ItemID'];

$query="SELECT Now_Value FROM ".$SerialNumbers." WHERE ID='".$ItemID."'";
$db->query($query);

$temp=$db->fetch_array();
$Now_Value=$temp['Now_Value'];

//表示此商品正在被服務 傳回-2
if($Now_Value==$Number){
	echo "-2";
	exit;	
}

$query="Select * from custom_information where store ='".$SerialNumbers."' and item='".$ItemID."' and number='".$Number."' and life='0'";
$db->query($query);
$temp=$db->fetch_array();
$CustomID=$temp['custom_id'];

//檢查waititemlist是否已經空了 若沒有則回傳-3 
$query="SELECT * FROM Type2".$ItemID." where CustomID ='".$CustomID."'";
$db->query($query);
if($db->get_num_rows()!=0){
	echo "-3";
	exit;
}


$query="UPDATE custom_information SET `life` = 1 where `store` ='".$SerialNumbers."' and item ='".$ItemID."' and number ='".$Now_Value."'";
$db->query($query);

$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$Number."\" where `ID` =\"".$ItemID."\"";
$db->query($query);

$output['Now_Value']=$Now_Value;
$output['Number']=$Number;


echo json_encode($output);

?>
