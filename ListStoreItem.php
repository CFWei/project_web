<?php
require_once("session.php");
$se=new session();	
if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}


require_once("connect_mysql_class.php");
require_once("mysql_inc.php");


$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT ID FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$ItemID=$temp['ID'];

$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);
	
//找出所有商品清單 之後轉換名字用
while($temp=$db->fetch_array())
{
	$TakenItemIDList[]=$temp['TakenItemID'];
	$TakenItemNameList[]=$temp['ItemName'];
	$TakenItemPriceList[]=$temp['Price'];
}


$query="SELECT * FROM Type2".$ItemID;
$db->query($query);

$output[]=null;
$count=0;
while($temp=$db->fetch_array())
{
	if(in_array($temp['ItemID'],$output))
	{
		echo "1";
	}	
	else
	{
		$output[$count]['ID']=$temp['ItemID'];
	}

	$data['ItemID']=$temp['ItemID'];
	$data['Quantity']=$temp['Quantity'];
	$output[]=$data;
}

function test($value,$array)
{
	echo

}

//print_r($output);
?>
