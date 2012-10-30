<?php
//-1:無法取得SerialNumbers
require_once("session.php");
$session=new session();

if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "-1";
	exit();
}

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//擷取ItemID
$query="SELECT ID FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$ItemID=$temp['ID'];

$query="SELECT Num,ItemID,Quantity,GroupID FROM Type2".$ItemID." ORDER BY Num";
$db->query($query);

while($temp=$db->fetch_array())
{	
	$Item=null;

	$Quantity=$temp['Quantity'];
	$ItemID=$temp['ItemID'];
	$Num=$temp['Num'];	
	
	$query="SELECT ItemNickName FROM StoreTakenItem WHERE Store ='".$SerialNumbers."' and TakenItemID ='".$ItemID."' ";
	$db1=new DB();
	$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);	
	$db1->query($query);
	
	$ItemTemp=$db1->fetch_array();
	$ItemName=$ItemTemp['ItemNickName'];
	
	$Item['Name']=$ItemName;
	$Item['ID']=$ItemID;
	$Item['Quantity']=$Quantity;
	$Item['Num']=$Num;

	$output[]=$Item;
}



echo json_encode($output);
?>
