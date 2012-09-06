<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];

$query="SELECT SelectItem FROM custom_information WHERE custom_id='".$CustomID."' AND store ='".$Store."' AND item='".$ItemID."' AND life='0'";
$db->query($query);
$temp=$db->fetch_assoc();
$ItemList=json_decode($temp['SelectItem']);


//找出所有商品清單 之後轉換名字用
$query="SELECT * FROM StoreTakenItem WHERE Store='".$Store."'";
$db->query($query);
while($temp=$db->fetch_array())
{
	$TakenItemIDList[]=$temp['TakenItemID'];
	$TakenItemNameList[]=$temp['ItemName'];
	$TakenItemPriceList[]=$temp['Price'];
}


$i=0;
foreach($ItemList as $Num=>$ItemData)
{	
	$TakenItemID="";
	$NeedValue="";
	$ItemName="";
	foreach($ItemData as $DataColumn=>$Data)
	{
		if($DataColumn=="TakenItemID")
		{
			$TakenItemID=$Data;
		}
		if($DataColumn=="NeedValue")
		{
			$NeedValue=$Data;
		}
	}

	$Record=0;
	for($i=0;$i<count($TakenItemIDList);$i++)
	{	
		if($TakenItemIDList[$i]==$TakenItemID)		
		{
			$ItemName=$TakenItemNameList[$i];
			$Record=$i;
		}
							
	}	

	$output[$i]['NeedValue']=$NeedValue;
	$output[$i]['TakenItemID']=$TakenItemID;
	$output[$i]['ItemName']=$ItemName;
	$output[$i]['Price']=$TakenItemPriceList[$Record];

	$output_final[]=$output[$i];
	$i++;
}

echo json_encode($output_final);
?>
