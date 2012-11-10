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


$count=0;
while($temp=$db->fetch_array())
{	
	$data=null;
	$data['CustomID']=$temp['CustomID'];
	$data['Quantity']=$temp['Quantity'];

	if($count==0)
	{
		for($i=0;$i<count($TakenItemIDList);$i++)
		{
			if($TakenItemIDList[$i]==$temp['ItemID'])
			{
				$output[$count]['ItemName']=$TakenItemNameList[$i];
			}
		}
		$output[$count]['ItemID']=$temp['ItemID'];
		$output[$count]['WaitingCustomData'][]=$data;
		$count++;
			
		
	}
	else
	{
		$flag=0;
		for($i=0;$i<count($output);$i++)
		{
			if($output[$i]['ItemID']==$temp['ItemID'])
			{
				$output[$i]['WaitingCustomData'][]=$data;
				$flag=1;
				break;
			}
		}
		if($flag==0)
		{
			for($i=0;$i<count($TakenItemIDList);$i++)
			{
				if($TakenItemIDList[$i]==$temp['ItemID'])
				{
					$output[$count]['ItemName']=$TakenItemNameList[$i];
				}
			}
			$output[$count]['ItemID']=$temp['ItemID'];
			$output[$count]['WaitingCustomData'][]=$data;
			$count++;
		}

	}	
}


echo json_encode($output);


//print_r($output);

?>
