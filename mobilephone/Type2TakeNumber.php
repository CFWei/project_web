<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$UserIMEI=$_POST['UserIMEI'];
$CustomItemList=$_POST['CustomItemList'];

$temp=json_decode($CustomItemList);
$i=0;
foreach($temp as $Num=>$ItemData)
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
	$StoreData[]=array('TakenItemID'=>$TakenItemID,'NeedValue'=>$NeedValue);
}

$FinalStoreData=json_encode($StoreData);



$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

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



$query="INSERT INTO  `custom_information` ( `custom_id`, `store`, `item`, `number`,`SelectItem`)  VALUES ('".$UserIMEI."','".$SerialNumbers."','".$ItemID."','".$takevalue."','".$FinalStoreData."')";
$db->query($query);

echo "1";
?>
