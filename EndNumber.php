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

//找ItemID
$query="SELECT ID,Now_Value FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$ItemID=$temp['ID'];
$NowValue=$temp['Now_Value'];

//找尋NowValue的客戶
$query="Select * from custom_information where store = '".$SerialNumbers."' and item = '".$ItemID."' and number ='".$NowValue."'";
$db->query($query);
$temp=$db->fetch_array();

//若已結束則回傳-2
if($temp['life']!="0")
{
	echo '-2';
	exit();
}

//設為結束
$query="UPDATE custom_information SET `life` = 1 where `store` ='".$SerialNumbers."' and item ='".$ItemID."' and number ='".$NowValue."'";
$db->query($query);


echo $NowValue;


?>
