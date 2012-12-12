<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$UserIMEI=$_POST['UserIMEI'];
$CustomItemList=$_POST['CustomItemList'];
$phoneNubmer=$_POST['phoneNubmer'];

$Jsontemp=json_decode($CustomItemList);
$i=0;

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//找尋若已經抽號中 則reject
$query="SELECT * FROM custom_information WHERE store ='".$SerialNumbers."' AND custom_id ='".$UserIMEI."' AND life ='0'";
$db->query($query);
if($db->get_num_rows()!=0)
{
	echo "-2";
	exit;
}

//加入要的商品
foreach($Jsontemp as $Num=>$ItemData)
{	
	$TakenItemID="";
	$NeedValue="";
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
	
	$query="Select * from StoreTakenItem where Store ='".$SerialNumbers."' and TakenItemID ='".$TakenItemID."'";
	$db->query($query);
	$temp=$db->fetch_assoc();
	$LimitQuantity=(int)$temp['LimitQuantity'];
	$TestQuantity=(int)$NeedValue;
	if($NeedValue>$LimitQuantity)
	{
		echo '-2';
		exit;
	}

	$StoreData[]=array('TakenItemID'=>$TakenItemID,'NeedValue'=>$NeedValue,'Life'=>"0");
}

$FinalStoreData=json_encode($StoreData);




//決定要拿的號碼
$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE' ";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "-1";
	exit;
}
$temp=$db->fetch_assoc();
$takevalue=(int)$temp['Value'];
$takevalue++;


//擷取ItemID
$ItemID=$temp['ID'];


//更新號碼
$query="UPDATE ".$SerialNumbers." SET Value=".$takevalue." where ID='".$ItemID."'";
$db->query($query);



$query="INSERT INTO  `custom_information` ( `custom_id`, `store`, `item`, `number`,`SelectItem`,`PhoneNumber`)  VALUES ('".$UserIMEI."','".$SerialNumbers."','".$ItemID."','".$takevalue."','".$FinalStoreData."','".$phoneNubmer."')";
$db->query($query);


//加入到商家商品等待佇列
foreach($Jsontemp as $Num=>$ItemData)
{	
	$TakenItemID="";
	$NeedValue="";
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
	$query="INSERT INTO  `Type2".$ItemID."` ( `ItemID` , `CustomID`,`Quantity`)  VALUES ('".$TakenItemID."','".$UserIMEI."','".$NeedValue."')";
	$db->query($query);
}
	


echo "1";
?>
