<?php
//-1:已經在換號列表裡面
//-2:店家不存在
//-3:商品不存在
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];
$Choose=$_POST['Choose'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


//檢查是否有在換號列表裡面 若有則回傳-1 並跳出
$query="Select * from ChangeNumberList where CustomID ='".$CustomID."' and Store ='".$Store."' and ItemID = '".$ItemID."'";
$db->query($query);
if($db->get_num_rows()!=0)
{
	echo "-1";
	exit;
}

//檢查店家是否存在 若不存在則回傳-2
$query="Select * from store_information where SerialNumbers ='".$Store."'";
$db->query($query);
if($db->get_num_rows()!=1)
{
	echo "-2";
	exit;
}


//檢查商品是否存在 若不存在則回傳-3
$query="Select * from ".$Store." where ID ='".$ItemID."'";
$db->query($query);
if($db->get_num_rows()!=1)
{
	echo "-3";
	exit;
}


//將換號資訊存入Server
$query="Insert into `ChangeNumberList` (`CustomID`, `ItemID`, `Store`, `Choose`) VALUES ('".$CustomID."','".$ItemID."','".$Store."','".$Choose."')";
$db->query($query);




?>
